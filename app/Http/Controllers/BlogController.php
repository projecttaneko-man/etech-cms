<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->when($request->search, fn($q) => $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('meta_keywords', 'like', '%' . $request->search . '%'))
            ->latest('published_at')
            ->paginate(9);

        $categories = Category::withCount('articles')->orderBy('name')->get();

        return view('frontend.home.index', compact('articles', 'categories'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $articles = $category->articles()
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(9);

        $categories = Category::withCount('articles')->orderBy('name')->get();

        return view('frontend.pages.category', compact('category', 'articles', 'categories'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'author'])
            ->firstOrFail();

        $article->increment('views_count');

        $relatedArticles = Article::where('status', 'published')
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        $categories = Category::withCount(['articles' => fn($q) => $q->where('status', 'published')])
            ->orderBy('name')
            ->get();

        return view('frontend.pages.show', compact('article', 'relatedArticles', 'categories'));
    }
}