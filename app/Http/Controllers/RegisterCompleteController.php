<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterCompleteController extends Controller
{
    //
    public function index()
    {

        return view('login');
    }

    
    public function complete(Request $request)
    {
        // セッションからデータを取得
        $data = $request->session()->get('register_data');

        // データベースに保存
        if ($data) {

            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'tel' => $data['tel'],
                'post' => $data['post'],
                'address' => $data['address'],
                'password' => $data['password'],
                'is_admin' => 0, // 一般ユーザー
            ]);

            // セッションからデータを削除(次回のリクエスト時に古いデータが残らないようにする)
            $request->session()->forget('register_data');
        }

        // 完了画面を表示
        return view('registration_complete', ['data' => $data]);
    }
}
