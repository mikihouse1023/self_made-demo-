<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function user_add()
    {
        return view('admin_user_add');
    }

    public function adduser(Request $request)
    {
        // 入力データのバリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email:rfc,dns|max:255|unique:users,email|unique:admins,email',
            'tel' => 'required|string|max:15',
            'post' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|integer|in:0,1',
        ], [
            'name.required' => 'ユーザー名を入力してください。',
            'name.max' => 'ユーザー名は50文字以内で入力してください。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '正しいメールアドレス形式で入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'tel.required' => '電話番号を入力してください。',
            'tel.digits_between' => '電話番号は10～15桁の半角数字で入力してください。',
            'tel.numeric' => '電話番号は半角数字のみで入力してください。',
            'post.required' => '郵便番号を入力してください。',
            'post.max' => '郵便番号は10文字以内で入力してください。',
            'address.required' => '住所を入力してください。',
            'address.max' => '住所は255文字以内で入力してください。',
            'password.required' => 'パスワードを入力してください',
            'password.confirmed' => 'パスワードが異なります。',
            'user_type.required' => 'ユーザータイプを選択してください。',
            'user_type.in' => 'ユーザータイプが不正です。一般または管理者を選択してください。',
        ]);

        // 保存前にログを出力
        \Log::info('保存前のパスワード値', ['password' => $validated['password']]);


        // ハッシュ化後の値をログに出力
        \Log::info('ハッシュ化後のパスワード値', ['password' => $validated['password']]);

        // ユーザー作成処理
        if ($validated['user_type'] == 1) {
            // 管理者ユーザーを登録
            Admin::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'tel' => $validated['tel'],
                'post' => $validated['post'],
                'address' => $validated['address'],
                'password' => $validated['password'],
                'is_admin' => 1,
            ]);
        } else {
            // 一般ユーザーを登録
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'tel' => $validated['tel'],
                'post' => $validated['post'],
                'address' => $validated['address'],
                'password' => $validated['password'],
                'is_admin' => 0,
            ]);
        }

        // タブ情報を取得
        $tab = $request->input('tab', 'user');

        // リダイレクト時にタブ情報を渡す
        return redirect()->route('admin.index', ['tab' => $tab])->with('success', 'ユーザーを登録しました。');
    }


    public function edituser($id, Request $request)
    {
        // ユーザー情報を取得
        $user = User::find($id); // 一般ユーザー
        if (!$user) {
            $user = Admin::find($id); // 管理ユーザー
        }

        // ユーザーが見つからない場合
        if (!$user) {
            return redirect()->route('admin.index')->with('error', 'ユーザーが見つかりません。');
        }
        $tab = $request->input('tab', 'product');
        return view('admin_user_edit', compact('user'));
    }

    public function updateuser(Request $request, $id)
    {
        \Log::info('Updateuser method called.');
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email:rfc,dns|max:255|unique:users,email|unique:admins,email',
            'tel' => 'required|string|max:15',
            'post' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'user_type' => 'required|integer|in:0,1',
        ], [
            'name.required' => 'ユーザー名を入力してください。',
            'name.max' => 'ユーザー名は50文字以内で入力してください。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '正しいメールアドレス形式で入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'tel.required' => '電話番号を入力してください。',
            'tel.digits_between' => '電話番号は10～15桁の半角数字で入力してください。',
            'tel.numeric' => '電話番号は半角数字のみで入力してください。',
            'post.required' => '郵便番号を入力してください。',
            'post.max' => '郵便番号は10文字以内で入力してください。',
            'address.required' => '住所を入力してください。',
            'address.max' => '住所は255文字以内で入力してください。',
            'user_type.required' => 'ユーザータイプを選択してください。',
            'user_type.in' => 'ユーザータイプが不正です。一般または管理者を選択してください。',
        ]);


        \Log::info('Validation passed.');

        // 現在のユーザー情報を取得
        $user = User::find($id);
        $isAdmin = false;

        if (!$user) {
            $user = Admin::find($id);
            $isAdmin = true;
        }

        if (!$user) {
            return redirect()->route('admin.index')->with('error', 'ユーザーが見つかりません。');
        }

        // 移動が必要かチェック
        if ($validatedData['user_type'] == 1 && !$isAdmin) {
            // 一般ユーザーから管理者に移動
            Admin::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'tel' => $validatedData['tel'],
                'post' => $validatedData['post'],
                'address' => $validatedData['address'],
                'password' => $user->password, // 既存パスワードを保持
                'is_admin' => 1,
            ]);
            $user->delete(); // 一般ユーザーから削除
        } elseif ($validatedData['user_type'] == 0 && $isAdmin) {
            // 管理者から一般ユーザーに移動
            User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'tel' => $validatedData['tel'],
                'post' => $validatedData['post'],
                'address' => $validatedData['address'],
                'password' => $user->password, // 既存パスワードを保持
                'is_admin' => 0,
            ]);
            $user->delete(); // 管理者から削除
        } else {
            // テーブル間の移動が不要な場合
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'tel' => $validatedData['tel'],
                'post' => $validatedData['post'],
                'address' => $validatedData['address'],
            ]);
            $user->is_admin = $validatedData['user_type'];
            $user->save();
        }

        \Log::info('User updated or moved successfully.');
        $tab = $request->input('tab', 'user');
        return redirect()->route('admin.index', ['tab' => $tab])->with('success', 'ユーザー情報を更新しました。');
    }

    public function deleteuser(Request $request, $id)
    {
        $user = User::find($id); // 一般ユーザー
        $isAdmin = false;

        if (!$user) {
            $user = Admin::find($id); // 管理ユーザー
            $isAdmin = true;
        }

        if (!$user) {
            return redirect()->route('admin.index')->with('error', 'ユーザーが見つかりません。');
        }

        $user->delete();

        $message = $isAdmin ? '管理者ユーザーが削除されました。' : '一般ユーザーが削除されました。';
        $tab = $request->input('tab', 'user');
        return redirect()->route('admin.index', ['tab' => $tab])->with('success', $message);
    }



}
