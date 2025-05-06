<?php
// filepath: c:\xampp\htdocs\fruteria\admin_dashboard.php

// Ruta del archivo JSON donde se almacenan las frutas
$archivoFrutas = 'frutas.json';

// Verificar si el archivo JSON existe
if (!file_exists($archivoFrutas)) {
    file_put_contents($archivoFrutas, json_encode([])); // Crear un archivo vacío solo si no existe
}

// Leer las frutas existentes
$frutas = json_decode(file_get_contents($archivoFrutas), true);

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreFruta = trim($_POST['nombre_fruta']);
    $precioFruta = floatval($_POST['precio_fruta']);

    if (!empty($nombreFruta) && $precioFruta > 0) {
        $frutas[$nombreFruta] = $precioFruta;
        file_put_contents($archivoFrutas, json_encode($frutas)); // Guardar en JSON
        echo "<p style='color: green;'>Fruta agregada: $nombreFruta ($$precioFruta por kilo).</p>";
    } else {
        echo "<p style='color: red;'>Por favor, ingrese datos válidos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    <link rel="stylesheet" href="assets/styles.css"> <>
</head>
<body>
    <!-- Contenido de la página -->
</body>
</html>