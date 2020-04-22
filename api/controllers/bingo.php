<?php
include_once __DIR__ . '/../models/dogupload.php';
header('Content-Type: application/json');

if ($_REQUEST['action'] === 'index') {
  echo json_encode(Uploads::all());

}
else if ($_REQUEST['action'] === 'post') {
  $request_body = file_get_contents('php://input');
  $body_object = json_decode($request_body);
  $new_upload = new Upload(null,
  $body_object->breed,
  $body_object->image,
  $body_object->location
);
  $all_uploads = Uploads::create($new_upload);
  echo json_encode($all_uploads);
}


 ?>
