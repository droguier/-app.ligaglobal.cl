// Función para manejar la respuesta de Google OAuth
function handleCredentialResponse(response) {
    // Enviar el token de ID a nuestro servidor para verificar
    fetch('/src/controllers/AuthController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id_token: response.credential
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirigir según el rol del usuario
            if (data.role === 'admin') {
                window.location.href = '/admin/dashboard.html';
            } else if (data.role === 'operador') {
                window.location.href = '/operador/dashboard.html';
            } else {
                showMessage('No tiene permisos para acceder al sistema', 'error');
            }
        } else {
            showMessage(data.message || 'Error al iniciar sesión', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('Error de conexión. Por favor intente nuevamente.', 'error');
    });
}

// Mostrar mensajes al usuario
function showMessage(text, type) {
    const messageElement = document.getElementById('message');
    messageElement.textContent = text;
    messageElement.className = `message ${type}`;
    messageElement.classList.remove('hidden');
    
    // Ocultar mensaje después de 5 segundos
    setTimeout(() => {
        messageElement.classList.add('hidden');
    }, 5000);
}

// Toggle para formulario alternativo
document.getElementById('toggleForm').addEventListener('click', function(e) {
    e.preventDefault();
    const form = document.getElementById('loginForm');
    form.classList.toggle('hidden');
    
    // Cambiar texto del enlace
    if (form.classList.contains('hidden')) {
        this.textContent = '¿Prefiere iniciar sesión con correo y contraseña?';
    } else {
        this.textContent = '¿Prefiere iniciar sesión con Google?';
    }
});

// Manejo del formulario alternativo
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    // Enviar datos al servidor
    fetch('/src/controllers/AuthController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            email: email,
            password: password,
            action: 'login'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirigir según el rol del usuario
            if (data.role === 'admin') {
                window.location.href = '/admin/dashboard.html';
            } else if (data.role === 'operador') {
                window.location.href = '/operador/dashboard.html';
            } else {
                showMessage('No tiene permisos para acceder al sistema', 'error');
            }
        } else {
            showMessage(data.message || 'Credenciales inválidas', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('Error de conexión. Por favor intente nuevamente.', 'error');
    });
});