<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administracion - Sabor Tostado</title>
    <link rel="stylesheet" href="css/styles_admin.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
    <!-- Header -->
    <header>
        <a href="admin_panel.php" class="logo">Sabor Tostado</a>
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
<h2>Gestión de Inventario</h2>

<form action="inventario.php" method="GET" class="search-form">
<h2><label for="nombre_producto">Buscar producto por nombre:</label></h2>
    <input type="text" name="nombre_producto" required>
    <input type="submit" value="Buscar">
</form>


<?php
include('config.php');

if (isset($_GET['nombre_producto']) && !empty($_GET['nombre_producto'])) {
    $nombre_producto = $_GET['nombre_producto'];
    
    // Query para buscar el producto por nombre
    $query = "SELECT * FROM producto WHERE Nombre LIKE '%$nombre_producto%'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Resultados de la búsqueda</h2>";
    } else {
        echo "No se encontraron productos con el nombre: $nombre_producto";
    }
} else {
    $query = "SELECT * FROM producto";
    $result = mysqli_query($conn, $query);
    echo "<h2>Stock de Productos</h2>";
}

echo "<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>ID Proveedor</th>
        <th>Stock</th>
    </tr>";

while ($producto = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$producto['ProductoID']}</td>
        <td>{$producto['Nombre']}</td>
        <td>{$producto['Descripción']}</td>
        <td>{$producto['ProveedorID']}</td>
        <td>{$producto['Stock']}</td>
    </tr>";
}
echo "</table>";
?>
