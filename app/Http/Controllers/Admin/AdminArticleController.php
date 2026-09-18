<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class AdminArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with('author')->latest()->get();
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'slug'     => 'required|unique:articles,slug',
            'content'  => 'required|string',
            'category' => 'required|string',
            'image'    => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        Article::create([
            'title'        => $request->title,
            'slug'         => $request->slug,
            'content'      => $request->content,
            'category'     => $request->category,
            'image'        => $imagePath,
            'created_by'   => auth()->id(),
            'is_published' => $request->has('is_published') ? 1 : 0,
        ]);

        return redirect()->route('admin.articles.index')
                         ->with('success', 'Article published successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'slug'     => 'required|unique:articles,slug,' . $article->id,
            'content'  => 'required|string',
            'category' => 'required|string',
            'image'    => 'nullable|image|max:2048',
        ]);

        $imagePath = $article->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        $article->update([
            'title'        => $request->title,
            'slug'         => $request->slug,
            'content'      => $request->content,
            'category'     => $request->category,
            'image'        => $imagePath,
            'is_published' => $request->has('is_published') ? 1 : 0,
        ]);

        return redirect()->route('admin.articles.index')
                         ->with('success', 'Article updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return back()->with('success', 'Article deleted successfully.');
    }
}