<?php
// filepath: c:\xampp\htdocs\fruteria\admin_dashboard.php

// Aquí defino la ruta del archivo JSON donde voy a guardar las frutas y sus precios
$archivoFrutas = 'frutas.json';

// Verifico si el archivo JSON existe. Si no existe, lo creo vacío
if (!file_exists($archivoFrutas)) {
    file_put_contents($archivoFrutas, json_encode([])); // Creo un archivo JSON vacío
}

// Leo las frutas existentes desde el archivo JSON y las convierto en un arreglo PHP
$frutas = json_decode(file_get_contents($archivoFrutas), true);

// Inicializo una variable para mostrar mensajes al usuario (por ejemplo, errores o confirmaciones)
$mensaje = "";

// Verifico si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtengo la acción que el usuario quiere realizar (agregar, modificar o eliminar)
    $accion = $_POST['accion'];

    // Si la acción es "agregar", intento agregar una nueva fruta
    if ($accion === 'agregar') {
        $nombreFruta = trim($_POST['nombre_fruta']); // Obtengo el nombre de la fruta
        $precioFruta = floatval($_POST['precio_fruta']); // Obtengo el precio de la fruta

        // Valido que el nombre de la fruta no esté vacío
        if (empty($nombreFruta)) {
            $mensaje = "<p style='color: red;'>El nombre de la fruta no puede estar vacío.</p>";
        } elseif ($precioFruta <= 0) { // Valido que el precio sea mayor que 0
            $mensaje = "<p style='color: red;'>El precio debe ser mayor que 0.</p>";
        } else {
            // Si todo está bien, agrego la fruta al arreglo
            $frutas[$nombreFruta] = $precioFruta;

            // Guardo el arreglo actualizado en el archivo JSON
            file_put_contents($archivoFrutas, json_encode($frutas));

            // Muestro un mensaje de éxito
            $mensaje = "<p style='color: green;'>Fruta agregada: $nombreFruta ($$precioFruta por kilo).</p>";
        }
    }

    // Si la acción es "modificar", intento actualizar el precio de una fruta existente
    elseif ($accion === 'modificar') {
        $nombreFruta = trim($_POST['nombre_fruta']); // Obtengo el nombre de la fruta
        $precioFruta = floatval($_POST['precio_fruta']); // Obtengo el nuevo precio

        // Verifico si la fruta existe en el arreglo
        if (isset($frutas[$nombreFruta])) {
            // Actualizo el precio de la fruta
            $frutas[$nombreFruta] = $precioFruta;

            // Guardo el arreglo actualizado en el archivo JSON
            file_put_contents($archivoFrutas, json_encode($frutas));

            // Muestro un mensaje de éxito
            $mensaje = "<p style='color: green;'>Fruta modificada: $nombreFruta ($$precioFruta por kilo).</p>";
        } else {
            // Si la fruta no existe, muestro un mensaje de error
            $mensaje = "<p style='color: red;'>La fruta no existe.</p>";
        }
    }

    // Si la acción es "eliminar", intento borrar una fruta
    elseif ($accion === 'eliminar') {
        $nombreFruta = trim($_POST['nombre_fruta']); // Obtengo el nombre de la fruta

        // Verifico si la fruta existe en el arreglo
        if (isset($frutas[$nombreFruta])) {
            // Elimino la fruta del arreglo
            unset($frutas[$nombreFruta]);

            // Guardo el arreglo actualizado en el archivo JSON
            file_put_contents($archivoFrutas, json_encode($frutas));

            // Muestro un mensaje de éxito
            $mensaje = "<p style='color: green;'>Fruta eliminada: $nombreFruta.</p>";
        } else {
            // Si la fruta no existe, muestro un mensaje de error
            $mensaje = "<p style='color: red;'>La fruta no existe.</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Administrador</title>
</head>
<body>
    <h1>Panel de Control - Administrador</h1>
    <!-- Aquí muestro el mensaje de éxito o error -->
    <?php echo $mensaje; ?>

    <h2>Agregar Fruta</h2>
    <form action="admin_dashboard.php" method="POST">
        <input type="hidden" name="accion" value="agregar">
        <label for="nombre_fruta">Nombre de la fruta:</label>
        <input type="text" name="nombre_fruta" id="nombre_fruta" required>
        <br><br>
        <label for="precio_fruta">Precio por kilo:</label>
        <input type="number" name="precio_fruta" id="precio_fruta" step="0.01" required>
        <br><br>
        <button type="submit">Agregar Fruta</button>
    </form>

    <h2>Modificar Fruta</h2>
    <form action="admin_dashboard.php" method="POST">
        <input type="hidden" name="accion" value="modificar">
        <label for="nombre_fruta">Nombre de la fruta:</label>
        <input type="text" name="nombre_fruta" id="nombre_fruta" required>
        <br><br>
        <label for="precio_fruta">Nuevo precio por kilo:</label>
        <input type="number" name="precio_fruta" id="precio_fruta" step="0.01" required>
        <br><br>
        <button type="submit">Modificar Fruta</button>
    </form>

    <h2>Eliminar Fruta</h2>
    <form action="admin_dashboard.php" method="POST">
        <input type="hidden" name="accion" value="eliminar">
        <label for="nombre_fruta">Nombre de la fruta:</label>
        <input type="text" name="nombre_fruta" id="nombre_fruta" required>
        <br><br>
        <button type="submit">Eliminar Fruta</button>
    </form>

    <h2>Frutas Disponibles</h2>
    <ul>
        <!-- Aquí muestro todas las frutas disponibles -->
        <?php foreach ($frutas as $nombre => $precio): ?>
            <li><?php echo ucfirst($nombre) . ": $$precio por kilo"; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>