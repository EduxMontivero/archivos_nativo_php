<?php

$tarea="";
if(isset($_POST["tarea"])){
	$tarea=$_POST["tarea"];
}
if(isset($_GET["tarea"])){
	$tarea=$_GET["tarea"];
}

if($tarea=="eliminar"){
	echo "ELIMINANDO...";
	$archivo="./descargas/archivos/".$_GET["archivo"];
	unlink($archivo);
	header("Location: descargas.php");
}

if($tarea=="cargar"){

$message = ''; 
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Cargar')
{
  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
  {
    // get details of the uploaded file
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // sanitize file-name
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

    // check if file has one of the following extensions
    $allowedfileExtensions = array('rar','pdf','docx','ppt','pptx','mp4','mp3','wav','ogg','m4v','jpeg', 'jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');

    if (in_array($fileExtension, $allowedfileExtensions))
    //if(1==1)
    {
      // directory in which the uploaded file will be moved
      $uploadFileDir = './descargas/archivos/';
      $dest_path = $uploadFileDir . $newFileName;

      if(move_uploaded_file($fileTmpPath, $dest_path)) 
      {
        echo'File is successfully uploaded.';
      }
      else 
      {
        echo 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
      }
    }
    else
    {
      echo 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
    }
  }
  else
  {
    echo  'There is some error in the file upload. Please check the following error.<br>';
    echo 'Error:' . $_FILES['uploadedFile']['error'];
  }
}

header("Location: descargas.php");

}

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width"/>
  <style type="text/css">
    *{
      font-family:arial;
  </style>
</head>
<body>
  <div>
    <?php include("nav.php"); ?>
    <center><h3>Descargas</h3></center>
    <h4>Archivos</h4>

    <ul>
    <?php

function listarArchivos( $path ){
    // Abrimos la carpeta que nos pasan como parámetro
    $dir = opendir($path);
    // Leo todos los ficheros de la carpeta
    while ($elemento = readdir($dir)){
        // Tratamos los elementos . y .. que tienen todas las carpetas
        if( $elemento != "." && $elemento != ".."){
            // Si es una carpeta
            if( is_dir($path.$elemento) ){
                // Muestro la carpeta
                //echo "<p><strong>". $elemento ."</strong></p>";
            // Si es un fichero
            } else {
                // Muestro el fichero
                echo "<li><a target=_blank href=descargas/archivos/".$elemento.">". $elemento."</a> <a HREF=descargas.php?tarea=eliminar&archivo=".$elemento.">(eliminar)</a></li>";
            }
        }
    }
}

listarArchivos("./descargas/archivos/");

?>
</ul>

<form method="post" enctype="multipart/form-data" action="descargas.php">
	<input type="hidden" name="tarea" value="cargar">
	<div>
      
      <input type="file" name="uploadedFile" />
    </div>
 
    <input type="submit" name="uploadBtn" value="Cargar" />
</form>
  </div>
<?php include("footer.php"); ?>
</body>
</html>
