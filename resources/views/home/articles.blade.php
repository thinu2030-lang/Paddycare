@extends('layouts.app')
@section('title', 'Articles')

@push('styles')
<style>
    .articles-page { padding: 32px; max-width: 1100px; margin: 0 auto; }
    .page-header { text-align: center; margin-bottom: 32px; }
    .page-header h1 { font-size: 26px; font-weight: 700; color: #1a2e1e; margin-bottom: 8px; }
    .page-header p { font-size: 14px; color: #666; }

    /* FILTER TABS */
    .filter-tabs {
        display: flex; justify-content: center; gap: 8px;
        margin-bottom: 28px; flex-wrap: wrap;
    }
    .filter-tab {
        padding: 8px 18px; border-radius: 20px;
        font-size: 13px; font-weight: 500;
        border: 1.5px solid #d0ddd4; color: #555;
        background: #fff; cursor: pointer;
        transition: all 0.2s;
    }
    .filter-tab:hover { border-color: #1a5c2e; color: #1a5c2e; }
    .filter-tab.active { background: #1a5c2e; color: #fff; border-color: #1a5c2e; }

    /* ARTICLES GRID */
    .articles-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    .article-card {
        background: #fff; border-radius: 12px;
        overflow: hidden; border: 1px solid #e0e8e2;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .article-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(26,92,46,0.12);
    }
    .article-thumb {
        height: 150px; display: flex; align-items: center;
        justify-content: center; font-size: 52px;
        overflow: hidden;
    }
    .thumb-irrigation { background: linear-gradient(135deg,#e3f2fd,#bbdefb); }
    .thumb-fertilizer { background: linear-gradient(135deg,#f3e5f5,#e1bee7); }
    .thumb-weed       { background: linear-gradient(135deg,#e8f5e9,#c8e6c9); }
    .thumb-pest       { background: linear-gradient(135deg,#fff3e0,#ffe0b2); }
    .thumb-harvest    { background: linear-gradient(135deg,#fce4ec,#f8bbd0); }
    .thumb-seed       { background: linear-gradient(135deg,#e0f7fa,#b2ebf2); }
    .article-body { padding: 16px; }
    .article-tag {
        display: inline-block; font-size: 11px;
        padding: 3px 10px; border-radius: 20px;
        margin-bottom: 8px; font-weight: 500;
    }
    .tag-irrigation { background:#e3f2fd; color:#0c447c; }
    .tag-fertilizer { background:#f3e5f5; color:#6a1b9a; }
    .tag-weed       { background:#e8f5e9; color:#1a5c2e; }
    .tag-pest       { background:#fff3e0; color:#854f0b; }
    .tag-harvest    { background:#fce4ec; color:#993556; }
    .tag-seed       { background:#e0f7fa; color:#0c7c8c; }
    .article-title {
        font-size: 14px; font-weight: 600; color: #1a2e1e;
        margin-bottom: 8px; line-height: 1.5;
    }
    .article-excerpt {
        font-size: 12px; color: #777; line-height: 1.5;
        margin-bottom: 10px;
    }
    .article-meta { font-size: 12px; color: #888; display: flex; gap: 12px; }

    .empty-state { text-align: center; padding: 60px; color: #888; grid-column: 1/-1; }
    .pagination-wrap { margin-top: 32px; display: flex; justify-content: center; }

    @media (max-width: 768px) {
        .articles-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="articles-page">
    <div class="page-header">
        <h1>📖 Paddy Care Articles</h1><b>
        <p></p>
    </div>

    

    <!-- ARTICLES -->
    <div class="articles-grid">
        @forelse($articles as $article)
            <a href="{{ route('articles.show', $article->slug) }}">
                <div class="article-card">
                    <div class="article-thumb thumb-{{ $article->category }}">
                        @if($article->image)
                            <img src="{{ asset('storage/'.$article->image) }}" alt="{{ $article->title }}"
                                 style="width:100%; height:100%; object-fit:cover;">
                        @else
                            @if($article->category === 'irrigation') 💧
                            @elseif($article->category === 'fertilizer') 🧪
                            @elseif($article->category === 'weed') ✂️
                            @elseif($article->category === 'pest') 🐛
                            @elseif($article->category === 'harvest') 🌾
                            @else 🌱
                            @endif
                        @endif
                    </div>
                    <div class="article-body">
                        <span class="article-tag tag-{{ $article->category }}">
                            {{ ucfirst($article->category) }}
                        </span>
                        <div class="article-title">{{ $article->title }}</div>
                        <div class="article-excerpt">{{ Str::limit(strip_tags($article->content), 90) }}</div>
                        <div class="article-meta">
                            <span>📅 {{ $article->created_at->format('M d, Y') }}</span>
                            <span>👁 {{ $article->views }}</span>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="empty-state">
                📖 No articles found in this category.
            </div>
        @endforelse
    </div>

    @if($articles->hasPages())
    <div class="pagination-wrap">
        {{ $articles->links() }}
    </div>
    @endif
</div>
@endsection