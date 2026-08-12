
<?php
session_start();
if (isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

require_once 'Conexiondatabase.php';
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $rut = trim($_POST["rut"]);
    $contrasena = trim($_POST["contrasena"]);

    $query = "SELECT * FROM pos_vendedor WHERE rut = :rut AND contrasena = :contrasena";
    $stmt = $conn->prepare($query);
    $stmt->execute([':rut' => $rut, ':contrasena' => $contrasena]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $_SESSION['id_usuario'] = $usuario['id_vendedor'];
        $_SESSION['nombre_usuario'] = $usuario['nombre'];
        header("Location: index.php");
        exit;
    } else {
        $mensaje = "<h4 style='color: #e74c3c; margin-top: 10px;'>RUT o contraseña incorrectos.</h4>";
    }
}  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login usuario</title>
</head>
<body>
    <div>
        <h2>Iniciar sesión</h2>
        <?php echo $mensaje; ?>
        <form method="POST" action="">
            <input type="text" name="rut" placeholder="RUT" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button type="submit">Iniciar sesión</button>
        </form>
    </div>
</body>
</html>