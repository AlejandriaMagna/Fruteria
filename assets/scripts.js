// Escuchar el evento de envío del formulario
document.getElementById('rolForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar que el formulario se envíe automáticamente

    // Obtener el valor seleccionado del radio button
    const tipoUsuario = document.querySelector('input[name="tipo_usuario"]:checked').value;

    // Redirigir según el rol seleccionado
    if (tipoUsuario === 'usuario') {
        window.location.href = 'user_login.php'; // Redirigir al login de usuario
    } else if (tipoUsuario === 'admin') {
        window.location.href = 'admin_login.php'; // Redirigir al login de administrador
    }
});