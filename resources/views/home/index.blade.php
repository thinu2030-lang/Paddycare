@extends('layouts.app')
@section('title', 'Home')

@push('styles')
<style>
    /* HERO */
    .hero {
        background: linear-gradient(135deg, #1a5c2e 0%, #2d8a4e 100%);
        color: #fff; padding: 70px 32px; text-align: center;
    }
    .hero h1 { font-size: 34px; font-weight: 1000; margin-bottom: 14px; }
    .hero p  { font-size: 16px; color: #c8efd7; margin-bottom: 32px; max-width: 580px; margin-left: auto; margin-right: auto; line-height: 1.7; }
    .hero-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
    .btn-hero-primary { background: #6fdc9e; color: #0a3318; padding: 13px 32px; border-radius: 8px; font-size: 15px; font-weight: 700; border: none; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 14px rgba(0,0,0,0.15); }
    .btn-hero-primary:hover { background: #5bc98a; transform: translateY(-2px); }
    .btn-hero-outline { background: transparent; color: #fff; padding: 13px 32px; border-radius: 8px; font-size: 15px; font-weight: 600; border: 2px solid rgba(255,255,255,0.6); cursor: pointer; transition: all 0.2s; }
    .btn-hero-outline:hover { border-color: #fff; background: rgba(255,255,255,0.12); transform: translateY(-2px); }

    /* STATS */
    .stats-bar { background: #fff; padding: 20px 32px; display: grid; grid-template-columns: repeat(4,1fr); border-bottom: 1px solid #e0e8e2; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    .stat-item { text-align: center; padding: 12px; border-right: 1px solid #e0e8e2; }
    .stat-item:last-child { border-right: none; }
    .stat-num { font-size: 28px; font-weight: 700; color: #1a5c2e; }
    .stat-lbl { font-size: 12px; color: #666; margin-top: 4px; }

    /* PHOTO GALLERY */
    .gallery-section {
        padding: 52px 32px;
        background: linear-gradient(180deg, #f8fdf9 0%, #fff 100%);
    }
    .gallery-header { text-align: center; margin-bottom: 32px; }
    .gallery-header h2 { font-size: 24px; font-weight: 700; color: #1a2e1e; margin-bottom: 8px; }
    .gallery-header p  { font-size: 14px; color: #666; }
    .green { color: #1a5c2e; }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        max-width: 1100px;
        margin: 0 auto;
    }
    .gallery-item {
        border-radius: 14px; overflow: hidden; height: 220px;
        position: relative; box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        transition: transform 0.3s, box-shadow 0.3s; cursor: pointer;
    }
    .gallery-item:hover { transform: translateY(-6px); box-shadow: 0 14px 36px rgba(26,92,46,0.2); }
    .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; display: block; }
    .gallery-item:hover img { transform: scale(1.06); }
    .gallery-label {
        position: absolute; bottom: 0; left: 0; right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.72));
        padding: 24px 16px 14px;
        color: #fff; font-size: 13px; font-weight: 600; letter-spacing: 0.3px;
    }

    .gallery-view-all { text-align: center; margin-top: 28px; }
    .btn-view-all {
        background: #1a5c2e; color: #fff; padding: 12px 32px; border-radius: 8px;
        font-size: 14px; font-weight: 600; border: none; cursor: pointer;
        transition: all 0.25s; box-shadow: 0 4px 12px rgba(26,92,46,0.3);
        display: inline-block; text-decoration: none;
    }
    .btn-view-all:hover { background: #144a24; color: #fff; transform: translateY(-2px); box-shadow: 0 6px 18px rgba(26,92,46,0.4); }

    /* TIPS */
    .tips-section { background: #fff; padding: 48px 32px; border-top: 1px solid #e0e8e2; }
    .section-title { font-size: 22px; font-weight: 700; color: #1a2e1e; text-align: center; margin-bottom: 6px; }
    .section-title span { color: #1a5c2e; }
    .section-sub { font-size: 13px; color: #666; text-align: center; margin-bottom: 28px; }
    .tips-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; max-width: 1100px; margin: 0 auto; }
    .tip-link { text-decoration: none; display: block; color: inherit; }
    
    .tip-card {
        background: #f8fdf9;
        border: 2px solid #c8e6c9;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        gap: 14px;
        align-items: flex-start;
        transition: all 0.25s ease;
        height: 100%;
        cursor: pointer;
    }
    
    .tip-link:hover .tip-card {
        box-shadow: 0 6px 20px rgba(26,92,46,0.15);
        transform: translateY(-4px);
        border-color: #1a5c2e;
        background: #f0fbf4;
    }
    
    .tip-icon  { font-size: 28px; flex-shrink: 0; line-height: 1; }
    
    .tip-title {
        font-size: 14px;
        font-weight: 700;
        color: #1a2e1e;
        margin-bottom: 6px;
        transition: color 0.2s;
    }

    .tip-link:hover .tip-title {
        color: #1a5c2e;
    }

    .tip-text  { font-size: 13px; color: #555; line-height: 1.6; }

    /* CTA */
    .cta-section {
        background: linear-gradient(135deg, #1a5c2e 0%, #2d8a4e 100%);
        padding: 56px 32px; text-align: center;
        margin-bottom: 0;
    }
    .cta-section h2 { font-size: 26px; font-weight: 700; color: #fff; margin-bottom: 12px; }
    .cta-section p  { font-size: 15px; color: #c8efd7; margin-bottom: 28px; }
    .btn-cta {
        background: #6fdc9e; color: #0a3318; padding: 14px 36px; border-radius: 8px;
        font-size: 15px; font-weight: 700; border: none; cursor: pointer;
        transition: all 0.2s; box-shadow: 0 4px 14px rgba(0,0,0,0.2);
    }
    .btn-cta:hover { background: #5bc98a; transform: translateY(-2px); }

    @media (max-width: 768px) {
        .stats-bar { grid-template-columns: repeat(2,1fr); }
        .gallery-grid { grid-template-columns: 1fr 1fr; }
        .tips-grid { grid-template-columns: 1fr; }
        .hero h1 { font-size: 24px; }
        .gallery-item { height: 160px; }
    }
</style>
@endpush

@section('content')

<!-- HERO -->
<section class="hero">
    <h1> Paddy Care</h1>
    <p>Upload a leaf photo to detect diseases instantly — get treatment advice, seed recommendations, and connect with agricultural officers.</p>
    <div class="hero-btns">
        @auth
            @if(auth()->user()->role === 'farmer')
            <a href="{{ route('farmer.diagnosis') }}">
                <button class="btn-hero-primary">📷 Check My Paddy</button>
            </a>
            @elseif(auth()->user()->role === 'officer')
            <a href="{{ route('officer.dashboard') }}">
                <button class="btn-hero-primary">📊 Officer Dashboard</button>
            </a>
            @elseif(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}">
                <button class="btn-hero-primary">🛡️ Admin Dashboard</button>
            </a>
            @endif
        @else
            <a href="{{ route('register') }}">
                <button class="btn-hero-primary">📷 Get Started Free</button>
            </a>
        @endauth
        <a href="{{ route('articles') }}">
            <button class="btn-hero-outline">📖 Read Articles</button>
        </a>
    </div>
</section>

<!-- STATS -->
<div class="stats-bar">
    <div class="stat-item">
        <div class="stat-num">1,240+</div>
        <div class="stat-lbl"> Registered Farmers</div>
    </div>
    <div class="stat-item">
        <div class="stat-num">5,600+</div>
        <div class="stat-lbl"> Diseases Detected</div>
    </div>
    <div class="stat-item">
        <div class="stat-num">42</div>
        <div class="stat-lbl"> Active Officers</div>
    </div>
    <div class="stat-item">
        <div class="stat-num">97%</div>
        <div class="stat-lbl"> AI Accuracy</div>
    </div>
</div>

<!-- PHOTO GALLERY -->
<section class="gallery-section">
    <div class="gallery-header">
        <h2>🌾 Sri Lanka <span class="green">Paddy Cultivation</span></h2>
        <p>From field to harvest — the journey of Sri Lankan paddy farming</p>
    </div>

    <div class="gallery-grid">
        <div class="gallery-item">
            <img src="{{ asset('images/paddy7.jpg') }}" alt="Paddy Grains">
            <div class="gallery-label"> Paddy Grains</div>
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/paddy1.jpg') }}" alt="Paddy Sunset">
            <div class="gallery-label"> Field Sunset</div>
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/paddy3.jpg') }}" alt="Rice Grains">
            <div class="gallery-label"> Seed Processing</div>
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/paddy4.jpg') }}" alt="Transplanting">
            <div class="gallery-label"> Transplanting</div>
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/paddy5.jpg') }}" alt="Farmers Working">
            <div class="gallery-label"> Farmers Working</div>
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/paddy6.jpg') }}" alt="Aerial View">
            <div class="gallery-label"> Lush Green Fields</div>
        </div>
    </div>

    <div class="gallery-view-all">
        <a href="{{ route('articles') }}" class="btn-view-all">
             Read Paddy Cultivation Articles →
        </a>
    </div>
</section>

<!-- TIPS -->
<section class="tips-section">
    <h2 class="section-title"> Quick <span>Paddy Care</span> Tips</h2>
    <p class="section-sub">Essential tips for successful paddy cultivation in Sri Lanka</p>
    <div class="tips-grid">

        <a href="{{ route('guide', 'irrigation') }}" class="tip-link">
            <div class="tip-card">
                <div class="tip-icon">💧</div>
                <div>
                    <div class="tip-title">Irrigation</div>
                    <div class="tip-text">Maintain 5cm flood depth during tillering. Drain mid-season to strengthen roots and reduce pests.</div>
                </div>
            </div>
        </a>

        <a href="{{ route('guide', 'fertilizer') }}" class="tip-link">
            <div class="tip-card">
                <div class="tip-icon">🌱</div>
                <div>
                    <div class="tip-title">Fertilizer</div>
                    <div class="tip-text">Apply Urea in split doses — basal at transplanting and top-dressing at tillering stage for best results.</div>
                </div>
            </div>
        </a>

        <a href="{{ route('guide', 'weed-control') }}" class="tip-link">
            <div class="tip-card">
                <div class="tip-icon">🌾</div>
                <div>
                    <div class="tip-title">Weed Control</div>
                    <div class="tip-text">Weed at 2–3 weeks after transplanting. Use a rotary weeder between rows for efficient control.</div>
                </div>
            </div>
        </a>

        <a href="{{ route('guide', 'pest-control') }}" class="tip-link">
            <div class="tip-card">
                <div class="tip-icon">🔍</div>
                <div>
                    <div class="tip-title">Early Disease Detection</div>
                    <div class="tip-text">Check leaves every morning for yellow or brown spots. Upload a photo for instant AI diagnosis.</div>
                </div>
            </div>
        </a>

        <a href="{{ route('guide', 'seed') }}" class="tip-link">
            <div class="tip-card">
                <div class="tip-icon">🌾</div>
                <div>
                    <div class="tip-title">Right Seed Selection</div>
                    <div class="tip-text">Choose blast-resistant varieties like BG 352 for Gampaha region. Match seed to season and soil type.</div>
                </div>
            </div>
        </a>

        <a href="{{ route('guide', 'harvest') }}" class="tip-link">
            <div class="tip-card">
                <div class="tip-icon">🚜</div>
                <div>
                    <div class="tip-title">Harvest Planning</div>
                    <div class="tip-text">Harvest when 80–85% of grains are golden yellow. Avoid delays to prevent grain shattering losses.</div>
                </div>
            </div>
        </a>

    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <h2>Ready to Protect Your Paddy? </h2>
    <p>Join thousands of Sri Lankan farmers using AI-powered disease detection to save their crops.</p>
    @guest
        <a href="{{ route('register') }}">
            <button class="btn-cta">Register as Farmer — Free</button>
        </a>
    @else
        @if(auth()->user()->role === 'farmer')
        <a href="{{ route('farmer.diagnosis') }}">
            <button class="btn-cta"> Start Disease Check</button>
        </a>
        @endif
    @endguest
</section>

@endsection