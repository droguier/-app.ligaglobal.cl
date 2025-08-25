@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Subir imagen para leer QR (Backend)</h2>
    <form action="{{ route('qr.decode') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="image" class="form-label">Selecciona una imagen:</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required onchange="previewImage(event)">
        </div>
        <div id="preview" class="mb-3"></div>
        <button type="submit" class="btn btn-primary">Subir y Leer QR</button>
        @if(session('error'))
            <div class="alert alert-danger mt-4">
                {{ session('error') }}
            </div>
        @endif
    </form>


    @if(isset($imgSrc))
        <!-- Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Imagen cargada</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body text-center">
                <img src="{{ $imgSrc }}" alt="Imagen subida" style="max-width:100%; max-height:400px;">
              </div>
            </div>
          </div>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('imageModal'));
            modal.show();
        });
        </script>
    @endif

    @if(isset($qrResult))
        <div class="mt-4">
            <h5>Resultado QR:</h5>
            <div class="alert alert-info">{{ $qrResult }}</div>
        </div>
    @endif

    @if(isset($error))
        <div class="mt-4">
            <div class="alert alert-danger">{{ $error }}</div>
        </div>
    @endif
</div>

@if(isset($consoleMessage))
<script>
    console.log(@json($consoleMessage));
</script>
@endif

@endsection

@section('scripts')
<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    preview.innerHTML = '';
    const file = event.target.files[0];
    if (file) {
        const img = document.createElement('img');
        img.style.maxWidth = '300px';
        img.style.marginTop = '10px';
        img.src = URL.createObjectURL(file);
        preview.appendChild(img);
    }
}
</script>
@endsection
