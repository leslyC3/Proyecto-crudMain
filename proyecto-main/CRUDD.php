<?php
// Se incluye el archivo de conexión a la base de datos
include_once 'conexion.php';
// Se crea un objeto de conexión
$objeto = new Conexion();
// Se establece la conexión a la base de datos
$conexion = $objeto->conectar();

// Función para manejar permisos CORS
function permisos() {  
    // Se verifica si existe un origen en la solicitud
    if (isset($_SERVER['HTTP_ORIGIN'])){
        // Se establecen los encabezados para permitir solicitudes desde cualquier origen
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Credentials: true');      
    }  
    // Se verifica si la solicitud es una opción (preflight)
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
        // Se establecen los encabezados permitidos para la solicitud de opción
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))          
            header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
        // Se finaliza la ejecución del script
        exit(0);
    }
}
// Se llama a la función de manejo de permisos CORS
permisos();

// Se decodifican los datos JSON enviados desde el cliente y se almacenan en $_POST
$_POST = json_decode(file_get_contents("php://input"), true);

// Se obtienen los datos enviados desde el cliente
// Se utiliza operador ternario para manejar los casos en que los datos no están definidos en $_POST
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id_Pastel = (isset($_POST['id_Pastel'])) ? $_POST['id_Pastel'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$preparado_por = (isset($_POST['preparado_por'])) ? $_POST['preparado_por'] : '';
$fecha_creacion = (isset($_POST['fecha_creacion'])) ? $_POST['fecha_creacion'] : '';
$fecha_vencimiento = (isset($_POST['fecha_vencimiento'])) ? $_POST['fecha_vencimiento'] : '';

// Switch-case para manejar las operaciones CRUD
switch($opcion){
    case 1: // Operación: Mostrar datos
        // Se ejecuta una consulta SQL para seleccionar datos de la tabla "Pastel"
        $consulta = "SELECT id_Pastel, nombre, descripcion, preparado_por, fecha_creacion, fecha_vencimiento FROM Pastel";
        // Se ejecuta la consulta y se obtienen los resultados
        $resultado = $conexion->query($consulta);
        // Se crea un array para almacenar los datos obtenidos
        $data = array();
        // Se recorren los resultados y se agregan al array
        while ($row = $resultado->fetch_assoc()) {
            $data[] = $row;
        }
        break;
    case 2: // Operación: Crear nuevo registro
        // Se ejecuta una consulta SQL para insertar un nuevo registro en la tabla "Pastel"
        $consulta = "INSERT INTO pastel (nombre, descripcion, preparado_por,fecha_creacion,fecha_vencimiento) VALUES('$nombre','$descripcion', '$preparado_por', '$fecha_creacion','$fecha_vencimiento')";
        // Se ejecuta la consulta
        $resultado = $conexion->query($consulta);
        break;
    case 3: // Operación: Actualizar registro existente
        // Se ejecuta una consulta SQL para actualizar un registro en la tabla "Pastel"
        $consulta = "UPDATE pastel SET nombre='$nombre', descripcion='$descripcion', preparado_por='$preparado_por', fecha_creacion='$fecha_creacion', fecha_vencimiento='$fecha_vencimiento' WHERE id_Pastel=$id_Pastel";
        // Se ejecuta la consulta
        $resultado = $conexion->query($consulta);
        break;        
    case 4: // Operación: Borrar registro
        // Se ejecuta una consulta SQL para eliminar un registro de la tabla "Pastel"
        $consulta = "DELETE FROM pastel WHERE id_Pastel=$id_Pastel";
        // Se ejecuta la consulta
        $resultado = $conexion->query($consulta);
        break;         
}

// Se imprime el resultado en formato JSON
print json_encode($data, JSON_UNESCAPED_UNICODE);
// Se cierra la conexión a la base de datos
$conexion = NULL;
?>
