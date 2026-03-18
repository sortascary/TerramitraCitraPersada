<?php

namespace App\Http\Controllers\v1;

use App\Models\User;
use App\Models\Forum;
use App\Models\ForumAccess;
use App\Models\UserLog;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;


use App\Http\Resources\UserResource;

use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;

class AuthController extends Controller
{
    public function LoginWeb(LoginRequest $request)
    {
        $validated = $request->validated();
        $remember = $request->boolean('remember');
        $credentials = $request->only('email', 'password');


        if (!Auth::attempt($credentials, $remember)) {
            return back()->withErrors([
                'email' => 'Invalid credentials',
            ]);
        }

        $request->session()->regenerate();

        UserLog::create([
            'user_id' => Auth::id(),
            'logged_in_at' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        if(Auth::user()->role->role == 'User'){
            return redirect('/');
        }else{
            return redirect()->intended('/Dashboard');
        }
        
    }

    public function LoginApi(LoginRequest $request)
    {
        $validated = $request->validated();

        $remember = $request->boolean('remember');
        $credentials = $request->only('email', 'password');


        if (!Auth::attempt($credentials, $remember)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ]);
        }

        $user = User::where('email', $validated['email'])->first();

        $token = $user->createToken('auth_token')->plainTextToken;


        UserLog::create([
            'user_id' => Auth::id(),
            'logged_in_at' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return response()->json([
            'message' => 'Login successful',
            'data' => new UserResource($user),
            'token' => $token
        ]);
    }
    

    public function registerWeb(RegisterRequest $request)
    {
        $data = $request->validated();

        $userexist = User::where('email', $data['email'])->first();

        if ($userexist && $userexist->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email sudah digunakan.',
            ], 409);
        }
        
        if ($userexist){
            $userexist->update([
                'name' => $data['name'],
                'role_id' => "1",
                'password' => Hash::make($data['password']),
            ]);
            $user = $userexist;
        } else {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role_id' => "1",
                'password' => Hash::make($data['password']),
            ]);

            $forum = Forum::where('name', 'Public Forum')->first();

            if ($forum){
                ForumAccess::create([
                    'forum_id' => $forum->id,
                    'user_id' => $user->id
                ]);
            }
        }

        $user->sendEmailVerificationNotification();
        
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'User created successfully. Check your email for verification link.',
                'data' => new UserResource($user),
                'token' => $user->createToken('auth_token')->plainTextToken,
            ], 201);
        }

        return redirect('/linkSent');
    }

    public function registerApi(RegisterRequest $request)
    {
        $data = $request->validated();

        $userexist = User::where('email', $data['email'])->first();

        if ($userexist && $userexist->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email sudah digunakan.',
            ], 409);
        }
        
        if ($userexist){
            $userexist->update([
                'name' => $data['name'],
                'role_id' => $data['role_id'],
                'password' => Hash::make($data['password']),
            ]);
            $user = $userexist;
        } else {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role_id' => $data['role_id'],
                'password' => Hash::make($data['password']),
            ]);
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'User created successfully. Check your email for verification link.',
            'data' => new UserResource($user),
            'token' => $user->createToken('auth_token')->plainTextToken,
        ], 201);
    }

    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerate();
        
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Logout successful.'
            ], 200);
        }

        return redirect('/');
    }

    public function LinkSent(){

        return view('Dashboard.EmailSent', [
            'message' => 'Successfully verified your email',
            'success' => true
        ]);
        
    }

    public function verify(Request $request, $id, $hash)
    {
        if (!$request->hasValidSignature()) {
            return view('Dashboard.Verify', [
                'message' => 'Invalid or expired link',
                'success' => false
            ]);
        }

        $user = User::findOrFail($id);

        if ($user->hasVerifiedEmail()) {
            return view('Dashboard.Verify', [
                'message' => 'User is already verified',
                'success' => false
            ]);
        }

        if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            return view('Dashboard.Verify', [
                'message' => 'Invalid credentials/data',
                'success' => false
            ]);
        }

        $user->markEmailAsVerified();
        // event(new Verified($user));

        Auth::login($user);

        if ($user->role->role == 'Admin' || $user->role->role == 'Konten' || $user->role->role == 'Moderator') {
            return redirect('/Dashboard');
        } else {
            return redirect()->intended('/');
        }
    }
    
}
