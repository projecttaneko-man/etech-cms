<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $perPage = in_array((int) $request->per_page, [10, 25, 50, 100]) ? (int) $request->per_page : 10;

        $articles = Article::with(['category', 'author'])
            ->when($request->search, fn($q) => $q->where('title', 'like', '%' . $request->search . '%'))
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.articles.index', compact('articles', 'categories', 'perPage'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateArticle($request);
        $validated = $this->handleSlugAndThumbnail($request, $validated);

        $validated['user_id'] = auth()->id();

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $this->validateArticle($request, $article->id);
        $validated = $this->handleSlugAndThumbnail($request, $validated, $article);

        if ($validated['status'] === 'published' && ! $article->published_at) {
            $validated['published_at'] = now();
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }

    private function validateArticle(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'category_id'      => 'nullable|exists:categories,id',
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:articles,slug,' . $ignoreId,
            'excerpt'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'thumbnail'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'           => 'required|in:draft,published',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:255',
        ]);
    }

   public function preview(Article $article)
    {
        $expires = now()->addMinutes(30)->timestamp;
        $signature = hash_hmac(
            'sha256',
            $article->id . '|' . $expires,
            (string) config('services.etech.preview_token')
        );

        $url = rtrim(config('services.etech.url'), '/')
            . '/wawasan/preview/' . $article->id
            . '?' . http_build_query(['expires' => $expires, 'sig' => $signature]);

        return redirect()->away($url);
    }

    private function handleSlugAndThumbnail(Request $request, array $validated, ?Article $article = null): array
    {
        $validated['slug'] = $validated['slug']
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            if ($article && $article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        } else {
            unset($validated['thumbnail']);
        }

        return $validated;
    }
    
}
