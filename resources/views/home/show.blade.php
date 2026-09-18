@extends('layouts.app')
@section('title', $article->title)

@push('styles')
<style>
    .article-page { max-width: 760px; margin: 0 auto; padding: 32px 24px; }
    .breadcrumb { font-size: 13px; color: #888; margin-bottom: 20px; }
    .breadcrumb a { color: #1a5c2e; }

    .article-header { margin-bottom: 24px; }
    .article-tag {
        display: inline-block; font-size: 12px;
        padding: 4px 12px; border-radius: 20px;
        margin-bottom: 14px; font-weight: 500;
    }
    .tag-irrigation { background:#e3f2fd; color:#0c447c; }
    .tag-fertilizer { background:#f3e5f5; color:#6a1b9a; }
    .tag-weed       { background:#e8f5e9; color:#1a5c2e; }
    .tag-pest       { background:#fff3e0; color:#854f0b; }
    .tag-harvest    { background:#fce4ec; color:#993556; }
    .tag-seed       { background:#e0f7fa; color:#0c7c8c; }

    .article-title {
        font-size: 28px; font-weight: 700;
        color: #1a2e1e; line-height: 1.3;
        margin-bottom: 14px;
    }
    .article-meta {
        display: flex; align-items: center; gap: 16px;
        font-size: 13px; color: #888;
        padding-bottom: 20px; border-bottom: 1px solid #e0e8e2;
        margin-bottom: 24px;
    }
    .author-info { display: flex; align-items: center; gap: 8px; }
    .author-av {
        width: 30px; height: 30px; border-radius: 50%;
        background: #e8f5e9; display: flex; align-items: center;
        justify-content: center; font-size: 11px;
        font-weight: 700; color: #1a5c2e;
    }

    .article-hero {
        height: 220px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 72px; margin-bottom: 28px;
        overflow: hidden;
    }
    .thumb-irrigation { background: linear-gradient(135deg,#e3f2fd,#bbdefb); }
    .thumb-fertilizer { background: linear-gradient(135deg,#f3e5f5,#e1bee7); }
    .thumb-weed       { background: linear-gradient(135deg,#e8f5e9,#c8e6c9); }
    .thumb-pest       { background: linear-gradient(135deg,#fff3e0,#ffe0b2); }
    .thumb-harvest    { background: linear-gradient(135deg,#fce4ec,#f8bbd0); }
    .thumb-seed       { background: linear-gradient(135deg,#e0f7fa,#b2ebf2); }

    .article-content {
        font-size: 15px; line-height: 1.9;
        color: #2c2c2a;
    }
    .article-content p { margin-bottom: 16px; white-space: pre-line; }

    .article-footer {
        margin-top: 36px; padding-top: 24px;
        border-top: 1px solid #e0e8e2;
        display: flex; align-items: center; justify-content: space-between;
    }
    .btn-back {
        background: #1a5c2e; color: #fff;
        padding: 10px 22px; border-radius: 8px;
        font-size: 13px; font-weight: 600;
        border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-back:hover { background: #144a24; }

    .related-section { margin-top: 40px; }
    .related-title { font-size: 17px; font-weight: 600; color: #1a2e1e; margin-bottom: 16px; }
    .related-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 14px; }
    .related-card {
        background: #fff; border: 1px solid #e0e8e2;
        border-radius: 10px; padding: 14px;
        display: flex; align-items: center; gap: 12px;
        transition: all 0.2s;
    }
    .related-card:hover { border-color: #1a5c2e; transform: translateX(3px); }
    .related-icon {
        width: 44px; height: 44px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; flex-shrink: 0;
        overflow: hidden;
    }
    .related-name { font-size: 13px; font-weight: 500; color: #1a2e1e; line-height: 1.4; }

    @media (max-width: 600px) {
        .related-grid { grid-template-columns: 1fr; }
        .article-title { font-size: 22px; }
    }
</style>
@endpush

@section('content')
<div class="article-page">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a> /
        <a href="{{ route('articles') }}"></a> /
        {{ Str::limit($article->title, 40) }}
    </div>

    <div class="article-header">
        <span class="article-tag tag-{{ $article->category }}">
            {{ ucfirst($article->category) }}
        </span>
        <h1 class="article-title">{{ $article->title }}</h1>
        <div class="article-meta">
            <div class="author-info">
                <div class="author-av">
                    {{ $article->author ? strtoupper(substr($article->author->name,0,2)) : 'PC' }}
                </div>
                <span>{{ $article->author->name ?? 'PaddyCare Team' }}</span>
            </div>
            <span>📅 {{ $article->created_at->format('F j, Y') }}</span>
            <span>👁 {{ $article->views }} views</span>
        </div>
    </div>

    <div class="article-hero thumb-{{ $article->category }}">
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

    <div class="article-content">
        <p>{{ $article->content }}</p>
    </div>

    <div class="article-footer">
        <a href="{{ route('articles') }}">
            <button class="btn-back">← Back to Articles</button>
        </a>
        @auth
            @if(auth()->user()->role === 'farmer')
            <a href="{{ route('farmer.diagnosis') }}">
                <button class="btn-back" style="background:#185fa5;">📷 Check My Paddy</button>
            </a>
            @endif
        @endauth
    </div>

    @if($related->count() > 0)
    <div class="related-section">
        <div class="related-title">📚 Related Articles</div>
        <div class="related-grid">
            @foreach($related as $r)
            <a href="{{ route('articles.show', $r->slug) }}">
                <div class="related-card">
                    <div class="related-icon thumb-{{ $r->category }}">
                        @if($r->image)
                            <img src="{{ asset('storage/'.$r->image) }}" alt="{{ $r->title }}"
                                 style="width:100%; height:100%; object-fit:cover;">
                        @else
                            @if($r->category === 'irrigation') 💧
                            @elseif($r->category === 'fertilizer') 🧪
                            @elseif($r->category === 'weed') ✂️
                            @elseif($r->category === 'pest') 🐛
                            @elseif($r->category === 'harvest') 🌾
                            @else 🌱
                            @endif
                        @endif
                    </div>
                    <div class="related-name">{{ Str::limit($r->title, 60) }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection