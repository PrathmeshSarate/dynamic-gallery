<?php

if (isset($_POST['submit'])) {
  $images = $_FILES['image'];
//   $id = $_POST['id'];
//   echo $id."<pre>";
//   print_r($images);
//   exit();
  $uploaded = [];
  $failed = [];

  for ($i = 0; $i < count($images['name']); $i++) {
    $filename = $images['name'][$i];
    $filetmp = $images['tmp_name'][$i];
    $filesize = $images['size'][$i];

    if ($filesize > 2000000) {
      $failed[$i] = $filename;
      continue;
    }

    $fileext = pathinfo($filename, PATHINFO_EXTENSION);
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($fileext, $allowedExt)) {
      $failed[$i] = $filename;
      continue;
    }

    $filenew = uniqid('', true) . "." . $fileext;

    if (move_uploaded_file($filetmp, "uploads/".$filenew)) {
      $uploaded[$i] = $filename;
    } else {
      $failed[$i] = $filename;
    }
  }

  if (!empty($uploaded)) {
    $uploaded = implode(", ", $uploaded);
    echo "The following files were uploaded successfully: ".$uploaded;
  }

  if (!empty($failed)) {
    $failed = implode(", ", $failed);
    echo "The following files failed to upload: ".$failed;
  }
}
