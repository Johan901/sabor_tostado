<?php
// Incluye la conexión a la base de datos
include('config.php');
?>

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
<h2>Gestión de Usuarios</h2>
<!-- Enlace para agregar un nuevo usuario -->
<a href="agregar_usuario.php">
    <h2>Agregar Nuevo Usuario</h2>
</a>

<a href="historial_pedidos.php">
    <h2>Historial de pedidos</h2>
</a>

<a href="inventario.php">
    <h2>Inventario de productos</h2>
</a>

<a href="agregar_proveedores.php">
    <h2>Agregar Proveedores</h2>
</a>

<a href="proveedores.php">
    <h2>Proveedores</h2>
</a>

<!-- Lista de usuarios -->
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM clientes";
        $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['ClienteID'] . "</td>";
            echo "<td>" . $row['Nombre_cliente'] . "</td>";
            echo "<td>" . $row['Dirección'] . "</td>";
            echo "<td>" . $row['Teléfono'] . "</td>";
            echo "<td>" . $row['Email'] . "</td>";
            echo "<td>";
            echo "<a href='editar_usuario.php?ClienteID=" . $row['ClienteID'] . "'>Editar</a> | ";
            echo "<a  href='#' onclick='confirmarEliminacion(" . $row['ClienteID'] . ")'>Eliminar</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>




  <!-- Footer -->
  <footer>
        <h2 style="color: #fff;" >El arte del café</h2>
        <p>Disfruta de los mejores sabores y aromas que te ofrece Sabor Tostado.</p>
        <div class="social-icons">
            <!-- Inserta tus íconos de redes sociales aquí -->
        </div>
    </footer>

    <script>
        function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Deseas eliminar este usuario?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "eliminar_usuario.php?ClienteID=" + id;
        }
    });
}

    </script>

</body>
</html>
