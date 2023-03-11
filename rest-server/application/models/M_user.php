<?php 
class M_user extends CI_Model{
    public function getProfiel($email)
    {
        return $this->db->get_Where('user',['email' => $email])->row_array();
    }
    public function getKunci($id)
    {
        return $this->db->get_Where('keys',['user_id' => $id])->row_array();
    }
}
?>