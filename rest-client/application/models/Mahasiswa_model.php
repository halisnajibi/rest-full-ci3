<?php 
use GuzzleHttp\Client;
class Mahasiswa_model extends CI_model {
    private $_client;
    public function __construct()
    {
        $this->_client= new Client([
            'base_uri' => 'http://localhost:8080/rest-api/rest-server/api/',
            'auth' => ['admin','1234']
        ]);
    }
    public function getAllMahasiswa()
    {
        // return $this->db->get('mahasiswa')->result_array();
        $response = $this->_client->request('GET','mahasiswa',[
            'query' => [
                'apiKey' => 'belajar'
            ]
        ]);
        $result = json_decode($response->getBody()->getContents(),true);
        return $result['result'];
    }

    public function getMahasiswaById($id)
    {
        // return $this->db->get_where('mahasiswa', ['id' => $id])->row_array();
        $response = $this->_client->request('GET','mahasiswa',[
            'query' => [
                'apiKey' => 'belajar',
                'id' => $id
            ]
        ]);
        $result = json_decode($response->getBody()->getContents(),true);
        return $result['result'];
    }

    public function tambahDataMahasiswa()
    {
        $data = [
            "nama" => $this->input->post('nama', true),
            "nrp" => $this->input->post('nrp', true),
            "email" => $this->input->post('email', true),
            "jurusan" => $this->input->post('jurusan', true),
            'apiKey' => 'belajar'
        ];

        // $this->db->insert('mahasiswa', $data);
        $response = $this->_client->request('post','mahasiswa',[
            'form_params' => $data
        ]);
        $result = json_decode($response->getBody()->getContents(),true);
        return $result['result'];
    }

    public function hapusDataMahasiswa($id)
    {
        // $this->db->where('id', $id);
        // $this->db->delete('mahasiswa', ['id' => $id]);/
        $response = $this->_client->request('delete','mahasiswa',[
            'form_params' => [
                'id' => $id,
                'apiKey' => 'belajar'
            ]
        ]);
        $result = json_decode($response->getBody()->getContents(),true);
        return $result;
    }

   

    public function ubahDataMahasiswa()
    {
        $data = [
            "nama" => $this->input->post('nama', true),
            "nrp" => $this->input->post('nrp', true),
            "email" => $this->input->post('email', true),
            "jurusan" => $this->input->post('jurusan', true),
            "id" => $this->input->post('id',true),
            'apiKey' => 'belajar'
        ];
        $response = $this->_client->request('PUT','mahasiswa',[
            'form_params' => $data
        ]);
        $result = json_decode($response->getBody()->getContents(),true);
        return $result['result'];
    }

    public function cariDataMahasiswa()
    {
        $keyword = $this->input->post('keyword', true);
        $this->db->like('nama', $keyword);
        $this->db->or_like('jurusan', $keyword);
        $this->db->or_like('nrp', $keyword);
        $this->db->or_like('email', $keyword);
        return $this->db->get('mahasiswa')->result_array();
    }
}