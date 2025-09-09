@extends('layouts.guest')

@push('styles')
  <link rel="stylesheet" href="{{ asset('guest/about.css') }}">
@endpush

@section('content')

  <!-- Hero Header About -->
  <section class="about-hero" style="background-image:url('{{ asset('image/banner.jpg') }}')">
    <div class="about-hero-overlay">
      <h1>ABOUT US</h1>
    </div>
  </section>

  <!-- Tentang Kami -->
  <section class="about-section">
    <div class="about-text">
      <h2>Tentang E-Learning Kami</h2>
      <p>
        Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin
        literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at
        Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem
        Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable
        source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes
        of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular
        during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in
        section 1.10.32.
      </p>
    </div>
    <div class="about-image">
      <img src="{{ asset('image/si-imut.png') }}" alt="Tentang Kami">
    </div>
  </section>

  <!-- VISI & MISI (dibersihkan dari inline style) -->
  <section class="visi-misi">
    <!-- VISI -->
    <div class="vm-row">
      <img class="vm-image" src="{{ asset('image/laptop1.png') }}" alt="Visi">
      <div class="vm-text">
        <h3>VISI</h3>
        <p>{!! $visi->description ?? '-' !!}</p>
      </div>
    </div>

    <!-- MISI -->
    <div class="vm-row vm-row--reverse">
      <img class="vm-image" src="{{ asset('image/laptop2.png') }}" alt="Misi">
      <div class="vm-text">
        <h3>MISI</h3>
        <p>{{ $misi->description ?? '-' }}</p>
      </div>
    </div>
  </section>

  <!-- Sejarah -->
  <section class="sejarah-section">
    <div class="sejarah-content">
      <h3>📜 Sejarah Singkat</h3>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin tincidunt, justo vel vehicula dignissim,
        lorem justo volutpat nulla, ac dignissim massa magna sed velit. Vestibulum tincidunt diam ut risus gravida,
        at facilisis enim luctus. Sed convallis sagittis orci, sed pulvinar sapien. Curabitur feugiat, felis non
        porttitor vestibulum, ex risus vulputate neque, sit amet posuere est nunc vel justo, jsdlkafjpasjfj,
        fsfspajfopsdfjdsaf, kfgjs aogjsdgjsj ogaopjopjasopjgpa, gangoisdjgopajg,gsa ghsidjgpdosj,gsdng shgkds,g,,jgsd gjopdsjgopsj.
      </p>
    </div>
  </section>

  <!-- Tim Kami + Pagination -->
  <section class="timkami-section">
    <h3>Tim Kami</h3>
    <p>Kami terdiri dari pengajar berpengalaman dan tim kreatif yang berdedikasi pada pendidikan online berkualitas.</p>

    <div id="timkami-container" class="timkami-grid">
      <img src="{{ asset('image/galeri1.jpeg') }}" alt="Tim 1">
      <img src="{{ asset('image/galeri2.jpeg') }}" alt="Tim 2">
      <img src="{{ asset('image/galeri3.jpeg') }}" alt="Tim 3">
      <img src="{{ asset('image/galeri1.jpeg') }}" alt="Tim 4">
      <img src="{{ asset('image/galeri2.jpeg') }}" alt="Tim 5">
      <img src="{{ asset('image/galeri3.jpeg') }}" alt="Tim 6">
      <img src="{{ asset('image/galeri1.jpeg') }}" alt="Tim 7">
      <img src="{{ asset('image/galeri2.jpeg') }}" alt="Tim 8">
      <img src="{{ asset('image/galeri3.jpeg') }}" alt="Tim 9">
      <img src="{{ asset('image/galeri1.jpeg') }}" alt="Tim 10">
      <img src="{{ asset('image/galeri2.jpeg') }}" alt="Tim 11">
      <img src="{{ asset('image/galeri3.jpeg') }}" alt="Tim 12">
    </div>

    <div id="pagination" class="pagination-nav"></div>
  </section>

  @push('scripts')
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const itemsPerPage = 9;
      const gridItems = Array.from(document.querySelectorAll('#timkami-container img'));
      const totalPages = Math.ceil(gridItems.length / itemsPerPage);
      const pagination = document.getElementById("pagination");

      function showPage(page) {
        gridItems.forEach((img, index) => {
          img.style.display = (index >= (page - 1) * itemsPerPage && index < page * itemsPerPage) ? 'block' : 'none';
        });
        [...pagination.querySelectorAll('button')].forEach((btn, idx) => {
          btn.classList.toggle('active', idx + 1 === page);
        });
      }

      function createPagination() {
        for (let i = 1; i <= totalPages; i++) {
          const btn = document.createElement("button");
          btn.type = "button";
          btn.textContent = i;
          btn.addEventListener("click", () => showPage(i));
          pagination.appendChild(btn);
        }
      }

      createPagination();
      showPage(1);
    });
  </script>
  @endpush

@endsection
