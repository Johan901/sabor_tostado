<?php
include 'config.php';  // Incluir la conexión

// Verificar si la ID está establecida en la URL
if(isset($_GET['ProveedorID'])) {
    $id = $_GET['ProveedorID'];

    // Consulta para eliminar el proveedor basado en el ProveedorID
    $query = "DELETE FROM proveedor WHERE ProveedorID = ?";
    
    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id); // "i" indica que estamos pasando un integer

    if($stmt->execute()) {
        // Redirigir al panel de administración con un mensaje de éxito
        header("Location: admin_panel.php?msg=Proveedor eliminado con éxito");
    } else {
        // Redirigir al panel de administración con un mensaje de error
        header("Location: admin_panel.php?msg=Error al eliminar el Proveedor");
    }

    $stmt->close();
} else {
    // Si no se proporciona un ClienteID, redirigir al panel de administración
    header("Location: admin_panel.php?msg=ID de proveedor no proporcionado");
}

$conn->close();
?>
