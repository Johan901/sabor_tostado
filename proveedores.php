<?php
// Incluye la conexión a la base de datos
include('config.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Proveedores - Sabor Tostado</title>
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
<h2>Gestión de Proveedores</h2>

<!-- Lista de Proveedores -->
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre Proveedor</th>
            <th>Ubicacion Proveedor</th>
            <th>Contacto Persona</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM proveedor";
        $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['ProveedorID'] . "</td>";
            echo "<td>" . $row['Nombre_empresa'] . "</td>";
            echo "<td>" . $row['Ubicacion_Direccion'] . "</td>";
            echo "<td>" . $row['Contacto_persona'] . "</td>";
            echo "<td>" . $row['Telefono'] . "</td>";
            echo "<td>" . $row['Correo_electronico'] . "</td>";
            echo "<td>";
            echo "<a href='editar_proveedor.php?ProveedorID=" . $row['ProveedorID'] . "'>Editar</a> | ";
            echo "<a  href='#' onclick='confirmarEliminacion(" . $row['ProveedorID'] . ")'>Eliminar</a>";
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
        text: "¿Deseas eliminar este Proveedor?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "eliminar_proveedor.php?ProveedorID=" + id;
        }
    });
}

    </script>

</body>
</html>
