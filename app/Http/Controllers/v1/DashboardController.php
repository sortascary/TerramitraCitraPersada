<?php

namespace App\Http\Controllers\v1;

use App\Models\User;
use App\Models\Content;
use App\Models\ContentView;
use App\Models\ContentAttachment;
use App\Models\Client;
use App\Models\Forum;
use App\Models\MessageForum;
use App\Models\ForumAccess;
use App\Models\Comment;
use App\Models\Setting;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Carbon; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;


use App\Http\Requests\Forum\ForumRequest;
use App\Http\Requests\Forum\UpdateForumRequest;
use App\Http\Requests\Content\ContentRequest;
use App\Http\Requests\Content\ContentUpdateRequest;
use App\Http\Requests\Content\ClientRequest;
use App\Http\Requests\Content\ClientUpdateRequest;
use App\Http\Requests\auth\UserRequest;
use App\Http\Requests\auth\UpdateUserRequest;

use App\Http\Resources\UserResource;
use App\Http\Resources\ForumResource;
use App\Http\Resources\ClientResource;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function AdminDashboard()
    {
        $userCount = User::count();
        $contentCount = Content::count();
        $forumCount = Forum::count();
        $commentCount = Comment::count();
        $userUsage = User::count();

        $logins = DB::table('user_logs')
            ->selectRaw('DATE(logged_in_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();


        return view('Dashboard.DashboardAdmin')
            ->with('userCount', $userCount)
            ->with('contentCount', $contentCount)
            ->with('forumCount', $forumCount)
            ->with('commentCount', $commentCount)
            ->with('logins', $logins);
    }

    public function dashboardUser(Request $request)
    {
        $userCount = User::count();
        $userVerifiedCount = User::where('email_verified_at', '!=', null)->count();
        $userUnverifiedCount = User::where('email_verified_at', null)->count();
        $data = User::query();

        if ($request->filled('search')) {
            $data->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $data->paginate(10);

        return view('Dashboard.DashboardData.Users')
            ->with('userCount', $userCount)
            ->with('userVerifiedCount', $userVerifiedCount)
            ->with('userUnverifiedCount', $userUnverifiedCount)
            ->with('users', $users);
    }

    public function dashboardUserAdd()
    {
        $roles = DB::table('roles')->get();
        return view('Dashboard.DashboardData.User.UserAdd')->with('roles', $roles);
    }

    public function dashboardUserInfo(String $id)
    {
        $user = User::where('id', $id)->first();
        return view('Dashboard.DashboardData.User.UserInfo')
            ->with('user', $user);
    }

    public function dashboardUserEdit(String $id)
    {
        $user = User::where('id', $id)->first();
        $roles = DB::table('roles')->get();
        return view('Dashboard.DashboardData.User.UserEdit')
            ->with('user', $user)
            ->with('roles', $roles);
    }

    public function dashboardUserSetting(String $id)
    {
        $user = User::where('id', $id)->first();
        $roles = DB::table('roles')->get();
        return view('Dashboard.DashboardData.UserSetting')
            ->with('user', $user)
            ->with('roles', $roles);
    }

    public function dashboardBlog(Request $request)
    {
        $data = Content::query();
        $contentCount = $data->count();
        $viewCount = ContentView::count();
        $viewDayCount = ContentView::where('created_at', '>=', Carbon::today())->count();
        $viewWeekCount = ContentView::where('created_at', '>=', Carbon::now()->startOfWeek())->count();
        $viewMonthCount = ContentView::where('created_at', '>=', Carbon::now()->startOfMonth())->count();

        if ($request->filled('search')) {
            $data->where('title', 'like', '%' . $request->search . '%');
        }

        $contents = $data->paginate(10);

        return view('Dashboard.DashboardData.Blog')
            ->with('contents', $contents)
            ->with('viewCount', $viewCount)
            ->with('viewDayCount', $viewDayCount)
            ->with('viewWeekCount', $viewWeekCount)
            ->with('viewMonthCount', $viewMonthCount)
            ->with('contentCount', $contentCount);
    }

    public function dashboardBlogAdd()
    {
        return view('Dashboard.DashboardData.Blog.BlogAdd');
    }

    public function dashboardBlogEdit(string $id)
    {
        $blog = Content::with('contentattachments')->find($id);
        $Attachments = ContentAttachment::where('content_id', $id)->get();
        $CommentCount = Comment::where('content_id', $id)->count();
        $views = ContentView::where('content_id', $id)->selectRaw('DATE(created_at) as date, COUNT(*) as total')->groupBy('date')->orderBy('date')->get();
        $viewCount = ContentView::where('content_id', $id)->count();
        $viewDayCount = ContentView::where('content_id', $id)->where('created_at', '>=', Carbon::today())->count();
        $viewWeekCount = ContentView::where('content_id', $id)->where('created_at', '>=', Carbon::now()->startOfWeek())->count();
        $viewMonthCount = ContentView::where('content_id', $id)->where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        return view('Dashboard.DashboardData.Blog.BlogEdit')
                    ->with('Attachments', $Attachments)
                    ->with('views', $views)
                    ->with('viewCount', $viewCount)
                    ->with('viewDayCount', $viewDayCount)
                    ->with('viewWeekCount', $viewWeekCount)
                    ->with('viewMonthCount', $viewMonthCount)
                    ->with('CommentCount', $CommentCount)
                    ->with('blog', $blog);
    }


    public function dashboardComment(Request $request)
    {
        $data = Comment::with('user', 'blog');

        if ($request->filled('search')) {
            $data->where(function ($query) use ($request) {

            $query->where('text', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function ($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('blog', function ($q) use ($request) {
                      $q->where('title', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $comments = $data->paginate(10);
        $commentCount = Comment::count();
        $commentData = Comment::selectRaw('DATE(created_at) as date, COUNT(*) as total')->groupBy('date')->orderBy('date')->get();
        $commentTodayCount = Comment::where('created_at', Carbon::today())->count();
        return view('Dashboard.DashboardData.Comment')
            ->with('commentData', $commentData)
            ->with('commentCount', $commentCount)
            ->with('commentTodayCount', $commentTodayCount)
            ->with('comments', $comments);
    }

    public function dashboardClient(Request $request)
    {
        $data = Client::query();
        $clientCount = $data->Count();

        if ($request->filled('search')) {
            $data->where('name', 'like', '%' . $request->search . '%');
        }

        $clients = $data->paginate(10);

        return view('Dashboard.DashboardData.Client')
            ->with('clientCount', $clientCount)
            ->with('clients', $clients);
    }

    public function dashboardClientEdit(String $id)
    {
        $client = Client::where('id', $id)->first();
        return view('Dashboard.DashboardData.Client.ClientEdit')
            ->with('client', $client);
    }

    public function dashboardClientAdd()
    {
        return view('Dashboard.DashboardData.Client.ClientAdd');
    }

    public function dashboardForum(Request $request)
    {
        $data = Forum::with('forumaccess', 'messageforum');
        $forumCount = $data->Count();

        if ($request->filled('search')) {
            $data->where(function ($query) use ($request) {

            $query->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $forums = $data->paginate(10);
        return view('Dashboard.DashboardData.Forum')
            ->with('forumCount', $forumCount)
            ->with('forums', $forums);
    }

    public function dashboardForumInfo(String $id)
    {
        $forum = Forum::with('users', 'messageforum')->where('id', $id)->first();

        $messages = MessageForum::withTrashed()->where('forum_id', $id)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        return view('Dashboard.DashboardData.Forum.ForumInfo')
                ->with('messages', $messages)
                ->with('forum', $forum);
    }

    public function dashboardForumEdit(String $id)
    {
        $forum = Forum::with('users')->where('id', $id)->first();
        $users = User::get();
        return view('Dashboard.DashboardData.Forum.ForumEdit')
                ->with('users', $users)
                ->with('forum', $forum);
    }

    public function dashboardForumAdd()
    {
        $users = User::get();
        return view('Dashboard.DashboardData.Forum.ForumAdd')
                ->with('users', $users);
    }

    public function dashboardSettings()
    {
        return view('Dashboard.DashboardData.Settings');
    }

    public function UpdateTitle(Request $request)
    {
        $data = $request->validate([
            'site_name' => 'required|string'
        ]);

        Setting::updateOrCreate(
            ['key' => 'site_name'],
            ['value' => $request->site_name]
        );

        return back()->with('success', 'Settings saved.');
    }

    public function CreateUser(UserRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();

        try {

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role_id' => $data['role_id'],
                'password' => Hash::make($data['password']),
            ]);

            if ($request->hasFile('image')) {
                $filename = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();

                $path = $request->file('image')->storeAs(
                    'profiles',
                    $filename,
                    'public'
                );

                // Save image path
                $user->update([
                    'image' => 'storage/' . $path,
                ]);
            }

            DB::commit();

            
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'User created successfully',
                    'data' => new UserResource($user),
                ], 201);
            }

            return redirect()->intended('/Dashboard/User')->with('success', 'User updated successfully.');

        } catch (\Exception $e) {
             DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function UpdateUser(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $data = $request->validated();

        $oldImage = $user->image;

        DB::beginTransaction();

        try{
            $user->fill($data);

            if ($request->hasFile('image')) {
                if ($oldImage) {
                    Storage::disk('public')->delete(
                        str_replace('storage/', '', $oldImage)
                    );
                }
                $filename = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();

                $path = $request->file('image')->storeAs(
                    'profiles',
                    $filename,
                    'public'
                );

                // Save image path
                $user->update([
                    'image' => 'storage/' . $path,
                ]);
            }

            $user->save();

            DB::commit();

            return redirect()->intended('/Dashboard/User')->with('success', 'User updated successfully.');


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function UpdateSetting(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $data = $request->validated();

        $oldImage = $user->image;

        DB::beginTransaction();

        try{
            $user->fill($data);

            if ($request->hasFile('image')) {
                if ($oldImage) {
                    Storage::disk('public')->delete(
                        str_replace('storage/', '', $oldImage)
                    );
                }
                $filename = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();

                $path = $request->file('image')->storeAs(
                    'profiles',
                    $filename,
                    'public'
                );

                // Save image path
                $user->update([
                    'image' => 'storage/' . $path,
                ]);
            }

            $user->save();

            DB::commit();

            return redirect()->intended('/Dashboard/Settings')->with('success', 'User updated successfully.');


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function DeleteUser(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        if (File::exists(public_path($user->image))) {
            File::delete(public_path($user->image));
        }

        $user->delete();

        return redirect()->intended('/Dashboard/User')->with('success', 'Client updated successfully.');
    }

    public function CreateContent(ContentRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();

        try {

            $content = Content::create([
                'title' => $data['title'],
                'desc' => $data['desc'],
                'user_id' =>$request->user()->id
            ]);

            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $file) {

                    $originalName = pathinfo(
                        $file->getClientOriginalName(),
                        PATHINFO_FILENAME
                    );

                    $originalName = Str::slug($originalName);

                    $filename = $originalName . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();

                    $path = $file->storeAs(
                        'blogs',
                        $filename,
                        'public'
                    );

                    ContentAttachment::create([
                        'file' => 'storage/' . $path,
                        'content_id' => $content->id
                    ]);
                }
            }

            DB::commit();

            return redirect()->intended('/Dashboard/Blog')->with('success', 'Blog Created successfully.');

        } catch (\Exception $e) {
             DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function UpdateContent(ContentUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $content = Content::with('contentattachments')->find($id);

        if (!$content) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        DB::beginTransaction();

        try{

            $content->update([
                'title' => $request->title,
                'desc' => $request->desc,
            ]);
    
            $existingImageIds = $request->existing_images ?? [];
    
            $content->contentattachments()
                ->whereNotIn('id', $existingImageIds)
                ->get()
                ->each(function ($attachment) {
                    
                    if (File::exists(public_path($attachment->file))) {
                        File::delete(public_path($attachment->file));
                    }
                    Storage::disk('public')->delete($attachment->file);
                    
    
                    $attachment->delete();
                });
    
            if ($request->hasFile('images')) {
    
                foreach ($request->file('images') as $file) {

                    $originalName = pathinfo(
                        $file->getClientOriginalName(),
                        PATHINFO_FILENAME
                    );

                    $originalName = Str::slug($originalName);

                    $filename = $originalName . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();

                    $path = $file->storeAs(
                        'blogs',
                        $filename,
                        'public'
                    );

                    ContentAttachment::create([
                        'file' => 'storage/' . $path,
                        'content_id' => $content->id
                    ]);
                }
            }

            DB::commit();

            return redirect()->intended('/Dashboard/Blog')->with('success', 'Blog Updated successfully.');

        } catch (\Exception $e) {
             DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function DeleteContent(string $id)
    {
        $content = Content::find($id);
        $Attachments = ContentAttachment::where('content_id', $id)->get();

        if (!$content) {
            return response()->json(['message' => 'Content not found'], 404);
        }

        if ($Attachments){
            foreach ($Attachments as $Attachment){
                if (File::exists(public_path($Attachment->file))) {
                    File::delete(public_path($Attachment->file));
                }
            }
        }

        $content->delete();

        return redirect()->intended('/Dashboard/Blog')->with('success', 'Content updated successfully.');
    }

    public function DeleteComment(string $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment->delete();

        return redirect()->intended('/Dashboard/Comment')->with('success', 'Comment updated successfully.');
    }

    //TODO: CRUD FORUM
    public function CreateForum(ForumRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {

            $forum = Forum::create([
                'name' => $data['name'],
            ]);

            foreach ($data['users'] as $user) {
                ForumAccess::create([
                    'user_id' => $user['user_id'],
                    'forum_id' => $forum->id
                ]);
            }

            DB::commit();

            // return response()->json([
            //     'message' => 'Forum created successfully',
            //     'data' => new ForumResource($forum)
            // ], 201);

            return redirect()->intended('/Dashboard/Forum')->with('success', 'Forum created successfully.');

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function UpdateForum(UpdateForumRequest $request, string $id)
    {
        $forum = Forum::find($id);

        if (!$forum) {
            return response()->json(['message' => 'Porum not found'], 404);
        }

        $data = $request->validated();

        $oldImage = $forum->image;

        DB::beginTransaction();

        try{

            // foreach ($data['users'] as $user) {
            //     $accessExist = ForumAccess::where('user_id', $user['user_id'])->where('forum_id', $id)->first();
            //     if (!$accessExist){
            //         ForumAccess::create([
            //             'user_id' => $user['user_id'],
            //             'forum_id' => $id
            //         ]); 
            //     }
            // }

            $userIds = collect($data['users'])->pluck('user_id')->toArray();
            $forum->users()->sync($userIds);

            if ($request->hasFile('image')) {
                if ($oldImage) {
                    Storage::disk('public')->delete(
                        str_replace('storage/', '', $oldImage)
                    );
                }
                $filename = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();

                $path = $request->file('image')->storeAs(
                    'forums',
                    $filename,
                    'public'
                );  

                // Save image path
                $forum->update([
                    'image' => 'storage/' . $path,
                ]);
            }

            $forum->save();

            DB::commit();

            return redirect()->intended('/Dashboard/Forum')->with('success', 'Forum updated successfully.');


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function DeleteForum(string $id)
    {
        $forum = Forum::find($id);

        if (!$forum) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        if (File::exists(public_path($forum->image))) {
            File::delete(public_path($forum->image));
        }

        $accesses = ForumAccess::where('forum_id', $id)->get();

        foreach ($accesses as $access){
            $access->delete();
        }

        $forum->delete();

        return redirect()->intended('/Dashboard/Forum')->with('success', 'Client updated successfully.');
    }

    public function DeleteChat(string $id)
    {
        $forum = Forum::find($id);

        if (!$forum) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $messages = MessageForum::where('forum_id', $id)->get();

        foreach ($messages as $message){
            $message->delete();
        }

        return redirect()->intended('/Dashboard/Forum/info/'.$id)->with('success', 'Client updated successfully.');
    }

    public function CreateClientApi(ClientRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();

        try {

            $client = Client::create([
                'name' => $data['name'],
            ]);

            if ($request->hasFile('image')) {
                $filename = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();

                $path = $request->file('image')->storeAs(
                    'clients',
                    $filename,
                    'public'
                );

                $client->update([
                    'image' => 'storage/' . $path,
                ]);
            }

            DB::commit();

            
            return response()->json([
                'message' => 'Client created successfully',
                'data' => new ClientResource($client),
            ], 201);

        } catch (\Exception $e) {
             DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function CreateClientWeb(ClientRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();

        try {

            $client = Client::create([
                'name' => $data['name'],
            ]);

            if ($request->hasFile('image')) {
                $filename = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();

                $path = $request->file('image')->storeAs(
                    'clients',
                    $filename,
                    'public'
                );

                $client->update([
                    'image' => 'storage/' . $path,
                ]);
            }

            DB::commit();

            
            return redirect()->intended('/Dashboard/Client')->with('success', 'Client updated successfully.');

        } catch (\Exception $e) {
             DB::rollback();
            return back()->withErrors([
                'email' => 'Invalid credentials',
            ]);
        }
    }

    public function UpdateClientWeb(ClientUpdateRequest $request, string $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $data = $request->validated();

        $oldImage = $client->image;

        DB::beginTransaction();

        try{
            $client->fill($data);

            if ($request->hasFile('image')) {
                if ($oldImage) {
                    Storage::disk('public')->delete(
                        str_replace('storage/', '', $oldImage)
                    );
                }
                $filename = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();

                $path = $request->file('image')->storeAs(
                    'clients',
                    $filename,
                    'public'
                );

                // Save image path
                $client->update([
                    'image' => 'storage/' . $path,
                ]);
            }

            $client->save();

            DB::commit();

            return redirect()->intended('/Dashboard/Client')->with('success', 'Client updated successfully.');


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function UpdateClientApi(ClientUpdateRequest $request, string $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $data = $request->validated();

        $oldImage = $client->image;

        DB::beginTransaction();

        try{
            $client->fill($data);

            if ($request->hasFile('image')) {
                if ($oldImage) {
                    Storage::disk('public')->delete(
                        str_replace('storage/', '', $oldImage)
                    );
                }
                $filename = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();

                $path = $request->file('image')->storeAs(
                    'clients',
                    $filename,
                    'public'
                );

                // Save image path
                $client->update([
                    'image' => 'storage/' . $path,
                ]);
            }

            $client->save();

            DB::commit();

            return response()->json([
                'message' => 'Client updated successfully',
                'data' => new ClientResource($client)
            ]);


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function DeleteClientWeb(string $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        if (File::exists(public_path($client->image))) {
            File::delete(public_path($client->image));
        }

        $client->delete();

        return redirect()->intended('/Dashboard/Client')->with('success', 'Client updated successfully.');
    }

    public function DeleteClientApi(string $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        if (File::exists(public_path($client->image))) {
            File::delete(public_path($client->image));
        }

        $client->delete();

        return response()->json(['message' => 'Client deleted successfully']);
    }
}
