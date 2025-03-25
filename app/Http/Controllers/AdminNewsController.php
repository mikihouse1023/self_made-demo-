<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class AdminNewsController extends Controller
{
    public function news_add()
    {
        return view('admin_news_add');
    }

    public function addnews(Request $request)
    {
        // 入力データのバリデーション
        $validated = $request->validate([
            'date' => ['required', 'date'], // 必須 & 日付形式
            'category' => ['required', 'string', 'max:255'], // 必須 & 文字列 & 255文字以内
            'is_new' => ['required', 'boolean'], // 必須 & true/false
            'title' => ['required', 'string', 'max:255'], // 必須 & 文字列 & 255文字以内
            'description' => ['nullable', 'string'], // 任意 & 文字列

        ], [
            'date.required' => '日付は必須です。',
            'date.date' => '正しい日付形式で入力してください。',
            'category.required' => 'カテゴリーを入力してください。',
            'category.string' => 'カテゴリーは文字列である必要があります。',
            'is_new.required' => '新規フラグを指定してください。',
            'is_new.boolean' => '新規フラグは true または false である必要があります。',
            'title.required' => 'タイトルを入力してください。',
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'description.string' => '説明は文字列で入力してください。',
        ]);

        News::create([
            'date' => $validated['date'],
            'category' => $validated['category'],
            //'is_new' => $validated['is_new'],
            'is_new' => (bool) $validated['is_new'],
            'title' => $validated['title'],
            'description' => $validated['description']
        ]);
        return redirect()->route('admin.index')->with('success', 'ニュースを登録しました');
    }

    public function editNews($id)
    {
        $news = News::findOrFail($id);
   
        return view('admin_news_edit', compact('news'));
    }

    public function updateNews(Request $request, $id)
    {
        
        $validated = $request->validate([
            'date' => ['required', 'date'], // 必須 & 日付形式
            'category' => ['required', 'string', 'max:255'], // 必須 & 文字列 & 255文字以内
            'is_new' => ['required', 'boolean'], // 必須 & true/false
            'title' => ['required', 'string', 'max:255'], // 必須 & 文字列 & 255文字以内
            'description' => ['nullable', 'string'], // 任意 & 文字列

        ], [
            'date.required' => '日付は必須です。',
            'date.date' => '正しい日付形式で入力してください。',
            'category.required' => 'カテゴリーを入力してください。',
            'category.string' => 'カテゴリーは文字列である必要があります。',
            'is_new.required' => '新規フラグを指定してください。',
            'is_new.boolean' => '新規フラグは true または false である必要があります。',
            'title.required' => 'タイトルを入力してください。',
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'description.string' => '説明は文字列で入力してください。',
        ]);

        $news = News::findOrFail($id);


        // 商品情報を更新
        $news->update($validated);

        return redirect()->route('admin.index')->with('success', 'ニュース内容を更新しました。');
    }

    public function deleteNews($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        return redirect()->route('admin.index')->with('success', 'ニュースを削除しました。');
    }

}
