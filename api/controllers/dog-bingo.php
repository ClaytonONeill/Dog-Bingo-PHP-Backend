<?php
include_once __DIR__ . '/../models/dogupload.php';
header('Content-Type: application/json');

if ($_REQUEST['action'] === 'index') {
  echo json_encode(DogUploads::all());
}

 ?>
