<?php
class M_mhs extends CI_Model
{
    public function getMahasiswa($id = null)
    {
        if ($id === null) {
            return $this->db->get('mahasiswa')->result_array();
        } else {
            return $this->db->get_where('mahasiswa', ['id' => $id])->row_array();
        }
    }
    public function deleteMhs($id)
    {
        $this->db->delete('mahasiswa', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function insertMhs($data)
    {
        $this->db->insert('mahasiswa', $data);
        return $this->db->affected_rows();
    }

    public function updateMhs($data,$id)
    {
        $this->db->update('mahasiswa',$data,['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getCariMahasiswa($cari)
    {
        $this->db->like('nama', $cari);
        $query = $this->db->get('mahasiswa');
        return $query->result();
    }
}
