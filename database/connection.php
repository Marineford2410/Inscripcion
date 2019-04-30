<?php
  require_once './config/database.php';

  /**
   * Establece la conexion a la BD
   *
   * @return mysqli Objeto de conexion
   */
  function get_connection(){
    extract($GLOBALS['db_connection']);
    $conn = new mysqli($servername, $username, $password,$dbname);
    if ($conn->connect_error) {
        die("Error en la conexión a la DB: " . $conn->connect_error);
    }
    $conn->set_charset($charset);
    return $conn;
  }
?>
