<?php
header('Access-Control-Allow-Origin: *');
require_once(APPPATH . '/libraries/REST_Controller.php');
use Restserver\libraries\REST_Controller;


defined('BASEPATH') or exit('No direct script access allowed');

class Comentarios extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->model('Model_usuarios');
        $this->load->model('Model_incidencia');
        $this->load->model('Model_comentario');
    }

    public function add_post(){
        $Token = $this->input->post("Token");
        $comentario = $this->input->post("Comentario");
        $IDIncidencia = $this->input->post("Incidencia");

        $session_data = $this->session->userdata('logged_in');
        if ($session_data['Token'] !== $Token) {
            $_data["msj"] = "sin token";
            $_data["ok"] = false;
            $data['response'] = $_data;
            return $this->response($data, 404);
        }

        $this->Model_comentario->add($IDIncidencia, $session_data['IDUsuario'],$comentario);
        
        $_data["comentarios"] =  $this->Model_comentario->getAll($IDIncidencia);
        $_data["ok"] = true;
        $data['response'] = $_data;
        
        return $this->response($data, 200);

    }
}