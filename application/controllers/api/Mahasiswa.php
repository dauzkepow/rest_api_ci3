<?php
//konek ke kontrollersnya

//use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Mahasiswa extends REST_Controller
{
    //panggil Mahasiswa_model
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model', 'M_mahasiswa');
    }

    //GET data
    public function index_get()
    {
        //cek GET ada idnya tidak di paramsnya
        $id = $this->get('id');
        if ($id === null) {
            //jika id kosong, tampilkan semua data
            $mahasiswa = $this->M_mahasiswa->getMahasiswa(); //ambil data dari model
            //var_dump($mahasiswa); //test jadi array asosiatif
        } else {
            //jika ada id-nya, tampilkan data sesuai id-nya
            $mahasiswa = $this->M_mahasiswa->getMahasiswa($id);
        }
        
        if ($mahasiswa) 
        {
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $mahasiswa
            ], REST_Controller::HTTP_OK); //status code 200
        } else {
            $this->response
            (
                [
                    'status' => false,
                    'message' => 'id not found'
                ], 
                REST_Controller::HTTP_NOT_FOUND //status code 404 not found
            );
        }

        //test POSTMAN
        //GET
        //endpoint api
        //Params
        //KEY = id
        //VALUE = 1
    }

    //DELETE Data
    public function index_delete()
    {
        $id = $this->delete('id');
        if ($id === null) { //jika tidak ada id
            $this->response
            (
                [
                    'status' => false,
                    'message' => 'provide an id!'
                ], 
                REST_Controller::HTTP_BAD_REQUEST //status code 400 bad request
            );
        } else {
            //jika ada id, id-nya ada di database tidak
            if ($this->M_mahasiswa->deleteMahasiswa($id) > 0) {
                //ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'data terhapus'
                ], 
                //REST_Controller::HTTP_NO_CONTENT
                REST_Controller::HTTP_OK
                );
            } else {
                $this->response([ 
                    'status' => false,
                    'message' => 'id not found!'
                ], REST_Controller::HTTP_BAD_REQUEST); //status code 400 bad request
            }
            
        }
    }
    /* 
    - tes dengan postman
    - DELETE
    - masukkan endpoint api
    - Body
    - x-www-form-urlendoced
    - KEY = id
    - VALUE = 1
    */


    //POST DATA
    /*
    - data harus valid
    - validasi di aplikasi client
    */

    public function index_post()
    {
        $data = [
            //sesuaikan kolom dalam tabel
            'nrp' => $this->post('nrp'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan')  
        ];

        if ($this->M_mahasiswa->createMahasiswa($data) > 0) {
            $this->response([ 
                'status' => true,
                'message' => 'new mahasiswa has been created.'
            ], REST_Controller::HTTP_CREATED); //201
        } else {
            $this->response([ 
                'status' => false,
                'message' => 'failed to create new data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        
    }
    /* 
    - tes dengan postman
    - POST
    - masukkan endpoint api
    - Body
    - x-www-form-urlendoced
    - KEY       |   VALUE
    - nrp       | 04340067
    - nama      | Test Input
    - email     | tes@gmail.com
    - jurusan   | AI Engineer

    pastikan berhasil
    */

    //PUT data
    public function index_put()
    {
        //bedakan id agar masuk ke where
        $id = $this->put('id');
        $data = [
            //sesuaikan kolom dalam tabel
            'nrp' => $this->put('nrp'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan')  
        ];

        if ($this->M_mahasiswa->updateMahasiswa($data, $id) > 0) {
            $this->response([ 
                'status' => true,
                'message' => 'data mahasiswa has been updated.'
            ], REST_Controller::HTTP_OK); //200
        } else {
            $this->response([ 
                'status' => false,
                'message' => 'failed to update data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    /* 
    - tes dengan postman
    - PUT
    - masukkan endpoint api
    - Body
    - x-www-form-urlendoced
    - KEY       |   VALUE
    - nrp       | 04340067
    - nama      | Ganti Nama
    - email     | tes@gmail.com
    - jurusan   | AI Engineer
    - id        | sesuaikan id-nya di tabel

    pastikan berhasil
    */
}