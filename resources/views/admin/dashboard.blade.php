@extends('admin.layouts.app')

@section('title', 'Dashboard — ETECH Admin')

@section('content')
    <div class="page-head">
        <h1>Dashboard</h1>
    </div>

    {{-- ==================== STAT CARDS ==================== --}}
    <div class="dash-stats">
        <div class="dash-card">
            <div class="dash-card-top">
                <span class="dash-card-label">Total Artikel</span>
                <span class="dash-icon" style="background:#EAE7FB;color:#6C5CE0;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="8" y1="14" x2="16" y2="14"/></svg>
                </span>
            </div>
            <h3>{{ $totalArticles }}</h3>
        </div>

        <div class="dash-card">
            <div class="dash-card-top">
                <span class="dash-card-label">Artikel Terbit</span>
                <span class="dash-icon" style="background:var(--ok-bg);color:var(--ok-fg);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6 9 17l-5-5"/></svg>
                </span>
            </div>
            <h3>{{ $publishedArticles }}</h3>
        </div>

        <div class="dash-card">
            <div class="dash-card-top">
                <span class="dash-card-label">Draft / Terjadwal</span>
                <span class="dash-icon" style="background:var(--draft-bg);color:var(--draft-fg);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </span>
            </div>
            <h3>{{ $draftArticles }}</h3>
        </div>

        <div class="dash-card">
            <div class="dash-card-top">
                <span class="dash-card-label">Total Views</span>
                <span class="dash-icon" style="background:#DFEBF8;color:#3E7CB1;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                </span>
            </div>
            <h3>{{ $totalViews }}</h3>
        </div>
    </div>

    {{-- ==================== KATEGORI + STATUS ==================== --}}
    <div class="dash-row dash-row-charts">
        <div class="panel dash-panel">
            <h3 class="dash-panel-title">Artikel per Kategori</h3>
            <div class="dash-chart-wrap">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <div class="panel dash-panel">
            <h3 class="dash-panel-title">Distribusi Status</h3>
            <div class="dash-chart-wrap dash-chart-donut">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ==================== TREN VIEWS + ARTIKEL TERAKHIR ==================== --}}
    <div class="dash-row dash-row-bottom">
        <div class="panel dash-panel">
            <h3 class="dash-panel-title">Tren Views Mingguan</h3>
            <div class="dash-chart-wrap">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <div class="panel dash-panel">
            <h3 class="dash-panel-title">Artikel Terakhir</h3>
            <div class="dash-recent-list">
                @forelse($latestArticles as $article)
                    <div class="dash-recent-item">
                        @if($article->thumbnail)
                            <img class="thumb" src="{{ Storage::url($article->thumbnail) }}" alt="">
                        @else
                            <div class="thumb">IMG</div>
                        @endif
                        <div class="dash-recent-info">
                            <p class="dash-recent-title">{{ Str::limit($article->title, 45) }}</p>
                            <span class="dash-recent-cat">{{ $article->category->name ?? '—' }}</span>
                            <span class="dash-recent-date">{{ $article->created_at->format('d M Y') }}</span>
                        </div>
                        <span class="dash-recent-views">{{ $article->views_count }} views</span>
                    </div>
                @empty
                    <div class="empty-state">Belum ada artikel.</div>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        .dash-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:20px;}
        .dash-card{background:var(--panel);border:1px solid var(--border);border-radius:14px;padding:18px 20px;}
        .dash-card-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;}
        .dash-card-label{font-size:12px;color:var(--muted);letter-spacing:.04em;font-weight:600;text-transform:uppercase;}
        .dash-card h3{margin:0;font-family:'Fraunces',serif;font-size:28px;}
        .dash-icon{width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}

        .dash-row{display:grid;gap:20px;margin-bottom:20px;}
        .dash-row-charts{grid-template-columns:2fr 1fr;}
        .dash-row-bottom{grid-template-columns:1.4fr 1fr;}
        .dash-panel{padding:22px 24px;}
        .dash-panel-title{font-family:'Fraunces',serif;font-size:16px;font-weight:600;margin:0 0 18px;}
        .dash-chart-wrap{position:relative;height:280px;}
        .dash-chart-donut{display:flex;align-items:center;justify-content:center;}

        .dash-recent-list{display:flex;flex-direction:column;gap:14px;max-height:320px;overflow-y:auto;}
        .dash-recent-item{display:flex;align-items:center;gap:12px;}
        .dash-recent-info{flex:1;min-width:0;}
        .dash-recent-title{margin:0 0 4px;font-size:14px;font-weight:600;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
        .dash-recent-cat{color:var(--rust);font-size:12px;font-weight:600;margin-right:8px;}
        .dash-recent-date{color:var(--muted);font-size:12px;}
        .dash-recent-views{color:var(--muted);font-size:12.5px;white-space:nowrap;flex-shrink:0;}

        @media (max-width: 1100px){
            .dash-stats{grid-template-columns:repeat(2,1fr);}
            .dash-row-charts,.dash-row-bottom{grid-template-columns:1fr;}
        }
        @media (max-width: 500px){
            .dash-stats{grid-template-columns:1fr;}
        }
    </style>
@endsection

@section('js')
   <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const inkMuted = '#8A7767';
        const gridColor = '#E7DACB';

        // ---- Artikel per Kategori (Bar) ----
        new Chart(document.getElementById('categoryChart'), {
            type: 'bar',
            data: {
                labels: @json($categoryLabels),
                datasets: [{
                    data: @json($categoryCounts),
                    backgroundColor: '#6E7BA6',
                    borderRadius: 6,
                    maxBarThickness: 60
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: inkMuted, font: { size: 11 } } },
                    y: { beginAtZero: true, ticks: { precision: 0, color: inkMuted }, grid: { color: gridColor } }
                }
            }
        });

        // ---- Distribusi Status (Doughnut) ----
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Published', 'Draft', 'Terjadwal'],
                datasets: [{
                    data: @json($statusCounts),
                    backgroundColor: ['#6E8F63', '#D9A441', '#8A7767'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#3A2A1C', usePointStyle: true, pointStyle: 'circle', padding: 16 }
                    }
                }
            }
        });

        // ---- Tren Views Mingguan (Line/Area) ----
        new Chart(document.getElementById('trendChart'), {
            type: 'line',
            data: {
                labels: @json($weeklyViewsLabels),
                datasets: [{
                    label: 'Views',
                    data: @json($weeklyViewsData),
                    borderColor: '#D9A441',
                    backgroundColor: 'rgba(217,164,65,0.18)',
                    pointBackgroundColor: '#D9A441',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#3A2A1C', usePointStyle: true, pointStyle: 'circle', padding: 16 }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { color: inkMuted } },
                    y: { beginAtZero: true, ticks: { precision: 0, color: inkMuted }, grid: { color: gridColor } }
                }
            }
        });
    });
    </script>
@endsection