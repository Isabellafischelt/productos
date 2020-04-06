<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
</head>
<body>
<?php
// revisamos si se ha enviado el formalario
if (isset($_POST["nombre"])){
    //recuperamos los datos enviados por el formulario
    include "../conexion.php";
    $producto = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];

    $nombreFoto = $_FILES["foto"]["name"];



    if ($nombreFoto == ""){
        //hacemos un query para insertar los datos en la BD
        $sql = "insert into isabella_productos (producto, descripcion, precio) values('$producto', '$descripcion', '$precio')";
        $cero = ejecutar($sql);

        echo "<script language='javascript'>";
        echo "window.location.assign('index.php');";
        echo "window.alert('El producto se ingresó correctamente a la base de datos.');";
        echo "</script>";
    }
    else{
        $tipo = $_FILES["foto"]["type"];
        $tamano = round($_FILES["foto"]["size"]/1024);
        $error = 0; /*no tenemos errores*/

        /* checamos que el archivo sea una imagen */
        
        if ($tipo != "image/jpeg" && $tipo != "image/jpg" && $tipo != "image/png"){
            $error = 1;
        /* checamos el tamaño del archivo (que sea menor a 500 MB) */
        }else if ($tamano > 500000){
            $error = 2;
        }
        /* checamos el valor del error */
        if ($error != 0) {
            /* Reenviamos la página a index, con el error como querystring */
            echo "<script language='javascript'>";
            echo "window.location.assign('index.php?error=".$error."');";
            echo "</script>";
        }else{

            /* no hay errores: subimos la página al servidor y el nombre del archivo a la BD */
            $maxid = "select max(IdProducto) from isabella_productos";
            $nombreFinal = $maxid."_".$nombreFoto;
            $archivoParaSubir = $ruta.$nombreFinal;
            $temp = $_FILES["foto"]["tmp_name"]; /*nombre temporal del archivo que lo usa internament PHP para subirlo al servidor*/

            if (move_uploaded_file($temp, $archivoParaSubir)){
                //el archivo si subió al servidor.  Insertamos su nombre en la BD*/
                $sql = "insert into isabella_productos (nombre, descripcion, precio) values('$nombre', '$descripcion', '$precio')";
                $cero = ejecutar($sql);

                $sql = "insert into isabella_fotoProductos (idProducto, foto) values(($maxid, '$nombreFinal')";
                $cero = ejecutar($sql);

                echo "<script language='javascript'>";
                echo "window.location.assign('index.php?foto=yes');";
                echo "</script>";

            }else{
                // el archivo no subió al servidor. Redireccionamos la página con  un error*/
                echo "<script language='javascript'>";
                echo "window.location.assign('index.php?error=3');";
                echo "</script>";
            }
        }
        
    }


}else{
    //no se ha enviado nada, redireccionamos a index
    echo "<script language='javascript'>";
    echo "window.location.assign('index.php');";
    echo "</script>";
}
?>
    
</body>
</html>