<?php

namespace App\Http\Controllers;

use App\Models\Sale;

use App\Models\News;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index(Request $request)
    {
        /*・ランキング表(ジャンル検索機能無し)        
        $ranking = Sale::select('name', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(price * quantity) as total_sales'))
        ->where('name', '!=', 'ドリンクバー')//ドリンクバーは除外
        //->where('price', '>', 0)(0円の商品そのものを除外)
        ->groupBy('name')
        ->orderByDesc('total_sales')
        ->limit(10)
        ->get();*/

/*
        $genre = $request->query('genre'); // "set_meal" / "dish" / "side_menu" / null
        // 3つの商品テーブルを結合
        $allProducts = DB::table('set_meals')->select('name', 'genre')
            ->unionAll(DB::table('dishes')->select('name', 'genre'))
            ->unionAll(DB::table('side_menus')->select('name', 'genre'));

        // salesと商品情報を結合し、ジャンルで絞る
        $rankingQuery = DB::table('sales')
            ->joinSub($allProducts, 'products', function ($join) {
                $join->on('sales.name', '=', 'products.name');
            })
            ->where('sales.name', '!=', 'ドリンクバー');

        if (!empty($genre)) {
            $rankingQuery->where('products.genre', $genre);
        }

        $ranking = $rankingQuery
            ->select('sales.name', DB::raw('SUM(sales.quantity) as total_quantity'), DB::raw('SUM(sales.price * sales.quantity) as total_sales'))
            ->groupBy('sales.name')
            ->orderByDesc('total_sales')
            ->limit(10)
            ->get();*/

            $genre = $request->query('genre');

            // ⭐ ジャンルとテーブル名のマッピング
            $tableMap = [
                'set_meal' => 'set_meals',
                'dish' => 'dishes',
                'side_menu' => 'side_menus',
            ];
        
            $rankingQuery = DB::table('sales')
                ->where('sales.name', '!=', 'ドリンクバー');
        
            if (!empty($genre) && isset($tableMap[$genre])) {
                $tableName = $tableMap[$genre];
        
                // 動的にテーブル名でJOIN
                $rankingQuery->join($tableName, function ($join) use ($tableName, $genre) {
                    $join->on('sales.product_id', '=', "$tableName.id")
                        ->where('sales.product_type', '=', $genre);
                });
            } else {
                // 全ジャンル統合
                $allProducts = DB::table('set_meals')->select('id', 'name', 'genre', DB::raw("'set_meal' as product_type"))
                    ->unionAll(DB::table('dishes')->select('id', 'name', 'genre', DB::raw("'dish' as product_type")))
                    ->unionAll(DB::table('side_menus')->select('id', 'name', 'genre', DB::raw("'side_menu' as product_type")));
        
                $rankingQuery->joinSub($allProducts, 'products', function ($join) {
                    $join->on('sales.product_id', '=', 'products.id')
                        ->whereColumn('sales.product_type', 'products.product_type');
                });
            }
        
            $ranking = $rankingQuery
                ->select('sales.name', DB::raw('SUM(sales.quantity) as total_quantity'), DB::raw('SUM(sales.price * sales.quantity) as total_sales'))
                ->groupBy('sales.name')
                ->orderByDesc('total_sales')
                ->limit(10)
                ->get();
            
        $news = News::latest()->paginate(5); // ニュースデータを取得
        return view('index', compact('ranking','genre', 'news')); // ビューに渡す
    }

    public function newsShow($id)
    {
        $news = News::findOrFail($id); // ニュース詳細を取得
        return view('news', compact('news')); // ビューに渡す
    }
}
