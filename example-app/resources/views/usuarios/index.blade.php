<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f8fafc; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #0001; padding: 32px; }
        h1 { margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { padding: 8px 12px; border-bottom: 1px solid #eee; }
        th { background: #f3f4f6; }
        .actions { text-align: right; }
        .btn { display: inline-block; padding: 6px 14px; background: #2563eb; color: #fff; border-radius: 4px; text-decoration: none; margin-bottom: 12px; }
        .success { color: #16a34a; margin-bottom: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Usuarios</h1>
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        <div class="actions">
            <a href="{{ route('usuarios.create') }}" class="btn"><i class="fa fa-user-plus"></i> Nuevo Usuario</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3">No hay usuarios registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
