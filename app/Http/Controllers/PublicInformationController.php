<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Article;
use App\Models\Document;

class PublicInformationController extends Controller
{
    public function articles()
    {
        $articles = Article::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return view('public.informasi.berita-artikel', compact('articles'));
    }

    public function articleDetail($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment views
        $article->increment('views');

        // Get related articles
        $relatedArticles = Article::where('is_published', true)
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('public.informasi.berita-artikel-detail', compact('article', 'relatedArticles'));
    }

    public function documents()
    {
        $dokumen = \App\Models\Document::with('category')->where('is_public', true)
            ->latest()
            ->get()
            ->groupBy(function($item) {
                return $item->category ? $item->category->name : 'Lainnya';
            });
            
        return view('public.informasi.unduh-dokumen', compact('dokumen'));
    }

    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();

        \App\Models\Contact::create($validated);

        return redirect()->back()->with('contact_success', true);
    }
}
