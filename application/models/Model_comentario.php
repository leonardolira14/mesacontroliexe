<? if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model_comentario extends CI_Model{
  
    public function getAll($IDIncidencia){
         $sql=$this->db->select('Nombre,Fecha,Comentario')
                        ->join('usuarios','Usuarios.IDUsuario = comentarios.IDUsuario')
                       ->where("IDIncidencia='$IDIncidencia'")
                       ->from('comentarios')->get();
        return $sql->result_array();
    }

    public function add($IDIncidencia,$IDUsuario,$Comentario){
        $array = [
            "IDIncidencia" => $IDIncidencia,
            "IDUsuario"    => $IDUsuario,
            "Comentario"   => $Comentario,
        ];
        $this->db->insert('comentarios',$array);
    }
  
}