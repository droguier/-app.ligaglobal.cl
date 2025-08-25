@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Leer QR usando khanamiryan/qrcode-detector-decoder</h2>
    <form action="{{ route('qr.khanamiryan.decode') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="image" class="form-label">Selecciona una imagen:</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
        </div>
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
