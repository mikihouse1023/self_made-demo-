<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CouponController extends Controller
{

    public function viewStamps()
    {
        $user = Auth::user();
        $stamps = $user->stamps; // ユーザーのスタンプ数を取得

        // ✅ 使用可能なクーポンのみ取得
        $coupons = Coupon::where('user_id', $user->id)
            ->whereNull('used_at') // 未使用のクーポンのみ
            ->get();

        // 取得済みのスタンプ情報
        $redeemedStamps = $user->redeemed_stamps ? json_decode($user->redeemed_stamps, true) : [];

        return view('stamp', compact('stamps', 'redeemedStamps', 'coupons'));
    }

    public function redeemCoupon(Request $request)
    {
        $user = Auth::user();
        Log::info("redeemCoupon メソッドが実行されました", ['user_id' => $user->id]);

        $stamps = $user->stamps;
        Log::info("現在のスタンプ数: " . $stamps);

        // ✅ `json_decode()` を使って正しく配列として取得
        $redeemedStamps = json_decode($user->redeemed_stamps ?? '[]', true);
        Log::info("取得済みのクーポン履歴", ['redeemedStamps' => $redeemedStamps]);

        // ✅ 取得すべきスタンプの `5 の倍数` をリストアップ
        $eligibleStamps = [];
        for ($i = 5; $i <= $stamps; $i += 5) {
            if (!in_array($i, $redeemedStamps, true)) {
                $eligibleStamps[] = $i;
            }
        }

        // ✅ 取得すべきクーポンがある場合にクーポン発行
        if (!empty($eligibleStamps)) {
            foreach ($eligibleStamps as $stampValue) {
                Log::info("クーポン発行対象: スタンプ {$stampValue} 個");

                // クーポン発行
                $coupon = Coupon::create([
                    'user_id' => $user->id,
                    'code' => strtoupper(bin2hex(random_bytes(5))), // ランダムな10文字のコード
                    'discount_type' => 'fixed',
                    'discount_value' => 200,
                    'expires_at' => now()->addDays(30),
                ]);

                Log::info("クーポン発行成功", ['coupon_code' => $coupon->code]);

                // ✅ 取得済みリストに追加
                $redeemedStamps[] = $stampValue;
            }

            // ✅ `json_encode()` して保存
            $user->redeemed_stamps = json_encode($redeemedStamps);
            $user->save();

            return redirect()->route('stamps.view')->with('success', 'クーポンを取得しました！');
        }

        Log::warning("クーポン取得条件を満たしていません");

        return redirect()->route('stamps.view')->with('error', 'このスタンプ数ではクーポンを取得できません。');
    }
}
