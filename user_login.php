<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Usuario</title>
</head>
<body>
    <h1>Iniciar Sesión - Usuario</h1>
    <form action="user_login.php" method="POST">
        <!-- Campo para el usuario -->
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" required>
        <br><br>
        <!-- Campo para la contraseña -->
        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" id="contraseña" required>
        <br><br>
        <!-- Botón para enviar el formulario -->
        <button type="submit">Iniciar Sesión</button>
    </form>

    <?php
    // Validar credenciales después de enviar el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];

        // Validar usuario y contraseña
        if ($usuario === 'user' && $contraseña === '5678') {
            echo "<p>Inicio de sesión exitoso. Bienvenido, Usuario.</p>";
            header("Location: user_dashboard.php"); // Redirigir a la página de usuario
            exit; // Detener la ejecución del script después de redirigir
        } else {
            echo "<p style='color: red;'>Credenciales incorrectas. Por favor, intente de nuevo.</p>";
        }
    }
    ?>
</body>
</html>