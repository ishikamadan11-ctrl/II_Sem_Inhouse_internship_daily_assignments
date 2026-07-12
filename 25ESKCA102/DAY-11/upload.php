<?php
$folder = "uploads/";
if(!is_dir($folder)) {
    mkdir($folder, 0777, true);
}
if(isset($_FILES['myfile'])){
  $allowed_types = ['jpeg', 'png', 'gif', 'jpg','webp'];

  //pathinfo(file["name"])
  $extension = strtolower(pathinfo($_FILES['myfile']['name'], PATHINFO_EXTENSION));
  //20MB
  $maxsize = 20 * 1024 * 1024;
  if(!in_array($extension,$allowed_types)){
    die("only jpeg, png, gif, jpg, webp files are allowed");
  }
  if($_FILES['myfile']['size'] > $maxsize){
    die("image size must not exceed 20MB");
  }
  $newName=time()."_".rand(1000,9999).".".$extension;
  $targetfile = $folder.$newName;
  if(move_uploaded_file($_FILES['myfile']['tmp_name'],$targetfile)){
    echo "image uploaded successfully";
  } else {
    echo "error uploading image";
  }
}
?>