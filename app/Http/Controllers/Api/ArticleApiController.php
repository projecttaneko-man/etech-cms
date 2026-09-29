<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleListResource;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CategoryResource;
use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleApiController extends Controller
{
    // GET /api/v1/articles
    public function index(Request $request)
    {
        $perPage = min((int) $request->get('per_page', 9), 50);

        $articles = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->when($request->search, fn ($q) => $q->where('title', 'like', '%' . $request->search . '%'))
            ->when($request->category, fn ($q) => $q->whereHas('category', fn ($qq) =>
                $qq->where('slug', $request->category)
            ))
            ->latest('published_at')
            ->paginate($perPage);

        return ArticleListResource::collection($articles);
    }

    // GET /api/v1/articles/{slug}
    public function show(string $slug)
    {
        $article = Article::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'author'])
            ->firstOrFail();

        // views from website etech
        $article->increment('views_count');
        ArticleView::create(['article_id' => $article->id]);

        return response()->json([
            'article' => new ArticleResource($article),
            'related' => ArticleListResource::collection($this->relatedFor($article)),
        ]);
    }

    // GET /api/v1/categories
    public function categories()
    {
        $categories = Category::withCount(['articles' => fn ($q) => $q->where('status', 'published')])
            ->orderBy('name')
            ->get();

        return CategoryResource::collection($categories);
    }

    // GET /api/v1/preview/{id}
    public function preview(Request $request, int $id)
    {
        $token = (string) config('services.etech.preview_token');

        abort_unless(
            $token !== '' && hash_equals($token, (string) $request->header('X-Preview-Token')),
            403
        );

        $article = Article::with(['category', 'author'])->findOrFail($id);
        return response()->json([
            'article' => new ArticleResource($article),
            'related' => ArticleListResource::collection($this->relatedFor($article)),
        ]);
    }

    // GET /api/v1/footer: Wawasan
    public function footer()
    {
        $categories = Category::withCount(['articles' => fn ($q) => $q->where('status', 'published')])
            ->orderBy('name')
            ->get();

        $latestArticles = Article::where('status', 'published')
            ->latest('published_at')
            ->limit(10)
            ->get(['title', 'slug', 'thumbnail', 'published_at']);

        return response()->json([
            'categories'      => CategoryResource::collection($categories),
            'latest_articles' => $latestArticles->map(fn ($a) => [
                'title'        => $a->title,
                'slug'         => $a->slug,
                'thumbnail'    => $a->thumbnail ? asset('storage/' . $a->thumbnail) : null,
                'published_at' => optional($a->published_at)->toIso8601String(),
            ]),
        ]);
    }

    // Artikel terkait
    private function relatedFor(Article $article, int $limit = 10)
    {
        $same = collect();
        if ($article->category_id) {
            $same = Article::with('category')
                ->where('status', 'published')
                ->where('id', '!=', $article->id)
                ->where('category_id', $article->category_id)
                ->latest('published_at')
                ->limit($limit)
                ->get();
        }

        if ($same->count() >= $limit) {
            return $same;
        }

        $others = Article::with('category')
            ->where('status', 'published')
            ->where('id', '!=', $article->id)
            ->whereNotIn('id', $same->pluck('id'))
            ->latest('published_at')
            ->limit($limit - $same->count())
            ->get();

        return $same->concat($others);
    }
}