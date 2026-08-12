<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

require_once 'Conexiondatabase.php';


if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$mensaje = "";

if (isset($_GET['quitar'])) {
    $id_quitar = intval($_GET['quitar']);
    unset($_SESSION['carrito'][$id_quitar]);
    header("Location: index.php"); 
    exit;
}


if (isset($_GET['cancelar'])) {
    $_SESSION['carrito'] = [];
    header("Location: index.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo'])) {
    
    $codigo = trim($_POST['codigo']); 

    
    $query = "SELECT * FROM pos_productos WHERE codigo_barras = :codigo";
    $stmt = $conn->prepare($query);
    $stmt->execute([':codigo' => $codigo]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        $id = $producto['id_producto'];
        
        
        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad'] += 1;
        } else {
            
            $_SESSION['carrito'][$id] = [
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'cantidad' => 1
            ];
        }
        
        
        header("Location: index.php");
        exit;
    } else {
        $mensaje = "<h4 style='color: #e74c3c; margin-top: 10px;'>Código no encontrado: $codigo</h4>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Caja - Mi Sistema POS</title>
    <link rel="stylesheet" href="static/index.css">
    
</head>
<body>

    
    <div class="navbar">
        <h3 style="color: white; margin-right: 20px;">MiBotillería POS</h3>
        <a href="index.php" class="activo">Caja</a>
        <a href="productos.php">Inventario</a>
        <a href="ventas.php">Ventas</a>
        <div style="float: right;"></div>
            <a href="logout.php" style="margin-left: 20px; color: white;">Cerrar sesión</a>
        </div>
    </div>


    <div class="contenedor">
        
        
        <div class="panel col-escaner">
            <h2>Escanear Producto</h2>
            
            <form action="" method="POST">
               
                <input type="text" name="codigo" class="escaner-input" placeholder="Escanea el código aquí" autofocus autocomplete="off">
                <input type="submit" style="display: none;">
            </form>

            <?php echo $mensaje; ?>


        </div>

        
        <div class="panel col-caja">
            <h2>Venta Actual</h2>
        
            <div style="flex-grow: 1; overflow-y: auto;">
                <table class="tabla-carrito">
                    <thead>
                        <tr>
                            <th>Cant.</th>
                            <th>Producto</th>
                            <th style="text-align: right;">Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        
                        foreach ($_SESSION['carrito'] as $id => $item) { 
                            $subtotal = $item['precio'] * $item['cantidad'];
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td><strong><?php echo $item['cantidad']; ?>x</strong></td>
                                <td><?php echo $item['nombre']; ?></td>
                                <td align="right">$<?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                                <td align="center">
                                    <a href="index.php?quitar=<?php echo $id; ?>" class="btn-quitar" title="Quitar un producto">✕</a>
                                </td>
                            </tr>
                        <?php 
                        } 
                        
                        if (empty($_SESSION['carrito'])) {
                            echo "<tr><td colspan='4' align='center' style='color:#95a5a6; padding:30px;'>El carrito está vacío</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            
            <div class="zona-totales">
                <div class="texto-total">
                    <span>TOTAL A PAGAR:</span>
                    <span>$<?php echo number_format($total, 0, ',', '.'); ?></span>
                </div>
            </div>

            <div class="botones-accion">
                
                <a href="index.php?cancelar=true" class="btn-cancelar">Cancelar</a>
                
                
                <button class="btn-pagar" <?php if($total == 0) echo "disabled style='background-color:#ccc; cursor:not-allowed;'"; ?>>
                    PROCESAR PAGO
                </button>
            </div>
            
        </div>
    </div>

</body>
</html>