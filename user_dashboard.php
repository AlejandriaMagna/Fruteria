<?php
// filepath: c:\xampp\htdocs\fruteria\user_dashboard.php

// Ruta del archivo JSON donde se almacenan las frutas
$archivoFrutas = 'frutas.json';

// Verificar si el archivo JSON existe
if (!file_exists($archivoFrutas)) {
    file_put_contents($archivoFrutas, json_encode([])); // Crear un archivo vacío solo si no existe
}

// Leer las frutas desde el archivo JSON
$frutas = json_decode(file_get_contents($archivoFrutas), true);

// Inicializar mensaje
$mensaje = "";

// Procesar el formulario después de enviarlo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $frutaSeleccionada = $_POST['fruta']; // Obtener la fruta seleccionada
    $kilos = floatval($_POST['kilos']); // Obtener los kilos ingresados

    // Validar que la fruta seleccionada exista
    if (!isset($frutas[$frutaSeleccionada])) {
        $mensaje = "<p style='color: red;'>Por favor, seleccione una fruta válida.</p>";
    } elseif ($kilos <= 0) { // Validar que los kilos sean mayores a 0
        $mensaje = "<p style='color: red;'>El número de kilos debe ser mayor que 0.</p>";
    } else {
        // Calcular el total
        $precioPorKilo = $frutas[$frutaSeleccionada];
        $total = $precioPorKilo * $kilos;
        $mensaje = "<p style='color: green;'>El total a pagar por $kilos kilo(s) de $frutaSeleccionada es: $$total.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Frutas</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <h1>Calculadora de Precios - Frutería</h1>
    <!-- Mostrar mensaje de error o resultado -->
    <?php echo $mensaje; ?>
    <form action="user_dashboard.php" method="POST">
        <label for="fruta">Seleccione una fruta:</label>
        <select name="fruta" id="fruta" required>
            <option value="">--Seleccione--</option>
            <!-- Generar las opciones dinámicamente desde el archivo JSON -->
            <?php foreach ($frutas as $nombre => $precio): ?>
                <option value="<?php echo $nombre; ?>"><?php echo ucfirst($nombre) . " ($$precio por kilo)"; ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <label for="kilos">Ingrese los kilos:</label>
        <input type="number" name="kilos" id="kilos" min="1" step="0.01" required>
        <br><br>
        <button type="submit">Calcular</button>
    </form>
</body>
</html>