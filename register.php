<?php
include 'config.php';

$message = ''; // Aquí guardaremos el mensaje

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_cliente = $_POST['nombre_cliente'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $password = ($_POST['password']); // Debes considerar encriptar esta contraseña

    $sql = "INSERT INTO clientes (ClienteID, Nombre_cliente, Dirección, Teléfono, Email, password) 
            VALUES (NULL, '$nombre_cliente', '$direccion', '$telefono', '$email', '$password')";

    try {
        if ($conn->query($sql) === TRUE) {
            $message = '<input type="checkbox" id="close-alert" style="display: none;">
            <div class="alert">
              ¡Te has registrado correctamente!
              <br>
              <a href="index.html" class="close-alert">Iniciar Sesión</a>
            </div>';
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062 && strpos($e->getMessage(), 'Email') !== false) {
            // Error 1062 en la columna Email es "Duplicate entry"
            $message = '<input type="checkbox" id="close-alert" style="display: none;">
            <div class="alert">
              El correo electrónico ya existe
              <br>
              <a href="index.html" class="close-alert">Cerrar</a>
            </div>';
        } else {
            $message = "Error desconocido: " . $e->getMessage();
        }
    }
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Sabor Tostado</title>
    <style>
        .alert {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 70px;
            font-size: 40px;
            background-color: #2b657c; /* Color verde */
            color: white;
            border-radius: 8px;
            z-index: 1000; /* Asegura que la alerta esté por encima de otros elementos */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .close-alert {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
            background-color: white;
            color: #2b657c;
            border: none;
            padding: 20px 40px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
            text-decoration: none; /* Esto quitará el subrayado */
}


        .close-alert:hover {
            background-color: #f5f5f5;
        }

        #close-alert:checked + .alert {
            display: none; /* Oculta la alerta cuando el checkbox está marcado */
        }
    </style>
</head>
<body>
    <div class="container2">
        <?php echo $message; ?>
    </div>
</body>
</html>

