<?php

namespace App\Http\Controllers\v1;

use App\Events\MessageSent;

use App\Models\Forum;
use App\Models\ForumAccess;
use App\Models\MessageForum;
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
        $messages = MessageForum::with('attachments')->where('forum_id', $id)->get();

        return response()->json([
            'message' => 'messages found',
            'data' => MessageResource::collection($messages)
        ], 200);
    }

    public function sendMessage(ForumMessageRequest $request)
    {
        $data = $request->validated();

        $user = $request->user();
        $message = MessageForum::create([
            'user_id' => $user->id,
            'forum_id' => $data['forum_id'],
            'message' => $data['message'],
            'message_type' => $data['message_type'],
        ]);

        if ($request->has('attachments')) {

            foreach ($request->file('attachments') as $attachment) {

                if (isset($attachment['file'])) {

                    $originalName = pathinfo(
                        $attachment->getClientOriginalName(),
                        PATHINFO_FILENAME
                    );

                    $originalName = Str::slug($originalName);

                    $filename = $originalName . '_' . Str::uuid() . '.' . $attachment->getClientOriginalExtension();

                    $path = $attachment->storeAs(
                        'MessageAttachment',
                        $filename,
                        'public'
                    );

                    // Save to DB
                    MessageAttachment::create([
                        'message_id' => $message->id,
                        'file' => $path,
                        'name' => $originalName.'.'. $attachment->getClientOriginalExtension(),
                        'file_type' => $file->getClientMimeType(),
                    ]);
                }
            }
        }

        $forum = Forum::findOrFail($data['forum_id']);
        $forum->update([
            'message_id' => $message->id,
        ]);

        broadcast(new MessageSent($message))->toOthers();
        
        $messages = MessageForum::where('forum_id', $data['forum_id'])->get();

        return response()->json([
            'success' => true,
            'data' => MessageResource::collection($messages)
        ], 200);
    }
}
