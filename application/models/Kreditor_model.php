<?php

class Kreditor_model extends CI_Model
{
    public function getKreditor($id_kreditor = null)
    {
        if ($id_kreditor === null) {
            //result_array() -> array associative
            $this->db->select('*');
            $this->db->from('kreditor');
            $this->db->join('desa', 'desa.id = kreditor.desa_id');
            return $this->db->get()->result_array();
        } else {
            $this->db->select('*');
            $this->db->from('kreditor');
            $this->db->join('desa', 'desa.id = kreditor.desa_id');
            $this->db->where('kreditor.id_kreditor', $id_kreditor);
            return $this->db->get()->result();
        }
    }

    public function updateKreditor($data, $id)
    {
        $this->db->update("kreditor", $data, ["id_kreditor" => $id]);
        return $this->db->affected_rows();
    }

    public function updatePassword($passwordBaru, $id)
    {
        $this->db->update("kreditor", $passwordBaru, ["id_kreditor" => $id]);
        return $this->db->affected_rows();
    }

    public function getPasswordById($id)
    {
        $this->db->select("password");
        $this->db->from("kreditor");
        $this->db->where("kreditor.id_kreditor", $id);
        $query = $this->db->get()->row_array();
        // var_dump($query);
        return $query;
    }

    public function getDataByPhone($nomorHp)
    {
        $this->db->select("id_kreditor");
        $this->db->select("password");
        $this->db->select("nama_kreditor");
        $this->db->from("kreditor");
        $this->db->where("kreditor.nomor_hp", $nomorHp);
        $query = $this->db->get()->row_array();
        return $query;
    }
}
