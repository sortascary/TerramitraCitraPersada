<?php

namespace App\Http\Controllers\v1;

use App\Events\MessageSent;
use App\Events\MessageDelete;
use App\Events\MessageVoted;
use App\Notifications\NewChatMessage;

use App\Models\Forum;
use App\Models\ForumAccess;
use App\Models\MessageForum;
use App\Models\MessageAttachment;
use App\Models\PollOption;
use App\Models\PollVote;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

use App\Http\Resources\ForumResource;
use App\Http\Resources\MessageResource;

use App\Http\Requests\Forum\ForumMessageRequest;
use App\Http\Requests\Forum\VoteRequest;

class ChatController extends Controller
{
    public function getChats()
    {
        $user = Auth::user();
        $forums = $user->forumaccess
        ->load('forum')
        ->pluck('forum');
        // $forums = Forum::with('messageforum')->get();

        return response()->json([
                'message' => 'forums found',
                'data' => ForumResource::collection($forums)
            ], 200);
    }

    public function getChatsApi(Request $request)
    {
        $user = $request->user();
        $forums = $user->forumaccess
        ->load('forum')
        ->pluck('forum');

        return response()->json([
                'message' => 'forums found',
                'data' => $forums
            ], 200);
    }

    public function getMessages(Request $request, String $id)
    {
        // $user = $request->user();
        // $messages = MessageForum::get();
        $messages = MessageForum::where('forum_id', $id)->orderBy('created_at', 'desc')->with('attachments')->paginate(20);

        $request->user()->unreadNotifications()->where('data->forum_id', $id)->get()->each->markAsRead();

        return response()->json([
            'success' => true,
            'data' => MessageResource::collection($messages->reverse()),
            'next_page' => $messages->nextPageUrl() ? $messages->currentPage() + 1 : null
        ]);
    }

    public function sendMessage(ForumMessageRequest $request)
    {
        $data = $request->validated();

        $user = $request->user();

        DB::beginTransaction();

        try{
            
            $message = MessageForum::create([
                'user_id' => $user->id,
                'forum_id' => $data['forum_id'],
                'message' => $data['message'],
                'message_id' => $data['message_id']?? null,
                'message_type' => $data['message_type'],
            ]);
                
            if ($data['message_type'] === 'poll' && isset($data['poll'])) {
                foreach ($data['poll']['options'] as $option) {
                    PollOption::create([
                        'message_id' => $message->id, 
                        'option' => $option
                    ]);
                }
            }

            if ($request->hasFile('attachments')) {

                foreach ($request->file('attachments') as $attachment) {

                    $mimeType = $attachment->getMimeType();

                    $fileType = str_starts_with($mimeType, 'image/')
                        ? 'image'
                        : 'doc';

                    $originalName = Str::slug(
                        pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME)
                    );

                    $filename = $originalName . '_' . Str::uuid() . '.' . $attachment->getClientOriginalExtension();

                    $path = $attachment->storeAs('forums', $filename, 'public');

                    MessageAttachment::create([
                        'message_id' => $message->id,
                        'file' => $path,
                        'type' => $fileType,
                        'name' => $originalName . '.' . $attachment->getClientOriginalExtension(),
                        'size' => $attachment->getSize(),
                    ]);
                }
            }
    
            $forum = Forum::findOrFail($data['forum_id']);
            $forum->update(['message_id' => $message->id]);

            DB::commit();

            broadcast(new MessageSent($message))->toOthers();

            $forumMembers = $forum->users()
                ->where('users.id', '!=', $user->id)
                ->get();

            foreach ($forumMembers as $member) {
                $member->notify(new NewChatMessage($message));
            }
    
            return response()->json([
                'success' => true,
                'data' => new MessageResource($message)
            ], 200);
        }catch (\Exception $e) {
             DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function vote(VoteRequest $request) {
        $data = $request->validated();

        $userId = auth()->id();

        // remove existing vote in this poll
        $optionIds = PollOption::where('message_id', $data['message_id'])->pluck('id');
        PollVote::whereIn('option_id', $optionIds)->where('user_id', $userId)->delete();

        // add new vote
        PollVote::create(['option_id' => $data['option_id'], 'user_id' => $userId]);

        $forumId = MessageForum::findOrFail($data['message_id'])->forum_id;

        $options = PollOption::where('message_id', $data['message_id'])
            ->with(['pollvotes.user'])
            ->get()
            ->map(fn($o) => [
                'id' => $o->id,
                'option' => $o->option,
                'votes_count' => $o->pollvotes->count(),
                'user_voted' => $o->pollvotes->where('user_id', auth()->id())->isNotEmpty(),
                'voters' => $o->pollvotes->map(fn($v) => ['name' => $v->user->name])
            ]);

            broadcast(new MessageVoted(
                $forumId,
                $data['message_id'],
                $options->toArray(),
                $options->sum('votes_count')
            ))->toOthers();

        return response()->json(['success' => true, 'options' => $options]);
    }

    public function deleteMessage(String $id){

        $message = MessageForum::findOrFail($id);
        $files = MessageAttachment::where('message_id', $id)->get();

        DB::beginTransaction();
    
        if ($message->user_id !== auth()->id() && auth()->user()->role->role !== 'Admin' && auth()->user()->role->role !== 'Moderator') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        try{

            if ($files){
                foreach ($files as $file){
                    if (File::exists(public_path($file->file))) {
                        File::delete(public_path($file->file));
                    }
                }
            }

            $forumId = $message->forum_id;

            broadcast(new MessageDelete(
                $forumId,
                $id
            ))->toOthers();

            $message->delete();

            DB::commit();

        }catch (\Exception $e) {
             DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }

        $messages = MessageForum::where('forum_id', $forumId)->get();
        return response()->json(['success' => true, 'data' => MessageResource::collection($messages)]);
    }
}
