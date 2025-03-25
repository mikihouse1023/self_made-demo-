<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // バリデーション
        $request->validate([
            'email' => 'required|email:rfc,dns',
            'password' => 'required|string|min:8',
        ], [
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '正しいメールアドレス形式で入力してください。',
            'password.required' => 'パスワードを入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
        ]);

        // 認証（Auth::attempt を使用）
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => '認証に失敗しました。メールアドレスまたはパスワードが正しくありません。'
            ], 401);
        }

        // 認証成功時のユーザー情報
        $user = Auth::user();

        // アクセストークンの発行（Sanctum使用）
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'message' => 'ログイン成功',
            'user' => $user->makeHidden(['password']), // `password` を隠す
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        // トークンが存在するか確認
        if ($request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'ログアウトしました'], 200);
        }

        return response()->json(['message' => 'すでにログアウト済みです'], 400);
    }
}
