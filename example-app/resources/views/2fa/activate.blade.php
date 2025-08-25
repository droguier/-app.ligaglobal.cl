@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Activar Autenticación en Dos Pasos (2FA)</h2>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <p>Escanea el siguiente código QR con Google Authenticator o una app compatible:</p>
    <div>{!! $QR_Image !!}</div>
    <p>O usa esta clave manual: <strong>{{ $secret }}</strong></p>
    <form method="POST" action="{{ route('2fa.validate') }}">
        @csrf
        <div class="form-group">
            <label for="one_time_password">Código de 6 dígitos</label>
            <input type="text" name="one_time_password" id="one_time_password" class="form-control" required maxlength="6">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Validar</button>
    </form>
</div>
@endsection
