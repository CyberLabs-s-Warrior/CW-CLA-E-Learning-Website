@extends('layouts.guest')

@push('styles')
<link rel="stylesheet" href="{{ asset('guest/testimoni.css') }}">
@endpush

@section('content')
<section class="testimoni-section">
  <div class="testimoni-header">
    <h1 class="testimoni-title">Apa Kata Mereka</h1>
    <p class="testimoni-subtitle">
      Ulasan jujur dari member yang telah mengikuti kursus dan belajar bersama kami.
    </p>
  </div>

  <div class="testimoni-grid">
    @forelse ($testimonials as $t)
      @php
        $name = $t->user->name ?? 'Student';
        $parts = preg_split('/\s+/', trim($name));
        $initials = strtoupper(mb_substr($parts[0] ?? '', 0, 1) . mb_substr(end($parts) ?: '', 0, 1));
        $hue = crc32($name) % 360;
      @endphp

      <div class="testimoni-card {{ $loop->index >= 6 ? 'is-hidden' : '' }}" data-card>
        <div class="testimoni-profile">
          <div class="avatar" style="--hue: {{ $hue }}">{{ $initials }}</div>
          <div class="testimoni-user">
            <h3>{{ $name }}</h3>
            <span class="testimoni-role">Student</span>
          </div>
        </div>
        <div class="testimoni-text">
          <p>"{{ $t->content }}"</p>
        </div>
      </div>
    @empty
      <p style="text-align:center;color:#64748b">Belum ada testimoni.</p>
    @endforelse
  </div>

  @if($testimonials->count() > 6)
    <div class="testimoni-actions">
      <button id="btn-more" class="btn-more" type="button" aria-expanded="false">
        Lihat lainnya
      </button>
    </div>
  @endif
</section>
@endsection

@push('scripts')
@if($testimonials->count() > 6)
<script>
  (function () {
    const btn = document.getElementById('btn-more');
    if (!btn) return;
    btn.addEventListener('click', function(){
      document.querySelectorAll('.testimoni-card.is-hidden').forEach(el => el.classList.remove('is-hidden'));
      this.setAttribute('aria-expanded', 'true');
      this.remove(); // hilangkan tombol setelah tampil semua
    });
  })();
</script>
@endif
@endpush
