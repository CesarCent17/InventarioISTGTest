<?php
    require('mysqli_conexion.php');
    require('querys_area_de_ubicacion.php');

    session_start();
    if(!isset($_SESSION['usuario'])) {
        // Si el usuario no está iniciado sesión, lo redirigimos a la página de inicio de sesión
        header("Location: ../views/login.php");
    } else {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Requeridos
            $id_area = $_POST['id_area'];
            $direccion = $_POST['direccion'];
            update_area_de_ubicacion($conexion, $direccion, $id_area); 
        }
    }

?>