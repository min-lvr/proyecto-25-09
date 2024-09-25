<?php
    include 'conexion.php';

    $correo=$_POST['correo'];
    $contrasena=$_POST['contrasena'];

    $validar_login=mysqli_query($conexion,
        "SELECT * FROM usuario WHERE correo='$correo' and contrasena='$contrasena'");

    if(mysqli_num_rows($validar_login)>0){//si encuentra una fila
        header("location: inicio.html");//redirige a página de bienvenida
    }else{
        echo '
            <script>
                alert("Usuario no existe, verifica los datos");
                window.location.href= "signup.html";
            </script>
            ';
            exit();
    }
?>