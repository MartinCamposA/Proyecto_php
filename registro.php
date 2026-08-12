
<?php 

require_once 'Conexiondatabase.php';
$mensaje = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rut = trim($_POST["rut"]);
    $nombre = trim($_POST["nombre"]);
    $contrasena = trim($_POST["contrasena"]);
    $rol = trim($_POST["rol"]);
    $correo = trim($_POST["correo"]);



    $query = "INSERT INTO pos_vendedor (rut, nombre, contrasena, rol, correo) VALUES (:rut, :nombre, :contrasena, :rol, :correo)";

    try{
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':rut' => $rut,
            ':nombre' => $nombre,
            ':contrasena' => $contrasena,
            ':rol' => $rol,
            ':correo' => $correo

        ]);
        $mensaje = "Usuario registrado exitosamente.";
    } catch (PDOException $e) {
        $mensaje = "Error al registrar usuario: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro usuario</title>
    <link rel="stylesheet" type="text/css" href="static/registro.css">                              
</head>
<body>
    <div class="formulario">
        <h3>Nuevo trabajador</h3>
        <?php echo $mensaje; ?>
        <form method="POST" action="">
            <label for="rut"> RUT:</label>
            <input type="text" name="rut" required>

            <label for= "correo"> correo:</label>
            <input type="text" name="correo" required>

            <label for= "nombre"> Nombre:</label>
            <input type="text" name="nombre" required>

            <label for="contrasena"> Contraseña:</label>
            <input type="password" name="contrasena" required>

            <label> Rol: </label>
            <select name = "rol">
                <option value="Cajero"> Cajero</option>
                <option value="Admin"> Administrador</option>
            </select>

            <input type = "submit" value="Guardar Usuario">

        </form>
        <br>
        <a href="index.php">Volver al carrito</a>
        <a href="login.php">Ir al login</a>
    </div>
    
</body>
</html>

