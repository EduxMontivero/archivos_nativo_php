<?php
$tarea="";
if (isset($_GET['tarea'])) {
	$tarea=$_GET['tarea'];
}

//tarea cargar
if($tarea=="cargar"){
	// Configuración
	$folder = ""; // Carpeta a la que subir los archivos
	$maxlimit = 5000000; // Máximo límite de tamaño (en bits)
	$allowed_ext = "rar,jpg,exe,png,zip,docx,pdf,txt"; // Extensiones permitidas (usad una coma para separarlas)
	$overwrite = "no"; // Permitir sobreescritura? (yes/no)
	$error="";

	$match = ""; 
	$filesize = $_FILES['userfile']['size']; // toma el tamaño del archivo
	$filename = strtolower($_FILES['userfile']['name']); // toma el nombre del archivo y lo pasa a minúsculas
	$filename = str_replace(' ', '', $filename); //ponemos el nombre del archivo sin espacios (para linquear)



	if(!$filename || $filename==""){ // comprueba si no se ha seleccionado ningún archivo
	   $error = "- Ningún archivo selecccionado para subir.<br>";
	}elseif(file_exists($folder.$filename) && $overwrite=="no"){ // comprueba si el archivo existe ya
	   $error = "- El archivo <b>$filename</b> ya existe<br>";
	}

	// comprobar tamaño de archivo
	if($filesize < 1){ // el archivo está vacío
	   $error .= "- Archivo vacío.<br>";
	}elseif($filesize > $maxlimit){ // el archivo supera el máximo permitido
	   $error .= "- Este archivo supera el máximo tamaño permitido.<br>";
	}

	$file_ext = preg_split("/\./",$filename);
	$allowed_ext = preg_split("/\,/",$allowed_ext);
	foreach($allowed_ext as $ext){
	   if($ext==$file_ext[1]) $match = "1"; // Permite el archivo
	}

	// Extensión no permitida
	if(!$match){
	   //$error .= "- Este tipo de archivo no está permitido: $filename<br>";
	}

	if($error){
	   print "Se ha producido el siguiente error al subir el archivo:<br> $error"; // Muestra los errores
	}else{
	   if(move_uploaded_file($_FILES['userfile']['tmp_name'], $folder.$filename)){ // Sube el archivo
	      print "<b>$filename</b> se ha subido correctamente!"; // Mensaje de aviso, upload correcto
	   }else{
	      print "Error! Puede que el tamaño supere el máximo permitido por el servidor. Inténtelo de nuevo."; // error
	   }
	}
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Subir Archivo</title>
</head>
<body>
    <form action="subir.php?tarea=cargar" method="post" enctype="multipart/form-data">
	    <b>Subir un archivo: </b>
	    <br>
	    <input name="userfile" type="file">
	    <br>
    	<input type="submit" value="Subir">
 	</form>
 <a href="index."></a>
 <!--
 <form>
     <INPUT TYPE="button" VALUE="Atrás" onClick="history.back()">
</form>
-->
</body>
</html>