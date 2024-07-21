<?php
class MetodosPago extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['nombre_usuario'])) {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }
    }
    public function index()
    {
        $data['title'] = 'metodosPago';
        $this->views->getView('admin/metodosPago', "index", $data);
    }
    public function listar()
    {
        // Obtiene los metodos de pago activos (estado 1) desde el modelo
        $data = $this->model->getMetodosPago(1);

        // Itera sobre cada metodo de pago y agrega las acciones de edición y eliminación
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['imagen'] = '<img class="img-thumbnail" src="' . $data[$i]['imagen'] . '" alt="' . $data[$i]['nombre'] . '" width="50">';
            $data[$i]['accion'] = '<div class="d-flex">
            <button class="btn btn-primary" type="button" onclick="editMetPago(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger" type="button" onclick="eliminarMetPago(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i></button>
        </div>';
        }
        echo json_encode($data);
        die();
    }

    public function registrar()
    {
        // Verifica si los campos 'nombre' y 'numero_cuenta' están presentes en la solicitud POST
        if (isset($_POST['nombre']) && isset($_POST['numero_cuenta'])) {
            $numero_cuenta = $_POST['numero_cuenta'];
            $nombre = $_POST['nombre'];
            $imagen = $_FILES['imagen'];
            $tmp_name = $imagen['tmp_name'];
            $id = $_POST['id'];
            $ruta = 'assets/images/metodosPago/';
            $nombreImg = date('YmdHis');

            // Verifica si los campos 'nombre' o 'numero_cuenta' están vacíos
            if (empty($nombre) || empty($numero_cuenta)) {
                $respuesta = array('msg' => 'todo los campos son requeridos', 'icono' => 'warning');
            } else {
                // Determina la ruta de la imagen a guardar
                if (!empty($imagen['name'])) {
                    $destino = $ruta . $nombreImg . '.jpg';
                } else if (!empty($_POST['imagen_actual']) && empty($imagen['name'])) {
                    $destino = $_POST['imagen_actual'];
                } else {
                    $destino = $ruta . 'default.png';
                }

                // Si el campo 'id' está vacío, intenta registrar un nuevo metodo de pago
                if (empty($id)) {
                    $data = $this->model->registrar($nombre, $destino, $numero_cuenta);
                    if ($data > 0) {
                        if (!empty($imagen['name'])) {
                            move_uploaded_file($tmp_name, $destino);
                        }
                        $respuesta = array('msg' => 'metodo de pago registrado', 'icono' => 'success');
                    } else {
                        $respuesta = array('msg' => 'error al registrar', 'icono' => 'error');
                    }
                } else {
                    // Si el campo 'id' no está vacío, intenta modificar un metdodo de pago existente
                    $data = $this->model->modificar($nombre, $destino, $numero_cuenta, $id);
                    if ($data == 1) {
                        if (!empty($imagen['name'])) {
                            move_uploaded_file($tmp_name, $destino);
                        }
                        $respuesta = array('msg' => 'producto modificado', 'icono' => 'success');
                    } else {
                        $respuesta = array('msg' => 'error al modificar', 'icono' => 'error');
                    }
                }
            }
            echo json_encode($respuesta);
        }
        die();
    }
    //eliminar metodos de pago
    public function delete($idMetPago)
    {
        if (is_numeric($idMetPago)) {
            // Se intenta eliminar el producto a través del modelo
            $data = $this->model->eliminar($idMetPago);
            if ($data == 1) {
                // Si la eliminación es exitosa, se prepara una respuesta de éxito
                $respuesta = array('msg' => 'método de pago dado de baja', 'icono' => 'success');
            } else {
                // Si ocurre un error al eliminar, se prepara una respuesta de error
                $respuesta = array('msg' => 'error al eliminar', 'icono' => 'error');
            }
        } else {
            $respuesta = array('msg' => 'error desconocido', 'icono' => 'error');
        }
        echo json_encode($respuesta);
        die();
    }
    //editar productos
    public function edit($idMetPago)
    {
        if (is_numeric($idMetPago)) {
            // Se obtienen los datos del producto desde el modelo
            $data = $this->model->getMetodoPago($idMetPago);
            // Se envían los datos del producto como JSON para ser consumidos por el frontend
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function galeriaImagenes()
    {
        $id = $_POST['idProducto'];

        // Se establece el nombre de la carpeta para las imágenes del producto
        $folder_name = 'assets/images/productos/' . $id . '/';

        // Se verifica si hay archivos en la solicitud
        if (!empty($_FILES)) {

            // Si la carpeta no existe, se crea para almacenar las imágenes del producto
            if (!file_exists($folder_name)) {
                mkdir($folder_name);
            }

            // Se mueve el archivo cargado a la carpeta del producto, asegurando que cada 
            //archivo tenga un nombre único basado en la fecha y hora actual
            $temp_name = $_FILES['file']['tmp_name'];
            $ruta = $folder_name . date('YmdHis') . $_FILES['file']['name'];
            move_uploaded_file($temp_name, $ruta);
        }
    }

    public function verGaleria($id_metodoPago)
    {
        $result = array();

        // Se establece el directorio de las imágenes del producto
        $directorio = 'assets/images/metodosPago/' . $id_metodoPago;
        if (file_exists($directorio)) {

            // Se obtiene la lista de archivos en el directorio
            $imagenes = scandir($directorio);
            if (false !== $imagenes) {
                foreach ($imagenes as $file) {

                    // Se ignoran las entradas '.' y '..' que representan el directorio actual y el directorio padre
                    if ('.' != $file && '..' != $file) {

                        // Se agrega el nombre del archivo a la lista de resultados
                        array_push($result, $file);
                    }
                }
            }
        }
        echo json_encode($result);
        die();
    }

    public function eliminarImg()
    {
        // Se obtiene el cuerpo de la solicitud que contiene los datos enviados en formato JSON
        $datos = file_get_contents('php://input');

        // Se decodifican los datos JSON a un array asociativo
        $json = json_decode($datos, true);

        // Se establece la ruta del archivo a eliminar basado en la URL proporcionada en los datos JSON
        $destino = 'assets/images/metodosPago/' . $json['url'];
        if (unlink($destino)) {
            $res = array('msg' => 'IMAGEN ELIMINADO', 'icono' => 'success');
        } else {
            $res = array('msg' => 'ERROR AL ELIMINAR', 'icono' => 'error');
        }
        echo json_encode($res);
        die();
    }
}
