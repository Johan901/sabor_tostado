<?php
include 'config.php';

// Verifica si se ha pasado un ClienteID en la URL
if(isset($_GET['ClienteID'])) {
    $id = $_GET['ClienteID'];
} else {
    header("Location: admin_panel.php?msg=ID de cliente no proporcionado");
    exit;
}

// Si se envía el formulario, procesa y actualiza la base de datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['Nombre_cliente'];
    $direccion = $_POST['Dirección'];
    $telefono = $_POST['Teléfono'];
    $email = $_POST['Email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashea la contraseña
    
    $query = "UPDATE clientes SET Nombre_cliente=?, Dirección=?, Teléfono=?, Email=?, password=? WHERE ClienteID=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $nombre, $direccion, $telefono, $email, $password, $id);

    if($stmt->execute()) {
        header("Location: admin_panel.php?msg=Cliente actualizado con éxito");
    } else {
        header("Location: admin_panel.php?msg=Error al actualizar el cliente");
    }

    $stmt->close();
}

// Obtener los datos del cliente para rellenar el formulario
$query = "SELECT * FROM clientes WHERE ClienteID=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();
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

<form action="editar_usuario.php?ClienteID=<?php echo $id; ?>" method="post" class="user-edit-form">
    <label for="Nombre_cliente" class="form-label">Nombre:</label>
    <input type="text" name="Nombre_cliente" value="<?php echo $cliente['Nombre_cliente']; ?>" required class="form-input">

    <label for="Dirección" class="form-label">Dirección:</label>
    <input type="text" name="Dirección" value="<?php echo $cliente['Dirección']; ?>" required class="form-input">

    <label for="Teléfono" class="form-label">Teléfono:</label>
    <input type="text" name="Teléfono" value="<?php echo $cliente['Teléfono']; ?>" required class="form-input">

    <label for="Email" class="form-label">Correo Electrónico:</label>
    <input type="email" name="Email" value="<?php echo $cliente['Email']; ?>" required class="form-input">

    <label for="password" class="form-label">Contraseña:</label>
    <input type="password" name="password" value="" placeholder="Dejar vacío para no cambiar" class="form-input">

    <input type="submit" value="Actualizar" class="button">
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
