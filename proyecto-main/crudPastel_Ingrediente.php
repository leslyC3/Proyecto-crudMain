<?php
// Se incluye el archivo de conexión a la base de datos
include_once 'conexion.php';
// Se crea un objeto de conexión
$objeto = new Conexion();
// Se establece la conexión a la base de datos
$conexion = $objeto->conectar();

// Se decodifican los datos JSON enviados desde el cliente y se almacenan en $_POST
$_POST = json_decode(file_get_contents("php://input"), true);

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

// Se obtienen los datos enviados desde el cliente
// Se utiliza operador ternario para manejar los casos en que los datos no están definidos en $_POST
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id_pastel_ingrediente = (isset($_POST['id_pastel_ingrediente'])) ? $_POST['id_pastel_ingrediente'] : '';
$id_Pastel = (isset($_POST['id_Pastel'])) ? $_POST['id_Pastel'] : '';
$id_Ingrediente = (isset($_POST['id_Ingrediente'])) ? $_POST['id_Ingrediente'] : '';

// Switch-case para manejar las operaciones CRUD
switch($opcion){
    case 1: // Operación: Mostrar datos
        // Se ejecuta una consulta SQL para seleccionar datos de la tabla "Pastel_ingredientes" junto con los nombres de pastel e ingrediente
        $consulta = "SELECT pi.id_pastel_ingrediente, p.nombre AS nombrePastel, i.nombre AS nombreIngrediente FROM Pastel p INNER JOIN Pastel_ingredientes pi ON pi.id_Pastel=p.id_Pastel INNER JOIN Ingrediente i  ON i.id_Ingrediente=pi.id_Ingrediente";
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
        // Se ejecuta una consulta SQL para insertar un nuevo registro en la tabla "Pastel_ingredientes"
        $consulta = "INSERT INTO Pastel_ingredientes (id_Pastel, id_Ingrediente) VALUES($id_Pastel,$id_Ingrediente)";
        // Se ejecuta la consulta
        $resultado = $conexion->query($consulta);
        break;
    case 3: // Operación: Actualizar registro existente
        // Se ejecuta una consulta SQL para actualizar un registro en la tabla "Pastel_ingredientes"
        $consulta = "UPDATE Pastel_ingredientes SET id_Pastel=$id_Pastel, id_Ingrediente=$id_Ingrediente WHERE id_pastel_ingrediente=$id_pastel_ingrediente";
        // Se ejecuta la consulta
        $resultado = $conexion->query($consulta);
        break;        
    case 4: // Operación: Borrar registro
        // Se ejecuta una consulta SQL para eliminar un registro de la tabla "Pastel_ingredientes"
        $consulta = "DELETE FROM Pastel_ingredientes WHERE id_pastel_ingrediente=$id_pastel_ingrediente";
        // Se ejecuta la consulta
        $resultado = $conexion->query($consulta);
        break;         
}

// Se imprime el resultado en formato JSON
print json_encode($data, JSON_UNESCAPED_UNICODE);
// Se cierra la conexión a la base de datos
$conexion = NULL;
?>
