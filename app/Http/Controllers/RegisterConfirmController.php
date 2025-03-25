<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterConfirmController extends Controller
{
    //
    public function index()
    {

        return view('login');
    }

    public function confirm(Request $request)
    {
        // 入力データを確認画面に渡す
        $data = $request->all();
        $request->session()->put('register_data', $data);
        return view('registration_confirm', compact('data'));
    }
}
