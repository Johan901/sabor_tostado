<?php
include 'config.php';

// Si se envía el formulario, procesa e inserta a la base de datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_empresa = $_POST['nombre_empresa'];
    $ubicacion_direccion = $_POST['ubicacion_direccion'];
    $contacto_persona = $_POST['contacto_persona'];
    $telefono = $_POST['telefono'];
    $correo_electronico = $_POST['correo_electronico'];
    
    $query = "INSERT INTO proveedor (Nombre_empresa, Ubicacion_Direccion, Contacto_persona, Telefono, Correo_electronico) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $nombre_empresa, $ubicacion_direccion, $contacto_persona, $telefono, $correo_electronico);

    if($stmt->execute()) {
        header("Location: admin_panel.php?msg=Proveedor agregado con éxito");
    } else {
        header("Location: admin_panel.php?msg=Error al agregar el proveedor");
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Proveedores - Sabor Tostado</title>
    <link rel="stylesheet" href="css/styles_editar_user.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&display=swap">
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
    <h2>Agregar Proveedores</h2>

<form action="proveedores.php" method="post" class="user-edit-form">
    <label for="nombre_empresa">Nombre Empresa:</label>
    <input type="text" name="nombre_empresa" required>
    
    <label for="ubicacion_direccion">Ubicación Empresa:</label>
    <input type="text" name="ubicacion_direccion" required>

    <label for="contacto_persona">Persona de Contacto:</label>
    <input type="text" name="contacto_persona" required>

    <label for="telefono">Teléfono Empresa:</label>
    <input type="text" name="telefono" required>
    
    <label for="correo_electronico">Correo Electrónico Empresa:</label>
    <input type="email" name="correo_electronico" required>
    
    <input type="submit" value="Agregar">
</form>
</body>
  <!-- Footer -->
  <footer>
        <h2>El arte del café</h2>
        <p>Disfruta de los mejores sabores y aromas que te ofrece Sabor Tostado.</p>
        <div class="social-icons">
            <!-- Inserta tus íconos de redes sociales aquí -->
        </div>
    </footer>

</html>
