<? if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model_incidencia extends CI_Model{
    public function add(){

    }
    public function getAll($IDUsuario){
         $sql=$this->db->select('*')->where("IDUsuario='$IDUsuario'")->get('incidencias');
        return $sql->result_array();
    }
    public function getData($IDIncidencia){
        $sql=$this->db->select('*')->where("IDIncidencia='$IDIncidencia'")->get('incidencias');
        return $sql->row_array();
    }
    public function getDataDetalle($IDIncidencia){
        $sql=$this->db->select('*')->where("IDIncidencia='$IDIncidencia'")->get('');
        return $sql->row_array();
    }
    public function updatestatus($IDIncidencia, $status){
        $array=array("Status"=>$status,"FechaCierre"=>date('Y-m-d h:i:s'));
        
        $sql=$this->db->where("IDIncidencia='$IDIncidencia'")->update('incidencias',$array);
        return $sql;
    }

    public function update($IDIncidencia,$Asunto,$Descripcion,$Imagenes){
        $array = array("Asunto"=>$Asunto);
        $this->db->where("IDIncidencia='$IDIncidencia'")->update('incidencias',$array);
        // ahora modifico los detalles
        $array=array("Descripcion"=>$Descripcion,"Imagenes"=>$Imagenes);
        return $this->db->where("IDIncidencia='$IDIncidencia'")->update('detalleincidencia',$array);
    }

    public function asing($IDIncidencia,$IDUsuario){
        $array = array('IDUsuarioAsgin'=>$IDUsuario);
        return $this->db->where("IDIncidencia='$IDIncidencia'")->update('incidencias',$array);
    }
}