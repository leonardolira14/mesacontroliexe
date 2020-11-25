<?php
header('Access-Control-Allow-Origin: *');
require_once(APPPATH . '/libraries/REST_Controller.php');
use Restserver\libraries\REST_Controller;


defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->model('Model_usuarios');
    }



        public function login_post(){
        $correo = $this->input->post("correo");
        $foto = $this->input->post("foto");
        $nombre = $this->input->post("nombre");
        
        // valido si el usuario existe 
        $data_user = $this->Model_usuarios->validar_correo($correo);
        
        if(!$data_user){
            // si no esta lo agrego
            $this->Model_usuarios->add($correo,$nombre,$foto,'usuario');
            
        }
        $data_user = $this->Model_usuarios->validar_correo($correo);
        
        // agrego el acceso
        $this->Model_usuarios->ultimoacceso($data_user['IDUsuario']);
         // genero un token para mandarlo an fronend

        $token = md5($data_user['Correo']. $data_user['Nombre'].date('h:i:s'));
        $session_data = array(
            'Correo'   => $data_user['Correo'],
            'Token'    => $token,
            'rol'      => $data_user['Rol'],
            'IDUsuario'=> $data_user['IDUsuario']
        );
       
        $this->session->set_userdata('logged_in', $session_data);
            $data['response'] = $token;
           return  $this->response($data,200);
        }
        
        public function getUserAdmin_post(){
            $token = $this->input->post("Token");
            $session_data = $this->session->userdata('logged_in');
            if ($session_data['Token'] !== $token) {
                $_data["msj"] = "sin token";
                $_data["ok"] = false;
                $data['response'] = $_data;
                return $this->response($data, 404);
            }

            // ahora obtengo los usuarios
            $_data['Admin'] = $this->Model_usuarios->getAdmin('admin');
            $_data['superAdmin'] = $this->Model_usuarios->getAdmin('superadmin');
            $_data["ok"] = true;
            $data['response'] = $_data;
            return $this->response($data, 200);

        }
}
