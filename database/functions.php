<?php
require_once './database/connection.php';

/**
 * Ejecuta una consulta SQL (SELECT) que regresa más de un resultado 
 *
 * @param [String] $sql Consulta SQL
 * @return Array Retorna los resultados de la consulta
 */
function get_elements($sql){
  $conn = get_connection();
  $result = $conn->query($sql) or die($conn->error);
  $row_cnt = $result->num_rows;
  $elements = array();
    if ($row_cnt> 0) {
      while ($row = $result->fetch_assoc()) {
        $elements[] = $row;
      }
    }
  $conn->close();
  return $elements;
}

/**
 * Ejecuta una consulta SQL (SELECT) que regresa solo un resultado
 *
 * @param [String] $sql Consulta SQL 
 * @return Array Retorna el resultado de la consulta
 */
function get_element($sql){
  $conn = get_connection();
  $result = $conn->query($sql) or die($conn->error);
  $row_cnt = $result->num_rows;
    if ($row_cnt === 1) {
      while ($row = $result->fetch_assoc()) {
        $conn->close();
        return $row;
      }
    }
  $conn->close();
  return NULL;
}

/**
 * INSERT INTO tabla (campos) VALUES(valores)
 *
 * @param [String] $tabla Nombre de la tabla
 * @param [Array] $data Datos que se insertaran
 * @return int/False Retorna el ID de la insercion o un FALSE si no se pudo insertar 
 */
function insert_element($tabla,$data){
  $conn = get_connection();
  $campos = [];
  $valores = [];

  foreach ($data as $key => $value) {
    $campos[]= $key;
    $valores[] = $value;
  }

  $sql = 'INSERT INTO ' . $tabla . ' (';
  $sql .= implode(', ', $campos);
  $sql .= ') VALUES (';
  $sql .= '"'. implode('","',$valores) .'"';
  $sql .= ')';
  $result = $conn->query($sql);
  return ($result)?$conn->insert_id:FALSE; 
}

/**
 * UPDATE tabla SET campo = valor, ... WHERE id = valor
 *
 * @param [String] $tabla Nombre de la tabla
 * @param [Array] $data Campos y valores que seran actualizados
 * @param [int] $id ID del registro a actualizar
 * @return Array Retorna el resultado de la consulta
 */
function update_element($tabla, $data, $id){
  $conn = get_connection();
  $sql = 'UPDATE ' . $tabla . ' SET ';
    $elements = [];
    foreach ($data as $key => $value) {
      $elements[] = $key. ' = "'. $value .'"'; //Faltaban unos corchetes aqui
    }
    $sql.= implode(',', $elements);
    $sql.= ' WHERE id = ' . $id;
    $result = $conn->query($sql);
    echo "<br>";
    print_r($result);
    return $result;
}
?>
