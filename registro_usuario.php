<?php
    //enlazar mi conexión generada con el registro
    include 'conexion.php';
    //crear nombres de variables para que se alma
    $nombre= $_POST['nombre_completo'];
    $correo= $_POST['correo'];
    $contrasena= $_POST['contrasena'];
    $id=$_id['id'];
    //crar query para que los datos de las variables la guarde en las tablas
    //sentencia INsert y el nombre de las columnas asignadas en las tablas
    $query="INSERT INTO usuario(nombre_completo,correo,contrasena, id)
                VALUES('$nombre','$correo','$contrasena','$id')";
    //ejecutar la query
    $ejecutar = mysqli_query($conexion,$query);
    //antes conectamos e incluyendo el archivo de conexión (caja y llave query)            

    if($ejecutar){
        echo '
            <script>
                alert("Usuario almacenado correctamente");
                window.location.href= "inicio.html";
            </script>
                ';
    }else{
        echo '
            <script>
                alert("Usuario NO almacenado correctamente");
                window.location.href= "inicio.html";
            </script>
                ';
    }

    //verificar que el correo no se repita
    $verificar_correo=mysqli_query($conexion,
        "SELECT * FROM usuario WHERE correo='$correo'");

    //condicional para verificar si existe una fila con el mismo correo se usa el parametro
    //CODIGO PARA DETECTAR
    if(mysqli_num_rows($verificar_correo)>0){
        echo '
            <script>
                alert("Este correo ya está registrado, intenta con otro");
                window.location.href="inicio.html";
            </script>
        ';
        exit(); //código para no ejecytar instrucciones siguientes
    }

?>




