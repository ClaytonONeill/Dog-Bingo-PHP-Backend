<?php
include_once __DIR__ . '/../models/quiz.php';
header('Content-Type: application/json');

if ($_REQUEST['action'] === 'index') {
  echo json_encode(DogUploads::all());
}

 ?>
