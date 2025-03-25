<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    //
    public function index()
    {

        return view('registration');
    }


    public function register(Request $request)
    {

        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'tel' => 'required|string|max:12',
                'post' => 'required|string|max:7',
                'address' => 'required|string|max:300',
                'password' => 'required|string|min:8|confirmed', // パスワード確認
            ],
            [
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
            ]
        );



        $data = $request->all();
        $request->session()->put('register_data', $data);
        return view('registration_confirm', compact('data'));
    }



}
