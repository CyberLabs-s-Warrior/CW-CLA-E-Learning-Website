@extends('templates.app')
@section('title', 'Daftar Kursus Detail')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:40px;height:40px;">
        <i class="fas fa-book-open"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Manajemen Kursus Detail</h1>
  </div>

  <div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.detail_courses.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
      <i class="fas fa-plus me-2"></i>Tambah Kursus
    </a>
  </div>

  @if(session('success'))
  <script>
    document.addEventListener('DOMContentLoaded', () => Swal.fire({
      icon:'success', title:'Berhasil!', text:@json(session('success')),
      timer:2500, timerProgressBar:true, showConfirmButton:false,
      background:'linear-gradient(145deg,#e6f0ff,#f8fbff)', color:'#1e3a8a', iconColor:'#0d6efd',
      customClass:{popup:'rounded-4 shadow-lg p-4', title:'fw-bold fs-4 text-primary', htmlContainer:'mt-2 fs-6'}
    }));
  </script>
  @endif

  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
      @if($courses->count())
      <div class="table-responsive">
        <table class="table table-hover align-middle text-nowrap mb-0">
          <thead class="table-light">
            <tr><th>No</th><th>Judul</th><th>Deskripsi</th><th>Modul</th><th>Media</th><th class="text-center">Aksi</th></tr>
          </thead>
          <tbody>
            @foreach($courses as $course)
            <tr>
              <td>{{ $loop->iteration + ($courses->currentPage()-1)*$courses->perPage() }}</td>
              <td class="fw-semibold">{{ \Illuminate\Support\Str::limit($course->course->name ?? '-',40) }}</td>
              <td>{!! \Illuminate\Support\Str::limit($course->description,75) !!}</td>
              <td>
                @if(!empty($course->modules))
                  <ul class="mb-0 ps-3 small">@foreach($course->modules as $module)<li>{{ $module }}</li>@endforeach</ul>
                @else <span class="text-muted small fst-italic">-</span> @endif
              </td>
              <td>
                @php 
                  $mediaList = is_array($course->media) ? $course->media : []; 
                  $first = $mediaList[0] ?? null; 
                @endphp
                @if(count($mediaList))
                <div class="d-flex align-items-center gap-1">
                  <button class="btn btn-sm btn-outline-secondary" onclick="prevMedia({{ $course->id }})">&lt;</button>
                  <div id="media-container-{{ $course->id }}" style="width:140px; height:90px;">
                    @if($first)
                      @php $ext = strtolower(pathinfo($first, PATHINFO_EXTENSION)); @endphp
                      @if(in_array($ext,['mp4','webm','ogg']))
                        <video 
                          class="rounded shadow-sm video-thumb" 
                          style="width:100%;height:100%;object-fit:cover;cursor:pointer;" 
                          data-bs-toggle="modal" 
                          data-bs-target="#videoModal" 
                          data-src="{{ asset('storage/'.$first) }}" 
                          muted
                        >
                          <source src="{{ asset('storage/'.$first) }}" type="video/{{ $ext }}">
                        </video>
                      @else
                        <img id="media-display-{{ $course->id }}" src="{{ asset('storage/'.$first) }}" class="rounded shadow-sm zoom-image" style="width:100%;height:100%;object-fit:cover;cursor:pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-src="{{ asset('storage/'.$first) }}">
                      @endif
                    @endif
                  </div>
                  <button class="btn btn-sm btn-outline-secondary" onclick="nextMedia({{ $course->id }})">&gt;</button>
                </div>
                @else <span class="text-muted small fst-italic">Tidak ada media</span> @endif
              </td>
              <td class="text-center">
                <div class="d-flex flex-wrap justify-content-center gap-2">
                  <a href="{{ route('admin.detail_courses.show',$course) }}" class="btn btn-sm btn-outline-info rounded-pill px-3 shadow-sm"><i class="fas fa-eye"></i></a>
                  <a href="{{ route('admin.detail_courses.edit',$course) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 shadow-sm"><i class="fas fa-edit"></i></a>
                  <button class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $course->id }}"><i class="fas fa-trash-alt"></i></button>

                  <div class="modal fade" id="modalHapus{{ $course->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content rounded-4 shadow">
                        <div class="modal-header border-0">
                          <h5 class="modal-title"><i class="fas fa-exclamation-triangle text-danger me-2"></i>Konfirmasi Hapus</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body"><p class="mb-0">Apakah Anda yakin ingin menghapus kursus <strong>{{ $course->course->name ?? '-' }}</strong>?</p></div>
                        <div class="modal-footer border-0">
                          <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                          <form action="{{ route('admin.detail_courses.destroy',$course) }}" method="POST" onsubmit="return showSpinner(this,{{ $course->id }})">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-pill px-3 d-flex align-items-center gap-2" id="btnDelete{{ $course->id }}">
                              <span class="spinner-border spinner-border-sm me-2 d-none" id="spinner{{ $course->id }}"></span>
                              <span>Ya, Hapus</span>
                            </button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="mt-4 px-3">{{ $courses->links('vendor.pagination.bootstrap-5') }}</div>
      @else
        <div class="alert alert-secondary d-flex align-items-center gap-2 mb-0 rounded-3">
          <i class="fas fa-info-circle"></i> <span>Belum ada data kursus detail.</span>
        </div>
      @endif
    </div>
  </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 bg-transparent">
      <div class="modal-body p-0">
        <img src="" id="modal-image" class="img-fluid rounded-3 w-100">
      </div>
      <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
  </div>
</div>

<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 bg-transparent">
      <div class="modal-body p-0">
        <video id="modal-video" class="w-100 rounded-3" controls></video>
      </div>
      <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function showSpinner(form,id){
  const btn=form.querySelector('#btnDelete'+id), spinner=form.querySelector('#spinner'+id), text=btn.querySelector('span:last-child');
  spinner.classList.remove('d-none'); text.textContent='Menghapus...'; btn.disabled=true; return true;
}

const mediaMap=@json($courses->mapWithKeys(fn($c)=>[$c->id=>$c->media??[]])), currentIndexMap={};

function showMedia(id){
  const media=mediaMap[id]; if(!media||!media.length)return;
  const idx=currentIndexMap[id]??0, file=media[idx];
  const container=document.getElementById('media-container-'+id); if(!container)return;
  const ext=file.split('.').pop().toLowerCase();
  if(['mp4','webm','ogg'].includes(ext)){
    container.innerHTML=`<video class="rounded shadow-sm video-thumb" style="width:100%;height:100%;object-fit:cover;cursor:pointer;" data-bs-toggle="modal" data-bs-target="#videoModal" data-src="{{ asset('storage') }}/`+file+`" muted><source src="{{ asset('storage') }}/`+file+`" type="video/`+ext+`"></video>`;
    initVideoModal();
  }else{
    container.innerHTML=`<img src="{{ asset('storage') }}/`+file+`" class="rounded shadow-sm zoom-image" style="width:100%;height:100%;object-fit:cover;cursor:pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-src="{{ asset('storage') }}/`+file+`">`;
    initZoomImages();
  }
}
function prevMedia(id){const media=mediaMap[id];if(!media||!media.length)return; currentIndexMap[id]=((currentIndexMap[id]??0)-1+media.length)%media.length; showMedia(id);}
function nextMedia(id){const media=mediaMap[id];if(!media||!media.length)return; currentIndexMap[id]=((currentIndexMap[id]??0)+1)%media.length; showMedia(id);}

function initZoomImages(){
  const zoomImages=document.querySelectorAll('.zoom-image');
  const modalImage=document.getElementById('modal-image');
  zoomImages.forEach(img=>{
    img.onclick=function(){
      modalImage.src=this.dataset.src;
    }
  });
}

function initVideoModal(){
  const videoModal = document.getElementById('videoModal');
  const modalVideo = document.getElementById('modal-video');
  document.querySelectorAll('.video-thumb').forEach(video => {
    video.onclick = function(){
      modalVideo.src = this.dataset.src;
      modalVideo.play();
    }
  });
  videoModal.addEventListener('hidden.bs.modal', () => {
    modalVideo.pause();
    modalVideo.src = "";
  });
}

document.addEventListener('DOMContentLoaded', ()=>{
  initZoomImages();
  initVideoModal();
});
</script>
@endpush
