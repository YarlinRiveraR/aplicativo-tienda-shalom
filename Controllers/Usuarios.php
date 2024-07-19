<?php
class Usuarios extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();

            // Verifica si la sesión no tiene el nombre de usuario, redirige a la página de inicio de sesión
        if (empty($_SESSION['nombre_usuario'])) {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }
    }
    public function index()
    {
        $data['title'] = 'usuarios';

        // Carga la vista 'index' desde 'admin/usuarios' pasando los datos necesarios
        $this->views->getView('admin/usuarios', "index", $data);
    }
    public function listar()
    {
        // Obtiene los usuarios activos (estado 1) desde el modelo
        $data = $this->model->getUsuarios(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['accion'] = '<div class="d-flex">
            <button class="btn btn-primary" type="button" onclick="editUser(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger" type="button" onclick="eliminarUser(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i></button>
        </div>';
        }
        echo json_encode($data);
        die();
    }
    public function registrar()
    {
        // Verifica si el campo 'nombre' está presente en la solicitud POST
        if (isset($_POST['nombre'])) {
            // Asigna los valores de los campos de la solicitud POST a variables locales
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $correo = $_POST['correo'];
            $clave = $_POST['clave'];
            $id = $_POST['id'];

            // Hashea (encripta) la clave proporcionada
            $hash = password_hash($clave, PASSWORD_DEFAULT);

            // Verifica si los campos 'nombre' o 'apellido' están vacíos
            if (empty($_POST['nombre']) || empty($_POST['apellido'])) {
                // Si están vacíos, se prepara una respuesta indicando que todos los campos son requeridos
                $respuesta = array('msg' => 'todos los campos son requeridos', 'icono' => 'warning');
            } else {
                // Si el campo 'id' está vacío, se realiza un registro de un nuevo usuario
                if (empty($id)) {
                    // Verifica si el correo ya existe en la base de datos
                    $result = $this->model->verificarCorreo($correo);
                    if (empty($result)) {
                        // Si el correo no existe, intenta registrar el nuevo usuario
                        $data = $this->model->registrar($nombre, $apellido, $correo, $hash);
                        if ($data > 0) {
                            // Si el registro es exitoso, prepara una respuesta de éxito
                            $respuesta = array('msg' => 'usuario registrado', 'icono' => 'success');
                        } else {
                            // Si ocurre un error al registrar, prepara una respuesta de error
                            $respuesta = array('msg' => 'error al registrar', 'icono' => 'error');
                        }
                    } else {
                        // Si el correo ya existe, prepara una respuesta indicando que el correo ya está registrado
                        $respuesta = array('msg' => 'correo ya existe', 'icono' => 'warning');
                    }
                } else {
                    // Si el campo 'id' no está vacío, se realiza una modificación de un usuario existente
                    $data = $this->model->modificar($nombre, $apellido, $correo, $id);
                    if ($data == 1) {
                        // Si la modificación es exitosa, prepara una respuesta de éxito
                        $respuesta = array('msg' => 'usuario modificado', 'icono' => 'success');
                    } else {
                        // Si ocurre un error al modificar, prepara una respuesta de error
                        $respuesta = array('msg' => 'error al modificar', 'icono' => 'error');
                    }
                }
            }

            // Envía la respuesta como JSON
            echo json_encode($respuesta);
        }

        // Termina la ejecución del script
        die();
    }

    //eliminar usuario
    public function delete($idUser)
    {
        if (is_numeric($idUser)) {
            $data = $this->model->eliminar($idUser);
            if ($data == 1) {
                $respuesta = array('msg' => 'usuario dado de baja', 'icono' => 'success');
            } else {
                $respuesta = array('msg' => 'error al eliminar', 'icono' => 'error');
            }
        } else {
            $respuesta = array('msg' => 'error desconocido', 'icono' => 'error');
        }
        echo json_encode($respuesta);
        die();
    }
    //editar usuario
    public function edit($idUser)
    {
        if (is_numeric($idUser)) {
            $data = $this->model->getUsuario($idUser);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
