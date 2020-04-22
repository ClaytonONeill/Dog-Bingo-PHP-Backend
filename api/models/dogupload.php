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

// GET ALL POSTS
// ==============

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

// SHOW A POST
// ================

  static function show($id) {
    $show_upload = [];

    $results = pg_query("SELECT * FROM dogupload WHERE id = $id");

    $row_object = pg_fetch_object($results);

    $new_upload = new Upload(
        intval($row_object->id),
        $row_object->breed,
        $row_object->image,
        $row_object->location
    );
      $show_upload[] = $new_upload;

      $row_object = pg_fetch_object($results);

      return $show_upload;
  }


// UPLOAD A POST
// ================

  static function create($upload) {
    $query = "INSERT INTO dogupload (breed, image, location) VALUES ($1, $2, $3)";
    $query_params = array($upload->breed, $upload->image, $upload->location);
    pg_query_params($query, $query_params);
    return self::all();
  }

// UPDATE A POST
// ================

  static function update($updated_upload) {

    $query = "UPDATE dogupload SET breed = $1, image = $2, location = $3 WHERE id = $4";

    $query_params = array($updated_upload->breed, $updated_upload->image, $updated_upload->location, $updated_upload->id);

    $results = pg_query_params($query, $query_params);

    return self::all();
  }

// DELETE A POST
// ================

static function delete($id) {
  $query = "DELETE FROM dogupload WHERE id = $1";
    $query_params = array($id);
    $results = pg_query_params($query, $query_params);

    return self::all();
}


}

 ?>
