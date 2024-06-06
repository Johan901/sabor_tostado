<?php
include 'config.php';

session_start();

$message = ''; // Para guardar mensajes de error

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password']; // En el futuro, considera utilizar password_hash() y password_verify() para una mayor seguridad

        // Primero, verifica si el correo y la contraseña coinciden con algún administrador
        $stmt = $conn->prepare("SELECT * FROM administrador WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $_SESSION['admin_id'] = $result->fetch_assoc()['adminID'];
            header('Location: admin_panel.php');
        } else {
            // Si no es un administrador, verifica si es un cliente
            $stmt = $conn->prepare("SELECT * FROM clientes WHERE Email = ? AND password = ?");
            $stmt->bind_param("ss", $email, $password);

            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $_SESSION['user_id'] = $result->fetch_assoc()['ClienteID'];
                header('Location: user_panel.php');
            } else {
                $message = '<input type="checkbox" id="close-alert" style="display: none;">
                            <div class="alert">
                              Credenciales incorrectas.
                              <br>
                              <a href="index.html" class="close-alert">Cerrar</a>
                            </div>';
                echo $message;
            }
        }
        $stmt->close();
    } else {
        echo 'Por favor, complete todos los campos.';
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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