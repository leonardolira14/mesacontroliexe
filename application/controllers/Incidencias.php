<?php
header('Access-Control-Allow-Origin: *');
require_once(APPPATH . '/libraries/REST_Controller.php');
use Restserver\libraries\REST_Controller;


defined('BASEPATH') or exit('No direct script access allowed');

class Incidencias extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->model('Model_usuarios');
        $this->load->model('Model_incidencia');
        $this->load->model('Model_comentario');
    }

    // funcion para obtener todas las incidencias por usuario
    public function getAlluser_post(){
        $token = $this->input->post("Token");
        $session_data = $this->session->userdata('logged_in');
        if($session_data['Token'] !== $token){
            $_data["msj"] = "sin token" ;
            $_data["ok"] = false;
            $data['response']= $_data;
            return $this->response($data, 404);
        }
        
        // si es una sesion valida debuelvo las icidencias
        $incidencias = $this->Model_incidencia->getAll($session_data['IDUsuario']);
        $_data["data"] = $incidencias;
        $_data["ok"] = true;
        $data['response'] = $_data;
        $this->response($data, 200);
       
    }
    // funcion para obtener todas las incidencias por usuario para los los super admin
    public function getAlluserAdmin_post()
    {
        $token = $this->input->post("Token");
        $IDUsurio = $this->input->post("Usuario");
        $session_data = $this->session->userdata('logged_in');
        if ($session_data['Token'] !== $token) {
            $_data["msj"] = "sin token";
            $_data["ok"] = false;
            $data['response'] = $_data;
            return $this->response($data, 404);
        }

        if($session_data['rol']=== 'superAdmin'){
            // si es una sesion valida debuelvo las icidencias
            $incidencias = $this->Model_incidencia->getAll($IDUsurio);
            $_data["data"] = $incidencias;
            $_data["ok"] = true;
            $data['response'] = $_data;
            $this->response($data, 200);
        }else{
            $_data["msj"] = "Sin derecho a esta seccion";
            $_data["ok"] = false;
            $data['response'] = $_data;
            return $this->response($data, 404);
        }
        
       
    }
    // funcion para los detalles de un incidencia
    public function getIncidencia_post(){
        $IDIncidencia = $this->input->post("Incidencia");
        $token = $this->input->post("Token");
        $session_data = $this->session->userdata('logged_in');
        if ($session_data['Token'] !== $token) {
            $_data["msj"] = "sin token";
            $_data["ok"] = false;
            $data['response'] = $_data;
            return $this->response($data, 404);
        }
        // si es una sesion valida debuelvo las icidencias
        $datos_incidencia = $this->Model_incidencia->getData($IDIncidencia);
        $detalle_incidencia = $this->Model_incidencia->getDataDetalle($IDIncidencia);
        $data_comentarios = $this->Model_comentario->getAll($IDIncidencia);
        
        $_data['data']= $datos_incidencia;
        $_data["detalle"] =  $detalle_incidencia ;
        $_data["comentarios"] =  $data_comentarios;
        $_data["ok"] = false;
        $data['response'] = $_data;
        $this->response($data, 200);
    }

    // funcion para cambiar el status de una incidencia
    public function updatestatus_post(){
        $IDIncidencia = $this->input->post("Incidencia");
        $token = $this->input->post("Token");
        $Status = $this->input->post("Status");
        $session_data = $this->session->userdata('logged_in');
        if ($session_data['Token'] !== $token) {
            $_data["msj"] = "sin token";
            $_data["ok"] = false;
            $data['response'] = $_data;
            return $this->response($data, 404);
        }

        // cambio el status de una incidencia
        $respuesta = $this->Model_incidencia->updatestatus($IDIncidencia, $Status);
        $_data["data"] =  $respuesta;
        $_data["ok"] = true;
        $data['response'] = $_data;
        $this->response($data, 200);
    }

    // funcion para actualizar una incidencia 
    public function update_post()
    {
        $IDIncidencia = $this->input->post("Incidencia");
        $Descripcion = $this->input->post("Descripcion");
        $Imagenes = $this->input->post("Imagenes");
        $Asunto = $this->input->post("Asunto");
        $token = $this->input->post("Token");

        $session_data = $this->session->userdata('logged_in');
        if ($session_data['Token'] !== $token) {
            $_data["msj"] = "sin token";
            $_data["ok"] = false;
            $data['response'] = $_data;
            return $this->response($data, 404);
        }

        // cambio el status de una incidencia
        $respuesta = $this->Model_incidencia->update($IDIncidencia, $Asunto, $Descripcion, $Imagenes);
        $_data["data"] =  $respuesta;
        $_data["ok"] = true;
        $data['response'] = $_data;
        $this->response($data, 200);
    }


    // funcion para asigarnar una incidencia a un usuario
    public function asignar_post(){
        $token = $this->input->post("Token");
        $IDIncidencia = $this->input->post("Incidencia");
        $IDUsuario = $this->input->post("Usuario");
        $session_data = $this->session->userdata('logged_in');
        if ($session_data['Token'] !== $token) {
            $_data["msj"] = "sin token";
            $_data["ok"] = false;
            $data['response'] = $_data;
            return $this->response($data, 404);
        }

        // asigno la incidencia al usuario que me manden
        $respuesta = $this->Model_incidencia->asing($IDIncidencia,$IDUsuario);
        $_data["data"] =  $respuesta;
        $_data["ok"] = true;
        $data['response'] = $_data;
        $this->response($data, 200);

    }
}