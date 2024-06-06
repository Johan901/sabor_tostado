<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Usuario - Sabor Tostado</title>
    <link rel="stylesheet" href="css/styles_compras.css">
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
            <h2 style="padding-left: 20px";></h2>
            <hr class="decorative-line">
            <?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'sabor_tostado';

// Establecer conexión con la base de datos
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}




// Capturar los datos del formulario
$nombre_cliente = $_POST['nombre'] . " " . $_POST['apellidos'];
$correo_electronico = $_POST['email'];
$telefono = $_POST['telefono'];
$calle = $_POST['direccion'];
$ciudad = $_POST['ciudad'];
$region = $_POST['region'];
$codigo_postal = $_POST['codigo_postal'];
$pais = $_POST['pais'];

$producto_id = $_POST['producto_id'];
$nombre_producto = $_POST['nombre_producto']; // Capturamos desde el formulario
$precio_producto = $_POST['precio_producto']; // Capturamos desde el formulario

// Obtener el ClienteID usando el correo electrónico
$query_cliente_id = "SELECT ClienteID FROM clientes WHERE Email = '{$correo_electronico}'";
$resultado = $conn->query($query_cliente_id);

if ($resultado->num_rows > 0) {
    $cliente = $resultado->fetch_assoc();
    $cliente_id = $cliente['ClienteID'];
} else {
    die("El correo electrónico ingresado no corresponde a un cliente registrado.");
}


// FACTURA

// Genera un número aleatorio para la factura
$numero_random = mt_rand(100000, 999999);  // Genera un número entre 100000 y 999999
$numero_factura = "ST-" . $numero_random;  // Concatena el prefijo "ST"

do {
    $numero_random = mt_rand(100000, 999999);
    $numero_factura = "ST-" . $numero_random;
       
    $query_check = "SELECT numero_factura FROM pedidos WHERE numero_factura = '{$numero_factura}'";
    $result = $conn->query($query_check);
       
} while ($result->num_rows > 0);



// Consulta para insertar los datos en la tabla 'Pedidos'
$query_insert = "INSERT INTO pedidos (Nombre_cliente, Correo_electronico, Telefono, Calle, Ciudad, Region, Codigo_postal, Pais, ProductoID, Nombre_producto, Precio_producto, ClienteID, numero_factura) 
                 VALUES ('{$nombre_cliente}', '{$correo_electronico}', '{$telefono}', '{$calle}', '{$ciudad}', '{$region}', '{$codigo_postal}', '{$pais}', '{$producto_id}', '{$nombre_producto}', '{$precio_producto}', '{$cliente_id}', '{$numero_factura}')";


if ($conn->query($query_insert) === TRUE) {
    echo '
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                height: 100vh;
                margin: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #f5f5f5;
            }
            .center {
                text-align: center;
            }
            .btn {
                display: inline-block;
                padding: 20px 40px;
                margin: 20px 0;
                font-size: 24px;
                border: none;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            .btn-primary {
                background-color: #007bff;
                color: white;
            }
            .btn-primary:hover {
                background-color: #0056b3;
            }
            .btn-secondary {
                background-color: #6c757d;
                color: white;
            }
            .btn-secondary:hover {
                background-color: #545b62;
            }
        </style>
    </head>
    <body>
    <div class="center">
        <button class="btn btn-primary">¡Pedido añadido con éxito! Número de factura: ' . $numero_factura . '</button>
        <br>
        <a href="user_panel.php" class="btn btn-secondary">Volver a la página principal</a>
    </div>
</body>

    </html>
    ';
} else {
    echo "Error: " . $query_insert . "<br>" . $conn->error;
}


?>



