@extends('layouts.app')
@section('title', $guide['title'])

@push('styles')
<style>
    .guide-page { max-width: 860px; margin: 0 auto; padding: 36px 24px 60px; }

    .breadcrumb { font-size: 13px; color: #888; margin-bottom: 20px; }
    .breadcrumb a { color: #1a5c2e; text-decoration: none; }
    .breadcrumb a:hover { text-decoration: underline; }
    .breadcrumb span { margin: 0 6px; }

    .guide-hero {
        background: {{ $guide['color'] }};
        border-radius: 16px; padding: 32px;
        display: flex; align-items: center; gap: 20px;
        margin-bottom: 32px; border: 1px solid rgba(0,0,0,0.06);
    }
    .guide-icon-big { font-size: 56px; flex-shrink: 0; }
    .guide-hero-title { font-size: 26px; font-weight: 700; color: #1a2e1e; margin-bottom: 8px; }
    .guide-hero-intro { font-size: 14px; color: #555; line-height: 1.7; }

    .guide-section { margin-bottom: 28px; }
    .guide-section-title {
        font-size: 17px; font-weight: 700; color: #1a5c2e;
        margin-bottom: 12px; padding-bottom: 8px;
        border-bottom: 2px solid #e8f5e9;
        display: flex; align-items: center; gap: 8px;
    }
    .guide-section-content {
        font-size: 14px; color: #333; line-height: 1.85;
        background: #fff; border-radius: 10px;
        padding: 18px 20px; border: 1px solid #e0e8e2;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }

    .related-section { margin-top: 40px; }
    .related-title { font-size: 18px; font-weight: 600; color: #1a2e1e; margin-bottom: 16px; }
    .related-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
    .related-card {
        background: #fff; border: 1px solid #e0e8e2;
        border-radius: 10px; overflow: hidden;
        transition: all 0.2s; display: block;
        text-decoration: none;
    }
    .related-card:hover { border-color: #1a5c2e; transform: translateY(-3px); box-shadow: 0 6px 16px rgba(26,92,46,0.1); }
    .related-thumb {
        height: 100px; display: flex; align-items: center;
        justify-content: center; font-size: 36px;
        overflow: hidden;
    }
    .related-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .related-body { padding: 12px; }
    .related-name { font-size: 13px; font-weight: 500; color: #1a2e1e; line-height: 1.4; }

    .back-btn {
        display: inline-flex; align-items: center; gap: 6px;
        background: #1a5c2e; color: #fff;
        padding: 10px 22px; border-radius: 8px;
        font-size: 13px; font-weight: 600;
        border: none; cursor: pointer; margin-top: 32px;
        transition: background 0.2s; text-decoration: none;
    }
    .back-btn:hover { background: #144a24; color: #fff; }

    .guide-nav {
        display: flex; flex-wrap: wrap; gap: 8px;
        margin-bottom: 28px;
    }
    .guide-nav a {
        padding: 7px 14px; border-radius: 20px;
        font-size: 12px; font-weight: 500;
        border: 1.5px solid #d0ddd4; color: #555;
        background: #fff; transition: all 0.2s;
        text-decoration: none;
    }
    .guide-nav a:hover,
    .guide-nav a.active { background: #1a5c2e; color: #fff; border-color: #1a5c2e; }
    
    @media (max-width: 768px) {
        .related-grid { grid-template-columns: 1fr; }
        .guide-hero { flex-direction: column; text-align: center; padding: 20px; }
    }
</style>
@endpush

@section('content')
<div class="guide-page">

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span>›</span>
        <a href="{{ route('home') }}#tips">Guides</a>
        <span>›</span>
        {{ $guide['title'] }}
    </div>

    <!-- Quick Navigation -->
    <div class="guide-nav">
        <a href="{{ route('guide', 'irrigation') }}" class="{{ $topic === 'irrigation' ? 'active' : '' }}">💧 Irrigation</a>
        <a href="{{ route('guide', 'fertilizer') }}" class="{{ $topic === 'fertilizer' ? 'active' : '' }}">🧪 Fertilizer</a>
        <a href="{{ route('guide', 'weed') }}"       class="{{ $topic === 'weed'       ? 'active' : '' }}">✂️ Weed Control</a>
        <a href="{{ route('guide', 'pest') }}"       class="{{ $topic === 'pest'       ? 'active' : '' }}">🐛 Pest Control</a>
        <a href="{{ route('guide', 'seed') }}"       class="{{ $topic === 'seed'       ? 'active' : '' }}">🌱 Seed Selection</a>
        <a href="{{ route('guide', 'harvest') }}"    class="{{ $topic === 'harvest'    ? 'active' : '' }}">🌾 Harvest</a>
    </div>

    <!-- Hero -->
    <div class="guide-hero">
        <div class="guide-icon-big">{{ $guide['icon'] }}</div>
        <div>
            <div class="guide-hero-title">{{ $guide['title'] }}</div>
            <div class="guide-hero-intro">{{ $guide['intro'] }}</div>
        </div>
    </div>

    <!-- Sections -->
    @foreach($guide['sections'] as $i => $section)
    <div class="guide-section">
        <div class="guide-section-title">
            {{ $i + 1 }}. {{ $section['heading'] }}
        </div>
        <div class="guide-section-content">
            {{ $section['content'] }}
        </div>
    </div>
    @endforeach

    <!-- Related Articles -->
    @if($relatedArticles->count() > 0)
    <div class="related-section">
        <div class="related-title">📖 Related Articles</div>
        <div class="related-grid">
            @foreach($relatedArticles as $a)
            <a href="{{ route('articles.show', $a->slug) }}" class="related-card">
                <div>
                    <div class="related-thumb" style="background: {{ $guide['color'] }};">
                        @if($a->image)
                            <img src="{{ asset('storage/'.$a->image) }}" alt="{{ $a->title }}">
                        @else
                            {{ $guide['icon'] }}
                        @endif
                    </div>
                    <div class="related-body">
                        <div class="related-name">{{ Str::limit($a->title, 55) }}</div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <a href="{{ route('home') }}" class="back-btn">← Back to Home</a>
</div>
@endsection