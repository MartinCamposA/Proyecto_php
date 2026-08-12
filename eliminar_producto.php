<?php 
    require_once 'Conexiondatabase.php';

    if (!isset($_GET['id'])) {
        die("ID de producto no encontrado. <a href='productos.php'>Volver al inventario</a>");
    }

    $id_producto = intval($_GET['id']);

    $queryDelete = "DELETE FROM pos_productos WHERE id_producto = :id_producto";

    try {
        $rtsDelete = $conn->prepare($queryDelete);
        $rtsDelete->execute([':id_producto' => $id_producto]);
        echo "Producto eliminado correctamente. <a href='productos.php'>Volver al inventario</a>";
    } catch (PDOException $e) {
        echo "Error al eliminar el producto: " . $e->getMessage();
    }
?>