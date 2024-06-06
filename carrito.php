<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Usuario - Sabor Tostado</title>
    <link rel="stylesheet" href="css/styles_carrito.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&display=swap">
</head>

<body>

    <!-- Header -->
    <header>
        <a href="user_panel.php" class="logo">Sabor Tostado</a>
        <div class="header-right">
            <form action="resultados.php" method="get" class="search-form">
                <input type="text" name="query" placeholder="Buscar producto..." required>
                <input type="submit" value="Buscar">
            </form>
            <div class="cart-icon">
                <i class="fas fa-shopping-cart fa-lg"></i>
            </div>
        </div>
        <a href="logout.php" class="logout-button">Cerrar Sesión</a>
    </header>

    <div class="order-checkout-container">
        <!-- Sección de Resumen del Pedido (Carrito) -->
        <div class="order-section">
            <h2 style="padding-left: 20px";>Resumen de tu pedido</h2>
            <hr class="decorative-line">
            <?php
session_start();

$server = "localhost";
$username = "root";
$password = "";
$database = "sabor_tostado";

$conexion = mysqli_connect($server, $username, $password, $database);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $producto_id = $_POST['producto_id'];
    $presentacion = $_POST['presentacion'];
    $molido = $_POST['molido'];

    // Puedes guardar esta información en una sesión o en una base de datos.
    $_SESSION['carrito'] = [
        'producto_id' => $producto_id,
        'presentacion' => $presentacion,
        'molido' => $molido
    ];
}

if (isset($_SESSION['carrito'])) {
    $producto_id = $_SESSION['carrito']['producto_id'];
    $query = "SELECT * FROM producto WHERE ProductoID = $producto_id";
    $result = mysqli_query($conexion, $query);

    if (!$result) {
        die("Error al consultar el producto: " . mysqli_error($conexion));
    }

    $producto = mysqli_fetch_assoc($result);
    // Aquí muestras la información del producto...
}



// Mostrar información del producto...
echo "<h2 style='padding-left: 20px;'>" . $producto['Nombre'] . "</h2>";


echo "<img src='assets/images/producto.jpeg' alt='" . $producto['Nombre'] . "' style='width:100%; max-width:300px; padding-left: 20px;'>";


// Suponiendo que $producto['precio1'], $producto['precio2'] y $producto['precio3'] sean los precios para las presentaciones pequeño, mediano y grande, respectivamente.
$precio = 0;
switch ($_SESSION['carrito']['presentacion']) {
    case "Pequeño":
        $precio = $producto['Precio_1'];
        break;
    case "Mediano":
        $precio = $producto['Precio_2'];
        break;
    case "Grande":
        $precio = $producto['Precio_3'];
        break;
}

echo "<p class='order-detail'>Presentación: " . $_SESSION['carrito']['presentacion'] . "</p>";
echo "<p class='order-detail'>Tipo de molido: " . $_SESSION['carrito']['molido'] . "</p>";
echo "<p class='order-detail'>Precio: $" . number_format($precio, 0, ',', '.') . "</p>";


// pruyeba
$presentacion = $_POST['presentacion'];


// obetenemos el precio y nombre seleccionado
switch ($presentacion) {
    case 'Pequeño':
        $columna_precio = "Precio_1";
        break;
    case 'Mediano':
        $columna_precio = "Precio_2";
        break;
    case 'Grande':
        $columna_precio = "Precio_3";
        break;
    default:
        die("Presentación no válida.");
}

// Suponiendo que tienes una conexión $conexion a la base de datos
$query = "SELECT Nombre, $columna_precio as precio_seleccionado FROM producto WHERE ProductoID = $producto_id";
$result = mysqli_query($conexion, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $nombre_producto = $row['Nombre'];
    $precio_producto = $row['precio_seleccionado'];
} else {
    die("Error: No se encontró el producto con ID: $producto_id.");
}





mysqli_close($conexion);

?>
        </div>

        <!-- Sección de Checkout -->
        <div class="checkout-section">
            <h2>Checkout</h2>
            <hr class="decorative-line">

            <div class="checkout-message">
                Nuestros despachos se realizan desde el origen. El corazón de Colombia, por esto los tiempos de entrega son de 3-6 días hábiles.
                <br>
                ¡Gracias por tu compra!
            </div>

            <!-- Aquí el formulario de checkout -->
        <form class="checkout-form" action="procesar_compra.php" method="post">
        <h2>Detalles de facturación</h2>

        <label for="nombre">Nombre *</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="apellidos">Apellidos *</label>
        <input type="text" id="apellidos" name="apellidos" required>

        <label for="empresa">Nombre de la empresa (opcional)</label>
        <input type="text" id="empresa" name="empresa">

        <label for="cedula">Cédula/NIT *</label>
        <input type="text" id="cedula" name="cedula" required>

        <label for="pais">País / Región *</label>
        <select id="pais" name="pais" required>
            <option value="Colombia">Colombia</option>
            <!-- Puedes agregar más opciones si es necesario -->
        </select>

        <label for="direccion">Dirección de la calle *</label>
        <input type="text" id="direccion" name="direccion" placeholder="Número de la casa y nombre de la calle" required>

        <label for="apartamento">Apartamento, habitación, etc. (opcional)</label>
        <input type="text" id="apartamento" name="apartamento">

        <label for="ciudad">Ciudad *</label>
        <input type="text" id="ciudad" name="ciudad" required>

        <label for="region">Región / Provincia *</label>
        <input type="text" id="region" name="region" required>

        <label for="codigo_postal">Código postal (opcional)</label>
        <input type="text" id="codigo_postal" name="codigo_postal">

        <label for="telefono">Teléfono *</label>
        <input type="text" id="telefono" name="telefono" required>

        <label for="email">Dirección de correo electrónico *</label>
        <input type="email" id="email" name="email" required>
        <input type="hidden" name="producto_id" value="<?php echo $producto_id; ?>">
        <input type="hidden" name="producto_id" value="<?php echo $producto_id; ?>">
<input type="hidden" name="nombre_producto" value="<?php echo $nombre_producto; ?>">
<input type="hidden" name="precio_producto" value="<?php echo $precio_producto; ?>">
<input type="hidden" name="cliente_id" value="<?php echo $cliente_id; ?>"> <!-- Asumiendo que el ID del cliente está almacenado en una variable de sesión -->


        <button class="button large-btn">Pagar</button>
    </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <h2>El arte del café</h2>
        <p>Disfruta de los mejores sabores y aromas que te ofrece Sabor Tostado.</p>
        <div class="social-icons">
            <!-- Inserta tus íconos de redes sociales aquí -->
        </div>
    </footer>

    <script src="js/main_user.js"></script>
</body>

</html>
