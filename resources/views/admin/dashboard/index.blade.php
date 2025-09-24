@extends('templates.app')

@section('title', 'Dashboard')

@push('styles')
<style>
  /* ====== Tokens & polish ====== */
  :root{
    --radius: 14px;
  }
  .dash-wrap { max-width: 1200px; margin: 0 auto; }

  .card { border-radius: var(--radius); border: 1px solid rgba(0,0,0,.06); }
  .card:hover { transform: translateY(-1px); transition: .18s ease; box-shadow: 0 .5rem 1rem rgba(0,0,0,.06)!important; }

  .kpi .card-body{ display:flex; flex-direction:column; gap:.25rem; }
  .kpi .display-6{ line-height:1; }
  .kpi .text-muted.small{ white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }

  .section-title{
    font-weight: 700;
    font-size: 1rem;
    margin: 0 0 .5rem;
    display: flex; align-items: center; gap: .5rem;
  }
  .section-title i{ opacity:.75; }

  .list-group-item{ border-left:0; border-right:0; }
  .list-group-item:first-child{ border-top:0; }
  .list-group-item:last-child{ border-bottom:0; }

  .text-2line{
    display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
  }

  /* Empty state */
  .empty{
    padding: 16px; text-align:center; color: var(--bs-secondary-color);
    background: var(--bs-tertiary-bg); border-radius: var(--radius);
    border: 1px dashed var(--bs-border-color);
  }

  /* Header pills */
  .role-pill{ font-weight:600; letter-spacing:.2px; }

  /* Chart container padding */
  #trendChart{ max-height: 320px; }

  /* Dark mode */
  @media (prefers-color-scheme: dark){
    .card{ border-color: rgba(255,255,255,.08); }
    .card:hover{ box-shadow: 0 .5rem 1rem rgba(0,0,0,.35)!important; }
    .empty{ border-color: rgba(255,255,255,.12); }
  }

  /* Mobile tweaks */
  @media (max-width: 576px){
    .display-6{ font-size: 2rem; }
    .kpi .card-body{ gap:.35rem; }
  }
</style>
@endpush

@section('content')
<div class="container py-4 dash-wrap">
  {{-- ===== Header ===== --}}
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div class="d-flex align-items-center gap-2">
      <h2 class="mb-0">Dashboard</h2>
      <span class="badge bg-light text-secondary border d-none d-sm-inline">Tahun: {{ $tahun }}</span>
    </div>
    @if($isSuper)
      <span class="badge bg-danger role-pill">Superadmin</span>
    @else
      <span class="badge bg-secondary-subtle text-secondary-emphasis border role-pill">
        Mode Admin
      </span>
    @endif
  </div>

  {{-- ===== KPI GRID ===== --}}
  <div class="row g-3 mb-4 kpi">
    @if($can['course'])
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Total Course</div>
            <div class="display-6 fw-semibold">{{ $kpi['course_total'] }}</div>
            <div class="small text-muted">Free: {{ $kpi['course_free'] }} · Paid: {{ $kpi['course_paid'] }}</div>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Total Lesson</div>
            <div class="display-6 fw-semibold">{{ $kpi['lesson_total'] }}</div>
            <div class="small text-muted">Kategori: {{ $kpi['category_total'] }}</div>
          </div>
        </div>
      </div>
    @endif

    @if($can['showcase'])
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Showcase</div>
            <div class="display-6 fw-semibold">{{ $kpi['showcase_total'] }}</div>
          </div>
        </div>
      </div>
    @endif

    @if($can['testimonial'])
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Testimonial</div>
            <div class="display-6 fw-semibold">{{ $kpi['testimonial_total'] }}</div>
            <div class="small text-muted">Published: {{ $kpi['testimonial_pub'] }}</div>
          </div>
        </div>
      </div>
    @endif

    @if($can['instructor'])
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Instructors</div>
            <div class="display-6 fw-semibold">{{ $kpi['instructor_total'] }}</div>
          </div>
        </div>
      </div>
    @endif

    @if($can['forum'])
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Forum Categories</div>
            <div class="display-6 fw-semibold">{{ $kpi['forum_cat_total'] }}</div>
            <div class="small text-muted">
              Threads: {{ $kpi['forum_thread_total'] }} · Posts: {{ $kpi['forum_post_total'] }}
            </div>
            <div class="small text-muted">Locked: {{ $kpi['forum_locked_total'] }}</div>
          </div>
        </div>
      </div>
    @endif

    @if($can['about'])
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">About Items</div>
            <div class="display-6 fw-semibold">{{ $kpi['about_total'] }}</div>
            <div class="small text-muted">Sections: {{ $kpi['about_sections'] }}</div>
          </div>
        </div>
      </div>
    @endif

    @if($can['contact'])
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Contact Config</div>
            <div class="display-6 fw-semibold">
              {{ $kpi['contact_is_configured'] ? 'OK' : 'Belum' }}
            </div>
            <div class="small text-muted">Social filled: {{ $kpi['contact_social_filled'] }}</div>
          </div>
        </div>
      </div>
    @endif
  </div>

  {{-- ===== RINGKASAN BULAN INI ===== --}}
  <div class="row g-3 mb-4">
    @if($can['course'])
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Course baru (bulan ini)</div>
              <div class="h3 mb-0">{{ $bulanIni['course'] }}</div>
            </div>
            <i class="fas fa-graduation-cap fa-2x text-primary"></i>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Lesson baru (bulan ini)</div>
              <div class="h3 mb-0">{{ $bulanIni['lesson'] }}</div>
            </div>
            <i class="fas fa-book-open fa-2x text-success"></i>
          </div>
        </div>
      </div>
    @endif

    @if($can['showcase'])
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Showcase baru (bulan ini)</div>
              <div class="h3 mb-0">{{ $bulanIni['showcase'] }}</div>
            </div>
            <i class="fas fa-images fa-2x text-info"></i>
          </div>
        </div>
      </div>
    @endif

    @if($can['testimonial'])
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Testimonial baru (bulan ini)</div>
              <div class="h3 mb-0">{{ $bulanIni['testimonial'] }}</div>
            </div>
            <i class="fas fa-comment-dots fa-2x text-warning"></i>
          </div>
        </div>
      </div>
    @endif

    @if($can['forum'])
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Thread baru (bulan ini)</div>
              <div class="h3 mb-0">{{ $bulanIni['forum_thread'] }}</div>
            </div>
            <i class="fas fa-comments fa-2x text-secondary"></i>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Post baru (bulan ini)</div>
              <div class="h3 mb-0">{{ $bulanIni['forum_post'] }}</div>
            </div>
            <i class="fas fa-reply fa-2x text-muted"></i>
          </div>
        </div>
      </div>
    @endif
  </div>

  {{-- ===== GRAFIK TREN TAHUN INI ===== --}}
  @php
    $hasSeries = ($can['course'] && (!empty($series['course']) || !empty($series['lesson'])))
              || ($can['showcase'] && !empty($series['showcase']))
              || ($can['testimonial'] && !empty($series['testimonial']))
              || ($can['forum'] && (!empty($series['forum_thread']) || !empty($series['forum_post'])));
  @endphp

  @if($hasSeries)
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title mb-0">Tren {{ $tahun }}</h5>
          <span class="text-muted small">Per Bulan</span>
        </div>
        <canvas id="trendChart" aria-label="Grafik tren per bulan" role="img"></canvas>
      </div>
    </div>
  @endif

  {{-- ===== LIST TERBARU ===== --}}
  <div class="row g-3">
    @if($can['course'])
      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="section-title"><i class="fas fa-graduation-cap"></i> <span>Course Terbaru</span></div>

            @if(!empty($latest['courses']) && count($latest['courses'])>0)
              <ul class="list-group list-group-flush">
                @foreach($latest['courses'] as $c)
                  <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="me-3">
                      <div class="fw-semibold text-truncate" title="{{ $c->name }}">{{ $c->name }}</div>
                      <div class="text-muted small">
                        {{ $c->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                      </div>
                    </div>
                    <div class="text-nowrap">
                      <a href="{{ route('admin.detail.index') }}" class="btn btn-sm btn-outline-primary">Detail</a>
                    </div>
                  </li>
                @endforeach
              </ul>
            @else
              <div class="empty">Belum ada course terbaru.</div>
            @endif
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="section-title"><i class="fas fa-book-open"></i> <span>Lesson Terbaru</span></div>

            @if(!empty($latest['lessons']) && count($latest['lessons'])>0)
              <ul class="list-group list-group-flush">
                @foreach($latest['lessons'] as $l)
                  <li class="list-group-item">
                    <div class="fw-semibold text-truncate" title="{{ $l->title }}">{{ $l->title }}</div>
                    <div class="text-muted small">
                      Modul: {{ $l->module_name ?? '-' }} ·
                      {{ $l->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                    </div>
                  </li>
                @endforeach
              </ul>
            @else
              <div class="empty">Belum ada lesson terbaru.</div>
            @endif
          </div>
        </div>
      </div>
    @endif

    @if($can['showcase'])
      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="section-title"><i class="fas fa-images"></i> <span>Showcase Terbaru</span></div>

            @if(!empty($latest['showcases']) && count($latest['showcases'])>0)
              <ul class="list-group list-group-flush">
                @foreach($latest['showcases'] as $s)
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="text-truncate" title="{{ $s->title }}">{{ $s->title }}</span>
                    <span class="text-muted small">{{ $s->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</span>
                  </li>
                @endforeach
              </ul>
            @else
              <div class="empty">Belum ada showcase terbaru.</div>
            @endif
          </div>
        </div>
      </div>
    @endif

    @if($can['testimonial'])
      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="section-title"><i class="fas fa-comment-dots"></i> <span>Testimonial Terbaru</span></div>

            @if(!empty($latest['testis']) && count($latest['testis'])>0)
              <ul class="list-group list-group-flush">
                @foreach($latest['testis'] as $t)
                  <li class="list-group-item">
                    <div class="d-flex align-items-center gap-2 text-muted small">
                      <span>{{ $t->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</span>
                      @if($t->is_published)
                        <span class="badge bg-primary">Published</span>
                      @endif
                    </div>
                    <div class="fw-semibold text-2line">{{ Str::limit(strip_tags($t->content), 160) }}</div>
                  </li>
                @endforeach
              </ul>
            @else
              <div class="empty">Belum ada testimonial terbaru.</div>
            @endif
          </div>
        </div>
      </div>
    @endif

    @if($can['forum'])
      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="section-title"><i class="fas fa-comments"></i> <span>Thread Terbaru</span></div>

            @if(!empty($latest['threads']) && count($latest['threads'])>0)
              <ul class="list-group list-group-flush">
                @foreach($latest['threads'] as $th)
                  <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="me-3">
                      <div class="fw-semibold text-truncate" title="{{ $th->title }}">{{ $th->title }}</div>
                      <div class="text-muted small">{{ $th->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</div>
                    </div>
                    @if($th->is_locked)
                      <span class="badge bg-secondary">Locked</span>
                    @endif
                  </li>
                @endforeach
              </ul>
            @else
              <div class="empty">Belum ada thread terbaru.</div>
            @endif
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="section-title"><i class="fas fa-reply"></i> <span>Post Terbaru</span></div>

            @if(!empty($latest['posts']) && count($latest['posts'])>0)
              <ul class="list-group list-group-flush">
                @foreach($latest['posts'] as $p)
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="text-truncate">Post #{{ $p->id }} (Thread #{{ $p->thread_id }})</span>
                    <span class="text-muted small">{{ $p->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</span>
                  </li>
                @endforeach
              </ul>
            @else
              <div class="empty">Belum ada post terbaru.</div>
            @endif
          </div>
        </div>
      </div>
    @endif
  </div>
</div>
@endsection

@push('scripts')
  @if( ($can['course'] && (!empty($series['course']) || !empty($series['lesson'])))
    || ($can['showcase'] && !empty($series['showcase']))
    || ($can['testimonial'] && !empty($series['testimonial']))
    || ($can['forum'] && (!empty($series['forum_thread']) || !empty($series['forum_post']))) )
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      (function(){
        const labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        const datasets = [];

        const withStyle = (label, data, colorVar) => {
          // pakai warna Bootstrap jika ada, fallback ke warna default Chart.js
          const css = getComputedStyle(document.documentElement);
          const color = getComputedStyle(document.body).getPropertyValue(colorVar) || css.getPropertyValue('--bs-primary') || '#0d6efd';
          return {
            label, data,
            borderColor: color.trim(),
            backgroundColor: color.trim() + '33', // 20% alpha
            borderWidth: 2, tension: .3, fill: false, pointRadius: 2
          };
        };

        @if($can['course'])
          datasets.push(withStyle('Course', @json($series['course']), '--bs-primary'));
          datasets.push(withStyle('Lesson', @json($series['lesson']), '--bs-success'));
        @endif
        @if($can['showcase'])
          datasets.push(withStyle('Showcase', @json($series['showcase']), '--bs-info'));
        @endif
        @if($can['testimonial'])
          datasets.push(withStyle('Testimonial', @json($series['testimonial']), '--bs-warning'));
        @endif
        @if($can['forum'])
          datasets.push(withStyle('Forum Threads', @json($series['forum_thread']), '--bs-secondary'));
          datasets.push(withStyle('Forum Posts', @json($series['forum_post']), '--bs-gray'));
        @endif

        const el = document.getElementById('trendChart');
        if (!el) return;

        new Chart(el, {
          type: 'line',
          data: { labels, datasets },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
              legend: { position: 'top', labels: { usePointStyle:true, boxWidth:8 } },
              tooltip: { intersect:false, mode:'index' }
            },
            scales: {
              y: { beginAtZero: true, ticks: { precision: 0 } },
              x: { ticks: { autoSkip: true, maxRotation: 0 } }
            }
          }
        });
      })();
    </script>
  @endif
@endpush
