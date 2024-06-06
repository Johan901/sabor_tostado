<?php
$host = 'localhost';
$db   = 'sabor_tostado';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$query = $_GET['query'];

$stmt = $pdo->prepare("SELECT * FROM producto WHERE Nombre LIKE ?");
$stmt->execute(["%$query%"]);

$results = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados para "<?= htmlspecialchars($query) ?>" - Sabor Tostado</title>
    <link rel="stylesheet" href="css/styles_resultados.css">
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

   <!-- Carrito -->
   <aside class="cart">
    <h2>Tu carrito</h2>

    <?php 
    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])): 
        $total = 0;
        $items = 0;
    ?>
    
    <div class="cart-products">
        <?php foreach ($_SESSION['carrito'] as $producto): 
            $total += $producto['precio'] * $producto['cantidad'];
            $items += $producto['cantidad'];
        ?>

        <div class="cart-product">
            <img src="ruta_imagen_producto" alt="<?= $producto['nombre'] ?>" width="100" height="100">
            <div class="product-info">
                <h3><?= $producto['nombre'] ?></h3>
                <p>Presentación: <?= $producto['presentacion'] ?></p>
                <p>Tipo de Molido: <?= $producto['tipo_molido'] ?></p>
                <p>Cantidad: <?= $producto['cantidad'] ?></p>
                <p>Precio: $<?= number_format($producto['precio'] * $producto['cantidad'], 2) ?></p>
            </div>
        </div>

        <?php endforeach; ?>
    </div>

    <div class="cart-summary">
        <p>Total estimado - <?= $items ?> artículo(s)</p>
        <p>Impuestos y envío calculados al finalizar la compra.</p>
        <h3>Total: $<?= number_format($total, 2) ?></h3>
    </div>

    <button class="large-btn" onclick="window.location.href='página_pago.php'">Ordenar Ahora</button>

    <?php 
    else: 
    ?>
        <img src="assets/images/cart_empty_icon.png" alt="Carrito vacío">
        <h3>¡Tu carrito está vacío!</h3>
        <p>Parece que todavía no has agregado ningún artículo a tu carrito.</p>
        <button class="large-btn" onclick="window.location.href='user_panel.php'">Buscar productos</button>
    <?php 
    endif; 
    ?>

</aside>



    <!-- Resultados de Búsqueda -->
    <main>
        <h2>Resultados para "<?= htmlspecialchars($query) ?>"</h2>
        <hr class="decorative-line">
        <?php
        if (count($results) > 0) {
            echo '<div class="products">';
            foreach ($results as $row) {
                echo '<div class="product">';
                // Aquí puedes poner la imagen del producto si la tienes en la base de datos
                echo '<img src="assets/images/producto.jpeg" alt="' . htmlspecialchars($row['Nombre']) . '" width="300" height="300">';
                echo '<h3>' . htmlspecialchars($row['Nombre']) . '</h3>';
                echo '<span style="display: block; font-size: 24px; color: black; text-shadow: 1px 1px 2px rgba(0,0,0,0.1); margin: 10px 0; font-weight: bold;">$' . number_format($row['Precio_1'], 0, ',', '.') . '</span>';
                echo '<a href="opciones_producto.php?ProductoID=' . $row["ProductoID"] . '" class="button">SELECCIONAR OPCIONES</a>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '  <div class="no-results">
                        <p>No se encontraron resultados.<br>La página solicitada no pudo encontrarse. Trate de perfeccionar su búsqueda o utilice la navegación para localizar la entrada.</p>
                    </div>';
        }
        ?>
    </main>

    <!-- Footer -->
    <footer>
        <h2>El arte del café</h2>
        <p>Disfruta de los mejores sabores y aromas que te ofrece Sabor Tostado.</p>
        <div class="social-icons">
            <!-- Inserta tus íconos de redes sociales aquí -->
        </div>
    </footer>

    <script src="js/main_resultados.js"></script>
</body>
</html>
