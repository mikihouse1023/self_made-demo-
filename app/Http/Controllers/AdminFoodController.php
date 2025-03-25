<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\SetMeal;
use App\Models\SideMenu;
use App\Models\Dish;
use App\Models\User;
use App\Models\Admin;
use App\Models\News;

use Illuminate\Http\Request;

class AdminFoodController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'set_meal');

        // 各タブのデータ取得
        $set_meals = SetMeal::paginate(8);
        $side_menus = SideMenu::paginate(8);
        $dishes = Dish::paginate(8);
        $news = News::paginate(8);
        $users = User::paginate(8);
        $admins = Admin::paginate(8);

        // ✅ 売上データを取得（注文ごとに集約）
        $sales = \DB::table('sales')
            ->select(
                'order_code',
                'user_id',
                'created_at',
                \DB::raw('GROUP_CONCAT(name SEPARATOR ", ") as product_names'),
                \DB::raw('SUM(price * quantity) as total_amount'),
                \DB::raw('MAX(discounted_total) as discounted_total')
            )
            ->groupBy('order_code', 'user_id', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(8, ['*'], 'sale_page');

        // ✅ 予約データを取得（`is_reserved = true` のものを取得）
        $reservations = \DB::table('orders')
            ->where('is_reserved', true)
            ->select(
                'order_code',
                'user_id',
                'reserved_at',
                'guest_count',
                \DB::raw('GROUP_CONCAT(name SEPARATOR ", ") as product_names'),
                \DB::raw('SUM(price * quantity) as total_amount')
            )
            ->groupBy('order_code', 'user_id', 'reserved_at', 'guest_count')
            ->orderBy('reserved_at', 'asc')
            ->paginate(8, ['*'], 'reservation_page');


        return view('admin', compact(
            'set_meals',
            'dishes',
            'side_menus',
            'news',
            'users',
            'admins',
            'sales',
            'reservations',
            'tab'
        ));
    }



    public function add_Food()
    {
        return view('food_add');
    }
    public function addFood(Request $request)
    {
        // 入力データのバリデーション
        $validated = $request->validate([
            'category' => 'required|string|in:set_meals,dishes,side_menus',
            'name' => 'required|string|max:50',
            'val' => 'required|integer|min:0',
            'explanation' => 'required|string',
            'genre' => 'required|string',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'category.required' => 'カテゴリを選択してください。',
            'name.required' => '商品名を入力してください。',
            'name.max' => '商品名は50文字以内で入力してください。',
            'val.required' => '値段は必須項目です。',
            'val.integer' => '値段は整数で入力してください。',
            'val.min' => '値段は0以上でなければなりません。',
            'explanation.required' => '説明を入力してください。',
            'genre.required' => 'ジャンルを選択してください。',
            'picture.required' => '画像をアップロードしてください。',
            'picture.image' => '画像形式のファイルを選択してください。',
            'picture.mimes' => '画像形式はjpeg, png, jpg, gifのいずれかである必要があります。',
            'picture.max' => '画像サイズは2MB以下にしてください。',
        ]);

        // 画像のアップロード処理
        $path = $request->file('picture')->store('images', 'public');

        // 選択されたカテゴリに応じてデータを保存
        $modelClass = match ($validated['category']) {
            'set_meals' => SetMeal::class,
            'dishes' => Dish::class,
            'side_menus' => SideMenu::class,
        };

        $modelClass::create([
            'name' => $validated['name'],
            'val' => $validated['val'],
            'explanation' => $validated['explanation'],
            'genre' => $validated['genre'],
            'picture' => $path,
        ]);

        // 登録完了後のリダイレクト
        return redirect()->route('admin.index')->with('success', '商品を登録しました');
    }

    public function edit_Food($id, Request $request)
    {
        // カテゴリの取得
        $category = $request->input('category');

        // モデルを取得
        $model = match ($category) {
            'set_meals' => SetMeal::class,
            'dishes' => Dish::class,
            'side_menus' => SideMenu::class,
            default => null,
        };

        if (!$model) {
            return redirect()->route('admin.index')->with('error', 'カテゴリが不正です');
        }

        // 指定した ID の商品を取得
        $item = $model::find($id);

        if (!$item) {
            return redirect()->route('admin.index')->with('error', '商品が見つかりません');
        }

        return view('food_edit', compact('item', 'category'));
    }

    public function editFood(Request $request, $id)
    {
        // 入力データのバリデーション
        $validated = $request->validate([
            'category' => 'required|string|in:set_meals,dishes,side_menus',
            'name' => 'required|string|max:50',
            'val' => 'required|integer|min:0',
            'explanation' => 'required|string',
            'genre' => 'required|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // モデルを取得
        $model = match ($validated['category']) {
            'set_meals' => SetMeal::class,
            'dishes' => Dish::class,
            'side_menus' => SideMenu::class,
            default => null,
        };

        if (!$model) {
            return redirect()->route('admin.index')->with('error', 'カテゴリが不正です');
        }

        // 商品を取得
        $item = $model::find($id);
        if (!$item) {
            return redirect()->route('admin.index')->with('error', '商品が見つかりません');
        }

        // データを更新
        $item->name = $validated['name'];
        $item->val = $validated['val'];
        $item->explanation = $validated['explanation'];
        $item->genre = $validated['genre'];

        // 画像がアップロードされた場合は更新
        if ($request->hasFile('picture')) {
            // 古い画像を削除
            if ($item->picture) {
                \Storage::disk('public')->delete($item->picture);
            }

            // 新しい画像を保存
            $path = $request->file('picture')->store('images', 'public');
            $item->picture = $path;
        }

        // 保存
        $item->save();

        return redirect()->route('admin.index')->with('success', '商品を更新しました');
    }

    public function deleteFood($id, Request $request)
    {
        // カテゴリに応じて対象のテーブルを選択
        $model = match ($request->input('category')) {
            'set_meals' => SetMeal::class,
            'dishes' => Dish::class,
            'side_menus' => SideMenu::class,
            default => null,
        };

        if (!$model) {
            return redirect()->route('admin.index')->with('error', 'カテゴリが不正です');
        }

        // 該当の商品を取得
        $item = $model::find($id);
        if (!$item) {
            return redirect()->route('admin.index')->with('error', '商品が見つかりません');
        }

        // 画像の削除（商品に画像がある場合のみ）
        if ($item->picture) {
            \Storage::disk('public')->delete($item->picture);
        }

        // 商品の削除
        $item->delete();

        return redirect()->route('admin.index')->with('success', '商品を削除しました');
    }
}
