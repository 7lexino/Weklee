function pasarNumeros(){
        var conexion;
        if(window.XMLHttpRequest){
        conexion = new XMLHttpRequest();
        }else{
            conexion = new ActiveXOject("Microsoft.XMLHTTP");
            }           
            conexion.onreadystatechange = function(){
            if(conexion.readyState==3 && conexion.status==200){
            document.getElementById("texto").innerHTML=conexion.responseText;           
            }               
            }
            var datos= document.form1.contenido.value;
            conexion.open("GET",'datos.php?variable='+datos, true);
            conexion.send();
           
    }