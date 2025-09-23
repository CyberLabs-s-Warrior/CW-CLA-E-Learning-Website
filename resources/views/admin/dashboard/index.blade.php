@extends('templates.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Dashboard</h2>
    @if($isSuper)
      <span class="badge bg-danger">Superadmin</span>
    @else
      <span class="text-muted small">Mode Admin (berdasarkan permission)</span>
    @endif
  </div>

  {{-- ===== KPI GRID (tampil hanya yang diizinkan) ===== --}}
  <div class="row g-3 mb-3">
    @if($can['course'])
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Total Course</div>
            <div class="display-6 fw-semibold">{{ $kpi['course_total'] }}</div>
            <div class="small text-muted">Free: {{ $kpi['course_free'] }} · Paid: {{ $kpi['course_paid'] }}</div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
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
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Showcase</div>
            <div class="display-6 fw-semibold">{{ $kpi['showcase_total'] }}</div>
          </div>
        </div>
      </div>
    @endif

    @if($can['testimonial'])
      <div class="col-sm-6 col-lg-3">
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
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Instructors</div>
            <div class="display-6 fw-semibold">{{ $kpi['instructor_total'] }}</div>
          </div>
        </div>
      </div>
    @endif

    @if($can['forum'])
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="text-muted small">Forum Categories</div>
            <div class="display-6 fw-semibold">{{ $kpi['forum_cat_total'] }}</div>
            <div class="small text-muted">Threads: {{ $kpi['forum_thread_total'] }} · Posts: {{ $kpi['forum_post_total'] }}</div>
            <div class="small text-muted">Locked: {{ $kpi['forum_locked_total'] }}</div>
          </div>
        </div>
      </div>
    @endif

    @if($can['about'])
      <div class="col-sm-6 col-lg-3">
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
      <div class="col-sm-6 col-lg-3">
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

  {{-- ===== GRAFIK TREN TAHUN INI (dataset kondisional) ===== --}}
  @php
    $hasSeries = ($can['course'] && (!empty($series['course']) || !empty($series['lesson'])))
              || ($can['showcase'] && !empty($series['showcase']))
              || ($can['testimonial'] && !empty($series['testimonial']))
              || ($can['forum'] && (!empty($series['forum_thread']) || !empty($series['forum_post'])));
  @endphp

  @if($hasSeries)
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h5 class="card-title mb-0">Tren {{ $tahun }}</h5>
          <span class="text-muted small">Per Bulan</span>
        </div>
        <canvas id="trendChart" height="96"></canvas>
      </div>
    </div>
  @endif

  {{-- ===== LIST TERBARU (per fitur yang diizinkan) ===== --}}
  <div class="row g-3">
    @if($can['course'])
      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h6 class="card-title">Course Terbaru</h6>
            <ul class="list-group list-group-flush">
              @forelse($latest['courses'] as $c)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div class="me-3">
                    <div class="fw-semibold">{{ $c->name }}</div>
                    <div class="text-muted small">{{ $c->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</div>
                  </div>
                  <div class="text-nowrap">
                    <a href="{{ route('admin.detail.index') }}" class="btn btn-sm btn-outline-primary">Detail</a>
                  </div>
                </li>
              @empty
                <li class="list-group-item text-muted">Belum ada data.</li>
              @endforelse
            </ul>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h6 class="card-title">Lesson Terbaru</h6>
            <ul class="list-group list-group-flush">
              @forelse($latest['lessons'] as $l)
                <li class="list-group-item">
                  <div class="fw-semibold">{{ $l->title }}</div>
                  <div class="text-muted small">Modul: {{ $l->module_name ?? '-' }} · {{ $l->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</div>
                </li>
              @empty
                <li class="list-group-item text-muted">Belum ada data.</li>
              @endforelse
            </ul>
          </div>
        </div>
      </div>
    @endif

    @if($can['showcase'])
      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h6 class="card-title">Showcase Terbaru</h6>
            <ul class="list-group list-group-flush">
              @forelse($latest['showcases'] as $s)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span>{{ $s->title }}</span>
                  <span class="text-muted small">{{ $s->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</span>
                </li>
              @empty
                <li class="list-group-item text-muted">Belum ada data.</li>
              @endforelse
            </ul>
          </div>
        </div>
      </div>
    @endif

    @if($can['testimonial'])
      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h6 class="card-title">Testimonial Terbaru</h6>
            <ul class="list-group list-group-flush">
              @forelse($latest['testis'] as $t)
                <li class="list-group-item">
                  <div class="text-muted small">{{ $t->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                    @if($t->is_published) · <span class="badge bg-primary">Published</span> @endif
                  </div>
                  <div class="fw-semibold text-truncate" style="-webkit-line-clamp:2; display:-webkit-box; -webkit-box-orient:vertical; overflow:hidden;">
                    {{ Str::limit(strip_tags($t->content), 160) }}
                  </div>
                </li>
              @empty
                <li class="list-group-item text-muted">Belum ada data.</li>
              @endforelse
            </ul>
          </div>
        </div>
      </div>
    @endif

    @if($can['forum'])
      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h6 class="card-title">Thread Terbaru</h6>
            <ul class="list-group list-group-flush">
              @forelse($latest['threads'] as $th)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div class="me-3">
                    <div class="fw-semibold">{{ $th->title }}</div>
                    <div class="text-muted small">{{ $th->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</div>
                  </div>
                  @if($th->is_locked)
                    <span class="badge bg-secondary">Locked</span>
                  @endif
                </li>
              @empty
                <li class="list-group-item text-muted">Belum ada data.</li>
              @endforelse
            </ul>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h6 class="card-title">Post Terbaru</h6>
            <ul class="list-group list-group-flush">
              @forelse($latest['posts'] as $p)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span>Post #{{ $p->id }} (Thread #{{ $p->thread_id }})</span>
                  <span class="text-muted small">{{ $p->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</span>
                </li>
              @empty
                <li class="list-group-item text-muted">Belum ada data.</li>
              @endforelse
            </ul>
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

        @if($can['course'])
          datasets.push({ label:'Course',   data:@json($series['course']),       borderWidth:2, tension:.3 });
          datasets.push({ label:'Lesson',   data:@json($series['lesson']),       borderWidth:2, tension:.3 });
        @endif
        @if($can['showcase'])
          datasets.push({ label:'Showcase', data:@json($series['showcase']),     borderWidth:2, tension:.3 });
        @endif
        @if($can['testimonial'])
          datasets.push({ label:'Testimonial', data:@json($series['testimonial']), borderWidth:2, tension:.3 });
        @endif
        @if($can['forum'])
          datasets.push({ label:'Forum Threads', data:@json($series['forum_thread']), borderWidth:2, tension:.3 });
          datasets.push({ label:'Forum Posts',   data:@json($series['forum_post']),   borderWidth:2, tension:.3 });
        @endif

        const el = document.getElementById('trendChart');
        if (!el) return;

        new Chart(el, {
          type: 'line',
          data: { labels, datasets },
          options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { position: 'top' } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
          }
        });
      })();
    </script>
  @endif
@endpush
