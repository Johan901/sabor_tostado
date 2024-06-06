<?php
include 'config.php';

// Verifica si se ha pasado un ClienteID en la URL
if(isset($_GET['ProveedorID'])) {
    $id = $_GET['ProveedorID'];
} else {
    header("Location: admin_panel.php?msg=ID de proveedor no proporcionado");
    exit;
}

// Si se envía el formulario, procesa y actualiza la base de datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_empresa = $_POST['Nombre_empresa'];
    $ubicacion_direccion = $_POST['Ubicacion_Direccion'];
    $contacto_persona = $_POST['Contacto_persona'];
    $telefono = $_POST['Telefono'];
    $correo_electronico = $_POST['Correo_electronico'];

    $query = "UPDATE proveedor SET Nombre_empresa=?, Ubicacion_Direccion=?, Contacto_persona=?, Telefono=?, Correo_electronico=? WHERE ProveedorID=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $nombre_empresa, $ubicacion_direccion, $contacto_persona, $telefono, $correo_electronico, $id);

    if ($stmt->execute()) {
        header("Location: admin_panel.php?msg=Proveedor actualizado con éxito");
    } else {
        header("Location: admin_panel.php?msg=Error al actualizar el proveedor");
    }

    $stmt->close();
}

// Obtener los datos del proveedor para rellenar el formulario
$query = "SELECT * FROM proveedor WHERE ProveedorID=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$proveedor = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administracion - Sabor Tostado</title>
    <link rel="stylesheet" href="css/styles_editar_user.css">
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
<h2>Editar Usuarios</h2>

<!-- El resto del código HTML permanece igual -->

<form action="editar_proveedor.php?ProveedorID=<?php echo $id; ?>" method="post" class="user-edit-form">
    <label for="Nombre_empresa">Nombre Empresa:</label>
    <input type="text" name="Nombre_empresa" value="<?php echo $proveedor['Nombre_empresa']; ?>" required>

    <label for="Ubicacion_Direccion">Ubicación Empresa:</label>
    <input type="text" name="Ubicacion_Direccion" value="<?php echo $proveedor['Ubicacion_Direccion']; ?>" required>

    <label for="Contacto_persona">Persona de Contacto:</label>
    <input type="text" name="Contacto_persona" value="<?php echo $proveedor['Contacto_persona']; ?>" required>

    <label for="Telefono">Teléfono Empresa:</label>
    <input type="text" name="Telefono" value="<?php echo $proveedor['Telefono']; ?>" required>

    <label for="Correo_electronico">Correo Electrónico Empresa:</label>
    <input type="email" name="Correo_electronico" value="<?php echo $proveedor['Correo_electronico']; ?>" required>

    <input type="submit" value="Actualizar">
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
