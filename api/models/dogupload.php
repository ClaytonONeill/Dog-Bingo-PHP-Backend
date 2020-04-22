<?php

if(getenv('DATABASE_URL')){
    $connectionConfig = parse_url(getenv('DATABASE_URL'));
    $host = $connectionConfig['host'];
    $user = $connectionConfig['user'];
    $password = $connectionConfig['pass'];
    $port = $connectionConfig['port'];
    $dbname = trim($connectionConfig['path'],'/');
    $dbconn = pg_connect(
        "host=".$host." ".
        "user=".$user." ".
        "password=".$password." ".
        "port=".$port." ".
        "dbname=".$dbname
    );
} else {
    $dbconn = pg_connect("host=localhost dbname=dog-bingo");


class DogUpload {
  public $id;
  public $breed;
  public $image;
  public $location;

  public function __construct($id, $breed, $image, $location) {
    $this->id = $id;
    $this->breed = $breed;
    $this->image = $image;
    $this->location = $location;
  }
}

class DogUploads {
  static function all() {
    $uploads = array();

    $results = pg_query("SELECT * FROM dogupload");

    $row_object = pg_fetch_object($results);
    while($row_object){
      $new_upload = new DogUpload(
        intval($row_object->id),
        $row_object->breed,
        $row_object->image,
        $row_object->location
      );

      $uploads[] = $new_upload;
      $row_object = pg_fetch_object($results);
    }
    return $uploads;
  }
}

 ?>
