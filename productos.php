<?php 
    require_once 'Conexiondatabase.php';

    $query = "SELECT * FROM pos_productos";
    $rst = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventario de bebestibles</title>
    <link rel="stylesheet" href="static/productos.css">
</head>
<body>
    <div class="navbar">
        <h3 style="color: white; margin-right: 20px;">MiBotillería POS</h3>
        <a href="index.php"> Caja </a>
        <a href="productos.php" class="activo">Inventario</a>
        <a href="ventas.php">Ventas</a>
    </div>

    <h1>Inventario de Bebestibles</h1>
    <a href="agregar_productos.php">Agregar Producto</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Codigo de Barras</th>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $rst->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo $fila['id'] ?? ''; ?></td>
                <td><?php echo $fila['codigo_barras'] ?? $fila['codigo'] ?? ''; ?></td>
                <td><?php echo $fila['nombre'] ?? ''; ?></td>
                <td><?php echo $fila['categoria'] ?? ''; ?></td>
                <td><?php echo $fila['precio'] ?? ''; ?></td>
                <td><?php echo $fila['stock'] ?? ''; ?></td>
                <td>
                    <a href="editar_producto.php?id=<?php echo $fila['id_producto'] ?? ''; ?>">Editar</a>
                    |
                    <a href="eliminar_producto.php?id=<?php echo $fila['id_producto'] ?? ''; ?>" onclick="return confirm('¿Eliminar producto?');">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>