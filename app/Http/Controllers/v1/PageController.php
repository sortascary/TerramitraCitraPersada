<?php

namespace App\Http\Controllers\v1;

use App\Models\User;
use App\Models\Content;
use App\Models\ContentView;
use App\Models\Client;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

use App\Http\Resources\auth\UserResource;

use App\Http\Requests\Content\CommentRequest;
use App\Http\Requests\auth\LoginRequest;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home()
    {
        $blogs = Content::with('contentattachments')->latest()->take(3)->get();
        $clients = Client::latest()->take(10)->get();
        return view('Pages.main')->with('blogs', $blogs)->with('clients', $clients);
    }

    public function AboutUs()
    {
        return view('Pages.AboutUs');
    }

    public function Service()
    {
        return view('Pages.Service');
    }

    public function Client()
    {
        $clients = Client::get();
        return view('Pages.Client')->with('clients', $clients);
    }

    public function Blog(Request $request)
    {
        $sort = $request->get('sort', 'Latest');

        $blogs = Content::with('contentAttachments')
            ->when($sort === 'Latest', fn ($q) => $q->orderByDesc('created_at'))
            ->when($sort === 'Oldest', fn ($q) => $q->orderBy('created_at'))
            ->when($sort === 'Popular', fn ($q) => $q->orderByDesc('views'))
            ->paginate(6)
            ->withQueryString();
            
        return view('Pages.Blog')->with('blogs', $blogs);
    }

    public function content( String $id )
    {
        $blog = Content::with('contentattachments')->findOrFail($id);
        $comments = Comment::where("content_id", $id)->get();

        $alreadyViewed = ContentView::where('content_id', $id)
        ->where('ip_address', request()->ip())
        ->whereDate('created_at', today())
        ->exists();

        if (!$alreadyViewed){
            ContentView::create([
                'content_id' => $blog->id,
                'ip_address' => request()->ip(),
            ]);
        }
        
        $blog->increment('views');

        return view('Pages.BlogContent')
                ->with('blog', $blog)
                ->with('comments', $comments);
    }

    public function Contact()
    {
        return view('Pages.Contact');
    }

    public function LoginView()
    {
        return view('Dashboard.Login');
        
    }

    public function RegisterView()
    {
        return view('Dashboard.Register');
        
    }

    public function createCommentWeb(CommentRequest $request, String $id)
    {
        $data = $request->validated();

        $user = $request->user();

        $blog = Content::findOrFail($id);

        DB::beginTransaction();

        try {

            $comment = Comment::create([
                'content_id' => $id,
                'user_id' => $user->id,
                'text' => $data['text'],
            ]);

            DB::commit();

            
            return redirect()->intended('/Blog/'. $id)->with('success', 'Commented on blog successfully.');

        } catch (\Exception $e) {
             DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createCommentApi(CommentRequest $request, String $contentid)
    {
        $data = $request->validated();

        $user = $request->user();

        $blog = Content::findOrFail($contentid);

        DB::beginTransaction();

        try {

            $comment = Comment::create([
                'content_id' => $contentid,
                'user_id' => $user->id,
                'text' => $data['text'],
            ]);

            DB::commit();

            
            return response()->json([
                'message' => 'comment created'
            ], 200);

        } catch (\Exception $e) {
             DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
