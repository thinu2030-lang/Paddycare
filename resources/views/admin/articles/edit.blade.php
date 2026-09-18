@extends('layouts.app')
@section('title', 'Edit Article')

@push('styles')
<style>
    .dashboard-wrap { display: grid; grid-template-columns: 220px 1fr; min-height: calc(100vh - 100px); }
    .sidebar { background: #1a5c2e; padding: 24px 0; position: sticky; top: 60px; height: calc(100vh - 60px); overflow-y: auto; }
    .sidebar-user { padding: 0 20px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 12px; }
    .sidebar-avatar { width: 48px; height: 48px; background: #6fdc9e; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; color: #0a3318; margin-bottom: 10px; }
    .sidebar-name { color: #fff; font-weight: 600; font-size: 14px; }
    .sidebar-role { color: #a5d6b0; font-size: 12px; }
    .sidebar-section { font-size: 10px; color: #6fdc9e; letter-spacing: 1px; text-transform: uppercase; padding: 14px 20px 6px; }
    .sidebar-link { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: #a5d6b0; font-size: 13px; border-left: 3px solid transparent; transition: all 0.2s; text-decoration: none; }
    .sidebar-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
    .sidebar-link.active { background: rgba(255,255,255,0.12); color: #fff; border-left-color: #6fdc9e; font-weight: 500; }
    .main-content { padding: 28px; background: #f4f6f4; }
    .page-title { font-size: 22px; font-weight: 700; color: #1a2e1e; margin-bottom: 24px; }
    .form-card { background: #fff; border-radius: 12px; padding: 28px; border: 1px solid #e0e8e2; max-width: 760px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-group { margin-bottom: 18px; }
    .form-label { display: block; font-size: 13px; font-weight: 500; color: #333; margin-bottom: 7px; }
    .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid #d0ddd4; border-radius: 8px; font-size: 13px; color: #1a1a1a; background: #f8fdf9; transition: border-color 0.2s; }
    .form-control:focus { outline: none; border-color: #1a5c2e; background: #fff; }
    .btn-submit { background: #1a5c2e; color: #fff; padding: 12px 28px; border-radius: 8px; font-size: 14px; font-weight: 600; border: none; cursor: pointer; }
    .btn-submit:hover { background: #144a24; }
    .btn-back { background: transparent; color: #555; padding: 12px 20px; border-radius: 8px; font-size: 14px; border: 1.5px solid #d0ddd4; cursor: pointer; }
    .checkbox-group { display: flex; align-items: center; gap: 8px; margin-top: 12px; }
    .checkbox-group input { width: 16px; height: 16px; cursor: pointer; }
    .checkbox-group label { font-size: 13px; color: #333; cursor: pointer; }
    .current-image {
        width: 140px; border-radius: 8px; margin-bottom: 10px;
        display: block; border: 1px solid #e0e8e2;
    }
    .image-upload-box {
        border: 2px dashed #a5d6b0; border-radius: 10px;
        padding: 16px; text-align: center; background: #f8fdf9;
        cursor: pointer; transition: all 0.2s;
    }
    .image-upload-box:hover { border-color: #1a5c2e; background: #f0fbf4; }
    .image-upload-box input[type=file] { display: none; }
    .upload-label { color: #1a5c2e; font-size: 13px; font-weight: 500; cursor: pointer; }
    .upload-hint { font-size: 11px; color: #888; margin-top: 4px; }
    #imagePreview {
        max-width: 200px; max-height: 140px; border-radius: 8px;
        margin-top: 12px; display: none; border: 1px solid #e0e8e2;
    }
</style>
@endpush

@section('content')
<div class="dashboard-wrap">
    <aside class="sidebar">
        <div class="sidebar-user">
            <div class="sidebar-avatar">AD</div>
            <div class="sidebar-name">Administrator</div>
            <div class="sidebar-role">🛡️ System Admin</div>
        </div>
        <div class="sidebar-section">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a>
        
        <div class="sidebar-section">Users</div>
        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">👥 All Users</a>
        <a href="{{ route('admin.users.create') }}" class="sidebar-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">➕ Add Officer</a>
        
        <div class="sidebar-section">Content</div>
        <a href="{{ route('admin.articles.index') }}" class="sidebar-link {{ request()->routeIs('admin.articles*') ? 'active' : '' }}">📖 Articles</a>
        <a href="{{ route('admin.diseases.index') }}" class="sidebar-link {{ request()->routeIs('admin.diseases*') ? 'active' : '' }}">🦠 Diseases</a>
        
        <div class="sidebar-section">Reports</div>
        <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">📊 Officer Reports</a>
        
        <form method="POST" action="{{ route('logout') }}" style="margin-top:20px;">
            @csrf
            <button type="submit" class="sidebar-link" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;">🚪 Logout</button>
        </form>
    </aside>

    <main class="main-content">
        <div class="page-title">✏️ Edit Article — {{ $article->title }}</div>
        <div class="form-card">
            <form method="POST" action="{{ route('admin.articles.update', $article->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    @if($article->image)
                        <img src="{{ asset('storage/'.$article->image) }}" alt="Current" class="current-image">
                    @endif
                    <label class="form-label">📷 Article Image (Leave empty to keep current)</label>
                    <div class="image-upload-box" onclick="document.getElementById('imageInput').click()">
                        <input type="file" name="image" id="imageInput" accept="image/*" onchange="previewImage(this)">
                        <span class="upload-label">📤 Click to upload a new image</span>
                        <div class="upload-hint">JPG, PNG — Max 2MB</div>
                        <img id="imagePreview" src="" alt="Preview">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Article Title</label>
                    <input type="text" name="title" class="form-control"
                           value="{{ old('title', $article->title) }}"
                           placeholder="Article title..." required
                           oninput="generateSlug(this.value)">
                </div>

                <div class="form-group">
                    <label class="form-label">URL Slug</label>
                    <input type="text" name="slug" id="slugField" class="form-control"
                           value="{{ old('slug', $article->slug) }}" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-control" required>
                            @foreach(['irrigation'=>'💧 Irrigation','fertilizer'=>'🧪 Fertilizer','weed'=>'✂️ Weed Control','pest'=>'🐛 Pest Control','harvest'=>'🌾 Harvest','seed'=>'🌱 Seed Selection'] as $val => $label)
                                <option value="{{ $val }}"
                                    {{ old('category', $article->category) === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Publish Status</label>
                        <div class="checkbox-group">
                            <input type="checkbox" name="is_published" id="published" value="1"
                                   {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                            <label for="published">✅ Published</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Article Content</label>
                    <textarea name="content" class="form-control" rows="12" required>{{ old('content', $article->content) }}</textarea>
                </div>

                <div style="display:flex; gap:10px;">
                    <button type="submit" class="btn-submit">💾 Update Article</button>
                    <a href="{{ route('admin.articles.index') }}">
                        <button type="button" class="btn-back">← Back</button>
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
function generateSlug(title) {
    const slug = title.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim();
    document.getElementById('slugField').value = slug;
}
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush