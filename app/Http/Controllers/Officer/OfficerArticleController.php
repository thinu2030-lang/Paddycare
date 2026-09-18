<?php
namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfficerArticleController extends Controller
{
    public function index()
    {
        // Officer can see all articles but only edit/delete their own
        $articles = Article::with('author')->latest()->get();
        return view('officer.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('officer.articles.create');
    }

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
            'created_by'   => Auth::id(),
            'is_published' => $request->has('is_published') ? 1 : 0,
        ]);

        return redirect()->route('officer.articles.index')
                         ->with('success', 'Article published successfully!');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);

        // Officer can only edit their own articles
        if ($article->created_by !== Auth::id()) {
            abort(403, 'You can only edit your own articles.');
        }

        return view('officer.articles.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        if ($article->created_by !== Auth::id()) {
            abort(403, 'You can only edit your own articles.');
        }

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

        return redirect()->route('officer.articles.index')
                         ->with('success', 'Article updated successfully!');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if ($article->created_by !== Auth::id()) {
            abort(403, 'You can only delete your own articles.');
        }

        $article->delete();
        return back()->with('success', 'Article deleted successfully.');
    }
}