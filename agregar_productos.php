<?php   
require_once 'Conexiondatabase.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo_barras = trim($_POST['codigo_barras']);
    $nombre = trim($_POST['nombre']);
    $categoria = trim($_POST['categoria']);
    $precio = str_replace(',', '.', $_POST['precio']);
    $precio = (float) $precio;
    $stock = (int) $_POST['stock'];

    try {
        $sql = "INSERT INTO pos_productos (codigo_barras, nombre, categoria, precio, stock) 
                VALUES (:codigo, :nombre, :categoria, :precio, :stock)";
                
        $rst = $conn->prepare($sql);
        
        $resultado = $rst->execute([
            ':codigo'    => $codigo_barras,
            ':nombre'    => $nombre,
            ':categoria' => $categoria,
            ':precio'    => $precio,
            ':stock'     => $stock
        ]);

        if ($resultado) {
            $mensaje = "Producto agregado correctamente.";
        }
    } catch (PDOException $e) {
        $mensaje = "Error al ejecutar la consulta: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title> 
</head>
<body>
    <h2>Formulario de Agregar Producto</h2>
    <form method="POST" action="">
        <label for="codigo_barras">Código de Barras:</label>
        <input type="text" id="codigo_barras" name="codigo_barras" required><br><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="categoria">Categoría:</label>
        <input type="text" id="categoria" name="categoria" required><br><br>

        <label for="precio">Precio:</label>
        <input type="number" step="0.01" id="precio" name="precio" required><br><br>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" value="0" required><br><br>

        <input type="submit" value="Agregar Producto">
    </form>

    <br><br>
    <a href="productos.php">Volver al Inventario</a>
</body>
</html>