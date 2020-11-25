<? if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model_usuarios extends CI_Model{
      
  public function add($Correo,$Nombre,$Foto,$rol){
    $array = [
      "Correo" => $Correo,
      "Nombre" => $Nombre,
      "Foto"   => $Foto,
      "Rol"    => $rol
    ];
  
    $sql = $this->db->insert('usuarios',$array);

    return $this->db->insert_id();
      
  }
  public function ultimoacceso($IDusuario){
    $array= ["IDUsuario"=>$IDusuario];
    $sql = $this->db->insert('Accesos',$array);
  }
  public function validar_correo($Correo){
    $sql = $this->db->select('*')->where("Correo='$Correo'")->get('usuarios');
    if($sql->num_rows() === 0){
      return false;
    }else{
      return $sql->row_array();
    }
  }

  // funcion para obtener los usuarios que son administradores y superAdministradores
  public function getAdmin($rol){
    $sql = $this->db->select('IDUsuario,Nombre,Correo')->where("Rol='$rol'")->get('usuarios');
    return $sql->result_array();
  }



}