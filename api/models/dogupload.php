<?php

$dbconn = null;
//
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
}

class Upload {
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

class Uploads {
  static function all() {
    $uploads = array();

    $results = pg_query("SELECT * FROM dogupload");

    $row_object = pg_fetch_object($results);
    while($row_object){
      $new_upload = new Upload(
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

  static function create($upload) {
    $query = "INSERT INTO dogupload (breed, image, location) VALUES ($1, $2, $3)";
    $query_params = array($upload->breed, $upload->image, $upload->location);
    pg_query_params($query, $query_params);
    return self::all();
  }
}

 ?>
