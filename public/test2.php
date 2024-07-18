<?php
// Parámetros de conexión

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = 'FINSCORE';
$password = 'FINSCORE';
$connection_string = 'db_ora19c:1521/ORCL';

// Mostrar los parámetros de conexión para verificar que son correctos
echo "Intentando conectar con la cadena: $connection_string\n";

// Conectar a Oracle
$conn = oci_connect($username, $password, $connection_string);

// Verificar si la conexión ha fallado
if (!$conn) {
    // Obtener y mostrar el error detallado de OCI
    $e = oci_error();
    echo "No se pudo conectar a la base de datos:\n";
    echo "Mensaje de error: " . $e['message'] . "\n";
    echo "Código de error: " . $e['code'] . "\n";
    echo "Posible solución: Verifica que el servidor de la base de datos esté en funcionamiento y que los parámetros de conexión sean correctos.\n";
} else {
    echo "Conexión exitosa a la base de datos Oracle!\n";

    // Preparar la consulta
    $query = 'SELECT * FROM tparametros';

    // Ejecutar la consulta
    $stid = oci_parse($conn, $query);
    if (!oci_execute($stid)) {
        // Obtener y mostrar el error detallado de OCI
        $e = oci_error($stid);
        echo "Error al ejecutar la consulta:\n";
        echo "Mensaje de error: " . $e['message'] . "\n";
        echo "Código de error: " . $e['code'] . "\n";
    } else {
        // Recuperar y mostrar los resultados
        echo "Resultados de la consulta:\n";
        while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
            foreach ($row as $item) {
                echo ($item !== null ? htmlentities($item, ENT_QUOTES) : "NULL") . "\t";
            }
            echo "\n";
        }
    }

    // Liberar los recursos de la consulta
    oci_free_statement($stid);

    // Cerrar la conexión
    oci_close($conn);
}
?>
