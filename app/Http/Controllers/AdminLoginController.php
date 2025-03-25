<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{

     //管理ユーザーログイン
     public function admin_index()
     {
         //
         return view('admin_login');
     }

    public function admin_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'password.required' => 'パスワードを入力してください。',
        ]);
    
        // メールアドレスで管理者を検索
        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return back()->withErrors(['email' => '該当するメールアドレスが見つかりません'])->withInput();
        }
    
        // Guard を使用してログインを試行
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::guard('admin')->user();
            if ($user->is_admin) {
                return redirect()->route('admin.index');
            } else {
                Auth::guard('admin')->logout();
                return back()->withErrors(['email' => '許可されていないユーザーです']);
            }
        } else {
            \Log::info('ログイン失敗', ['email' => $request->email]);
            return back()->withErrors(['email' => 'メールアドレスまたはパスワードが間違っています']);
        }
    }

}