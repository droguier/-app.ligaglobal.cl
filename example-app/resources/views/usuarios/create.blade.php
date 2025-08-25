<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f8fafc; }
        .container { max-width: 400px; margin: 40px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #0001; padding: 32px; }
        h1 { margin-top: 0; }
        form { display: flex; flex-direction: column; gap: 16px; }
        label { font-weight: 500; }
        input { padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 8px 16px; background: #2563eb; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        .back { display: inline-block; margin-bottom: 16px; color: #2563eb; text-decoration: none; }
        .error { color: #dc2626; font-size: 0.95em; }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('usuarios.index') }}" class="back"><i class="fa fa-arrow-left"></i> Volver</a>
        <h1>Crear Usuario</h1>
        <form method="POST" action="{{ route('usuarios.store') }}">
            @csrf
            <div>
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                @error('name')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                @error('email')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div>
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" required>
                @error('password')<div class="error">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn"><i class="fa fa-save"></i> Guardar</button>
        </form>
    </div>
</body>
</html>
