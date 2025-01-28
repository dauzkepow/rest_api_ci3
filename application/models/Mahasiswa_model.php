<?php

class Mahasiswa_model extends CI_Model
{
    //GET semua data
    public function getMahasiswa($id = null)
    {
        if ($id === null) //jika tidak ada id-nya
        {
            return $this->db->get('mahasiswa')->result_array(); //select * from mahasiswa
        } else {
            //jika ada id-nya
            return $this->db->get_where('mahasiswa', ['id' => $id])->result_array(); //select id from mahasiswa
        }
        
    }

    //DELETE data
    public function deleteMahasiswa($id)
    {
        $this->db->delete('mahasiswa', ['id' => $id]); //delete mahasiswa sesuai id-nya
        return $this->db->affected_rows(); 
    }

    //Method POST data
    //pastikan data sudah urut sesuai field sesuai tabel
    public function createMahasiswa($data)
    {
        $this->db->insert('mahasiswa', $data);
        return $this->db->affected_rows();
    }

    //Method PUT Data
    public function updateMahasiswa($data, $id)
    {
        $this->db->update('mahasiswa', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}