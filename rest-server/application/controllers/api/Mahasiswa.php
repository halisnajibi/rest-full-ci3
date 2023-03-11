<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Mahasiswa extends RestController
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // limit
        $this->methods['index_get']['limit'] = 100;
    }
    // mendapatkan data
    public function index_get()
    {
        $id = $this->get('id');
        // cek apakah client meminta id
        if ($id === null) {
            // kirim semua data
            $data = $this->M_mhs->getMahasiswa();
        } else {
            // kirim sesuai id data
            $data = $this->M_mhs->getMahasiswa($id);
        }

        // mengembalikan dara ke client 
        if ($data) {
            $this->response([
                'status' => true,
                'result' => $data
            ], RESTController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ada'
            ], RESTController::HTTP_NOT_FOUND);
        }
    }
    // menghapus data
    public function index_delete()
    {
        $id = $this->delete('id');
        // cek apakah client mengirim id
        if ($id == null) {
            $this->response([
                'status' => false,
                'message' => 'masukan id nya'
            ], RESTController::HTTP_BAD_REQUEST);
        } else {
            // cek apakah id yg dkirim client ada di db
            if ($this->M_mhs->deleteMhs($id) > 0) {
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'berhasil di hapus'
                ], RESTController::HTTP_OK);
            } else {
                // id tidak ada
                $this->response([
                    'status' => false,
                    'message' => 'id tidak ada'
                ], RESTController::HTTP_NOT_FOUND);
            }
        }
    }

    // tambah data
    public function index_post()
    {
        // DATA YANG MASUK KESINI HARUS BERSIH!!VALIDASI DI CLIENT
        $data = [
            'nrp' => $this->post('nrp'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan')
        ];
        if ($this->M_mhs->insertMhs($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'berhasil menambahkan data'
            ], RESTController::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'gagal menambahkan data'
            ], RESTController::HTTP_BAD_REQUEST);
        }
    }

    // update data
    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'nrp' => $this->put('nrp'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan')
        ];
        if ($id != null) {
            if ($this->M_mhs->updateMhs($data, $id) > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'berhasil update data'
                ], RESTController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'gagal update data'
                ], RESTController::HTTP_NOT_MODIFIED);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'id tidak ada'
            ], RESTController::HTTP_NOT_FOUND);
        }
    }

     // mendapatkan pencarian data 
     public function cari_get()
     {
        $q = $this->input->get('q');
         // cek apakah client meminta q 
         if ($q === null) {
             $data = null;
         } else {
             // kirim sesuai pencarian data
             $data = $this->M_mhs->getCariMahasiswa($q);
         }
 
         // mengembalikan dara ke client 
         if ($data) {
             $this->response([
                 'status' => true,
                 'result' => $data
             ], RESTController::HTTP_OK);
         } else {
             $this->response([
                 'status' => false,
                 'message' => 'data tidak ada'
             ], RESTController::HTTP_NOT_FOUND);
         }
     }
}
