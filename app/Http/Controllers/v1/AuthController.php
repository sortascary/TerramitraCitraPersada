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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


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

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $result = $response->json();

        if (!$result['success']) {
            return back()->withErrors([
                'captcha' => 'reCAPTCHA verification failed. Please try again.'
            ]);
        }

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

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $result = $response->json();

        if (!$result['success']) {
            return back()->withErrors([
                'captcha' => 'reCAPTCHA verification failed. Please try again.'
            ]);
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

            $forum = Forum::firstOrCreate([
                'name' => 'Public Forum'
            ]);

            ForumAccess::firstOrCreate([
                'forum_id' => $forum->id,
                'user_id' => $user->id
            ]);
        }

        $user->sendEmailVerificationNotification();
        
        // if ($request->expectsJson()) {
        //     return response()->json([
        //         'message' => 'User created successfully. Check your email for verification link.',
        //         'data' => new UserResource($user),
        //         'token' => $user->createToken('auth_token')->plainTextToken,
        //     ], 201);
        // }

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

        // return response()->json([
        //     'message' => 'User created successfully. Check your email for verification link.',
        //     'data' => new UserResource($user),
        //     'token' => $user->createToken('auth_token')->plainTextToken,
        // ], 201);
        return redirect('/linkSent');
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
            'message' => 'Successfully sent to your email',
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

        Auth::login($user);

        if ($user->role->role == 'Admin' || $user->role->role == 'Konten' || $user->role->role == 'Moderator') {
            return redirect('/Dashboard');
        } else {
            return redirect()->intended('/');
        }
    }

    public function sendResetToken(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email'
        ]);

        
        $status = Password::sendResetLink(['email' => $request->email]);

        return $status === Password::RESET_LINK_SENT
            ?view('Dashboard.EmailSent', [
                'message' => 'Successfully sent to your email',
                'success' => true
            ]):view('Dashboard.EmailSent', [
                'message' => 'Unable to send reset token try again later',
                'success' => false
            ]);
    }

    public function resetPage($token) {
        return view('Dashboard.ResetPassword', [
            'token' => $token
        ]);
    }

    public function reset(Request $request)
    {
        $data = $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = null;

        $status = Password::reset(
            $data,
            function ($u, $password) use (&$user) {
                $u->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user = $u;
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            return response()->json([
                'message' => __($status)
            ], 400);
        }

        return redirect()->intended('/');
    }
}
