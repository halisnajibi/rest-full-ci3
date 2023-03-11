<?php 
class M_auth extends CI_Model{
    public function register()
    {
        $data = [
            'nama' => $this->input->post('nama',true),
            'email' => $this->input->post('email',true),
            'password' => password_hash($this->input->post('pw',true),PASSWORD_DEFAULT),
            'status' => 0,
            'date_created' => time()
        ];
        $this->db->insert('user',$data);
    }

    public function insertKey($id,$key)
    {
        $data = [
            'user_id' => $id,
            'key' => $key,
            'level' => 1,
            'ignore_limits' => '',
            'is_private_key' => '',
            'ip_addresses' => '',
            'date_created' => time()
        ];
        $this->db->insert('keys',$data);
    }

    public function login()
    {
        return $this->db->get_where('user',['email' => $this->input->post('email')])->row_array();
    }
}
?>