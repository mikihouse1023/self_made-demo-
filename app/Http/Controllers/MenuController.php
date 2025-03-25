<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


use Illuminate\Http\Request;

class MenuController extends Controller
{
    //1:メニューの表示
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'set_meal');

        $set_mealPage = $request->input('set_meal_page', 1);
        $side_menuPage = $request->input('side_menu_page', 1);
        $dishPage = $request->input('dish_page', 1);

        $set_meals = SetMeal::paginate(8, ['*'], 'set_meal_page', $set_mealPage);
        $side_menus = SideMenu::paginate(8, ['*'], 'side_menu_page', $side_menuPage);
        $dishes = Dish::paginate(8, ['*'], 'dish_page', $dishPage);

        return view('menu', compact('set_meals', 'dishes', 'side_menus', 'tab'));
    }

    //2:商品をカートに追加する
    public function addToCart(Request $request)
    {   //ログインチェック
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください');
        }
        //カートに商品を登録
        Cart::create([
            'user_id' => Auth::id(),
            'item_id' => $request->input('item_id'),
            'category' => $request->input('category'), // カテゴリを追加
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'image' => $request->input('image')
        ]);
        //メニュー画面にリダイレクト
        return redirect()->route('menu')->with('success', 'カートに追加しました');
    }

    public function viewCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください');
        }
    
        // ✅ 現在のユーザーのカートの中身を取得
        $cartItems = Cart::where('user_id', Auth::id())->get();
    
        // ✅ 合計金額（クーポン適用前）
        $totalPrice = $cartItems->sum(fn($item) => $item->price * ($item->quantity ?? 1));
    
        // ✅ 適用されているクーポンを取得
        $appliedCouponId = session('applied_coupon_id', null);
        $coupon = $appliedCouponId
            ? Coupon::where('id', $appliedCouponId)
                ->where('user_id', Auth::id())
                ->where('used', true) // すでに使用済みのクーポン
                ->first()
            : null;
    
        // ✅ クーポン割引後の金額を計算（`applyCoupon` ではなく、ここで計算）
        $discountedTotal = $coupon ? max(0, $totalPrice - $coupon->discount_value) : $totalPrice;
    
        // ✅ セッションに最新の割引金額を保存
        session(['discounted_total' => $discountedTotal]);
    
        // ✅ 利用可能なクーポンを取得
        $coupons = Coupon::where('user_id', Auth::id())->where('used', false)->get();
    
        return view('cart', compact('cartItems', 'totalPrice', 'discountedTotal', 'coupons'));
    }
    
    public function applyCoupon(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください');
        }
    
        if (!$request->has('coupon_id') || empty($request->coupon_id)) {
            // ✅ クーポン適用解除
            session()->forget(['applied_coupon_id', 'discounted_total']);
            return redirect()->route('cart.view')->with('success', 'クーポンの適用を解除しました');
        }
    
        // ✅ クーポンを取得
        $coupon = Coupon::where('id', $request->coupon_id)
            ->where('user_id', Auth::id())
            ->where('used', false)
            ->first();
    
        if (!$coupon) {
            return redirect()->route('cart.view')->with('error', '無効なクーポンです。');
        }
    
        // ✅ クーポンを使用済みにする
        $coupon->update(['used' => true]);
    
        // ✅ クーポンをセッションに保存
        session(['applied_coupon_id' => $coupon->id]);
    
        return redirect()->route('cart.view')->with('success', "クーポンを適用しました！");
    }
    


    public function removeFromCart($id)
    {
        $cartItem = Cart::find($id);

        if ($cartItem && $cartItem->user_id === Auth::id()) {
            $cartItem->delete();
        }

        return redirect()->route('cart.view')->with('success', 'カートから削除しました');
    }
}
