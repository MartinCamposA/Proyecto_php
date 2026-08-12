<?php

require_once 'Conexiondatabase.php';

if (!isset($_GET['id'])) {
    die("ID de producto no encontrada. <a href='productos.php'>Volver al inventario</a>");
}

$id_producto = intval($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $codigo_barras = $_POST['codigo_barras'];
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $queryUpdate = "UPDATE pos_productos SET
        codigo_barras = :codigo_barras,
        nombre = :nombre,
        categoria = :categoria,
        precio = :precio,
        stock = :stock
        WHERE id_producto = :id_producto";

    try {
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->execute([
            ':codigo_barras' => $codigo_barras,
            ':nombre' => $nombre,
            ':categoria' => $categoria,
            ':precio' => $precio,
            ':stock' => $stock,
            ':id_producto' => $id_producto
        ]);

        $mensaje= "Producto actualizado correctamente.";
    } catch (PDOException $e) {
        $mensaje= "Error al actualizar el producto: " . $e->getMessage();
    }
}

$querySelect = "SELECT * FROM pos_productos WHERE id_producto = :id_producto";
$rst = $conn->prepare($querySelect);
$rst->execute([':id_producto' => $id_producto]);
$producto = $rst->fetch(PDO::FETCH_ASSOC);
if (!$producto) {
    die("Producto no encontrado. <a href='productos.php'>Volver al inventario</a>");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Editar Bebestibles</title>
</head>

<body>
    <h2>Editar Producto: <?php echo $producto['nombre']; ?></h2>
    <form method="POST" action="">
        <label for="codigo_barras">Código de Barras:</label>
        <input type="text" id="codigo_barras" name="codigo_barras" value="<?php echo $producto['codigo_barras']; ?>" required><br><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $producto['nombre']; ?>" required><br><br>

        <label for="categoria">Categoría:</label>
        <input type="text" id="categoria" name="categoria" value="<?php echo $producto['categoria']; ?>" required><br><br>

        <label for="precio">Precio:</label>
        <input type="number" step="0.01" id="precio" name="precio" value="<?php echo $producto['precio']; ?>" required><br><br>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" value="<?php echo $producto['stock']; ?>" required><br><br>

        <input type="submit" value="Actualizar Producto">
        
    </form>
    <?php
    if ($mensaje !="") {
        echo "<p>$mensaje</p>";
    }
    ?>
    <br>
    <a href="productos.php">Volver al inventario</a>
</body>

</html>