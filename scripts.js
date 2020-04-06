function abrirModal(){
    document.getElementById("vModal").style.display="block";
    ocument.getElementById("msj").innerHTML="";

}

function cerrarModal(){
    document.getElementById("vModal").style.display="none";

}

function subirFoto(id){
    // ir a la página subirFotos.php con el id del producto como querystring
    window.location.assign("subirFotos.php?id="+id);
}
