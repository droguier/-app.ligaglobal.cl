@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Leer QR usando ZBar (demo)</h2>
    <form action="{{ route('zbar.decode') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="image" class="form-label">Selecciona una imagen:</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required onchange="previewImage(event)">
        </div>
        <div id="preview" class="mb-3"></div>
        <button type="submit" class="btn btn-primary">Subir y Leer QR</button>
    </form>

    @if(session('error'))
        <div class="alert alert-danger mt-4">{{ session('error') }}</div>
    @endif

    @if(isset($qrResult))
        <div class="alert alert-info mt-4">
            <strong>Resultado QR:</strong> {{ $qrResult }}
        </div>
    @endif
</div>
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
