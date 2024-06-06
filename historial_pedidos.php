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
<h2>Historial de Pedidos</h2>

<?php
include('config.php');
$result = mysqli_query($conn, "SELECT * FROM pedidos");

echo "<table>
    <tr>
        <th>ID</th>
        <th>ID Cliente</th>
        <th>Numero Factura</th>
        <th>Nombre Cliente</th>
        <th>Correo Electrónico</th>
        <th>Teléfono</th>
        <th>Calle</th>
        <th>Ciudad</th>
        <th>Región</th>
        <th>País</th>
        <th>Fecha Pedido</th>
        <th>Producto ID</th>
        <th>Nombre Producto</th>
        <th>Precio Producto</th>
    </tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$row['PedidoID']}</td>
        <td>{$row['ClienteID']}</td>
        <td>{$row['numero_factura']}</td>
        <td>{$row['Nombre_cliente']}</td>
        <td>{$row['Correo_electronico']}</td>
        <td>{$row['Telefono']}</td>
        <td>{$row['Calle']}</td>
        <td>{$row['Ciudad']}</td>
        <td>{$row['Region']}</td>
        <td>{$row['Pais']}</td>
        <td>{$row['Fecha_pedido']}</td>
        <td>{$row['ProductoID']}</td>
        <td>{$row['Nombre_producto']}</td>
        <td>{$row['Precio_producto']}</td>
    </tr>";
}
echo "</table>";

?>


