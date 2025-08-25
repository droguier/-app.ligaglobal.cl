// public/assets/js/auth.js

// Simulación de usuarios en localStorage
function initializeUsers() {
    // Verificar si ya existen usuarios en localStorage
    if (!localStorage.getItem('users')) {
        // Crear usuarios de ejemplo
        const users = [
            {
                id: 1,
                email: 'admin@example.com',
                name: 'Administrador',
                role: 'admin'
            },
            {
                id: 2,
                email: 'operador@example.com',
                name: 'Operador',
                role: 'operador'
            }
        ];
        localStorage.setItem('users', JSON.stringify(users));
    }
}

// Función para manejar la respuesta de Google OAuth
function handleCredentialResponse(response) {
    // Simular la verificación del token de Google
    // En una implementación real, aquí se haría la verificación con la API de Google
    
    // Simular datos del usuario
    const simulatedUserData = {
        email: 'usuario@example.com',
        name: 'Usuario de Ejemplo'
    };
    
    // Verificar si el usuario existe en nuestro "sistema"
    let users = JSON.parse(localStorage.getItem('users')) || [];
    let user = users.find(u => u.email === simulatedUserData.email);
    
    // Si el usuario no existe, crear uno nuevo con rol de operador por defecto
    if (!user) {
        user = {
            id: users.length + 1,
            email: simulatedUserData.email,
            name: simulatedUserData.name,
            role: 'operador' // Por defecto, los nuevos usuarios son operadores
        };
        users.push(user);
        localStorage.setItem('users', JSON.stringify(users));
    }
    
    // Iniciar sesión del usuario
    loginUser(user);
}

// Función para iniciar sesión de un usuario
function loginUser(user) {
    // Guardar información del usuario en localStorage
    localStorage.setItem('currentUser', JSON.stringify(user));
    
    // Redirigir según el rol del usuario
    if (user.role === 'admin') {
        window.location.href = 'dashboard.html';
    } else if (user.role === 'operador') {
        window.location.href = 'dashboard.html';
    } else {
        showMessage('No tiene permisos para acceder al sistema', 'error');
    }
}

// Función para verificar si el usuario está autenticado
function isAuthenticated() {
    return localStorage.getItem('currentUser') !== null;
}

// Función para obtener el usuario actual
function getCurrentUser() {
    const user = localStorage.getItem('currentUser');
    return user ? JSON.parse(user) : null;
}

// Función para cerrar sesión
function logout() {
    localStorage.removeItem('currentUser');
    window.location.href = 'index.html';
}

// Función para mostrar mensajes al usuario
function showMessage(text, type) {
    const messageElement = document.getElementById('message');
    if (messageElement) {
        messageElement.textContent = text;
        messageElement.className = `message ${type}`;
        messageElement.classList.remove('hidden');
        
        // Ocultar mensaje después de 5 segundos
        setTimeout(() => {
            messageElement.classList.add('hidden');
        }, 5000);
    }
}

// Función para verificar autenticación en la página de destino
function checkAuthAndLoadDashboard() {
    if (!isAuthenticated()) {
        window.location.href = 'index.html';
        return;
    }
    
    const user = getCurrentUser();
    if (user) {
        // Mostrar información del usuario
        const userNameElement = document.getElementById('userName');
        const userRoleElement = document.getElementById('userRole');
        const userAvatarElement = document.getElementById('userAvatar');
        
        if (userNameElement) userNameElement.textContent = user.name;
        if (userRoleElement) userRoleElement.textContent = 'Rol: ' + user.role;
        if (userAvatarElement) userAvatarElement.textContent = user.name.charAt(0).toUpperCase();
        
        // Si es administrador, mostrar la sección de administrador
        const adminSection = document.getElementById('adminSection');
        if (adminSection && user.role === 'admin') {
            adminSection.classList.add('visible');
            const welcomeMessage = document.getElementById('welcomeMessage');
            if (welcomeMessage) {
                welcomeMessage.innerHTML = 
                    'Bienvenido <strong>' + user.name + '</strong>. Como administrador, tienes acceso a funciones adicionales.';
            }
        }
    }
}

// Inicializar usuarios cuando se carga el script
initializeUsers();

// Hacer funciones disponibles globalmente
window.handleCredentialResponse = handleCredentialResponse;
window.logout = logout;
window.checkAuthAndLoadDashboard = checkAuthAndLoadDashboard;