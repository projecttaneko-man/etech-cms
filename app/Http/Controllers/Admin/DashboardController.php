<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Category;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== Stat cards =====
        $totalArticles     = Article::count();
        $publishedArticles = Article::where('status', 'published')->count();
        $draftArticles     = Article::where('status', 'draft')->count();
        $totalViews        = Article::sum('views_count');

        // ===== Artikel per Kategori (bar chart) =====
        $categories = Category::withCount('articles')->orderBy('name')->get();
        $categoryLabels = $categories->pluck('name');
        $categoryCounts = $categories->pluck('articles_count');

        // ===== Distribusi Status (donut chart) =====
        $scheduledArticles = Article::where('status', 'draft')
            ->whereNotNull('published_at')
            ->where('published_at', '>', now())
            ->count();

        $statusCounts = [$publishedArticles, $draftArticles, $scheduledArticles];

        // ===== Tren Views Mingguan (7 hari terakhir) =====
        $weeklyViewsLabels = collect();
        $weeklyViewsData   = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $weeklyViewsLabels->push($date->translatedFormat('D'));

            $weeklyViewsData->push(
                ArticleView::whereDate('viewed_at', $date->toDateString())->count()
            );
        }

        // ===== Artikel Terakhir =====
        $latestArticles = Article::with('category')
            ->latest()
            ->take(4)
            ->get();

        return view('admin.dashboard', compact(
            'totalArticles',
            'publishedArticles',
            'draftArticles',
            'totalViews',
            'categoryLabels',
            'categoryCounts',
            'statusCounts',
            'weeklyViewsLabels',
            'weeklyViewsData',
            'latestArticles'
        ));
    }
}