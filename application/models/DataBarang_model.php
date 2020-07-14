<?php

/**
 * 
 */
class DataBarang_model extends CI_Model
{

    private $table_barang = "barang";

    function get_barang($id_kreditor)
    {
        $this->db->select("id_barang");
        $this->db->select("nama_barang");
        $this->db->where('id_kreditor', $id_kreditor);
        $this->db->where('status_id', 1);
        return $this->db->get($this->table_barang)->result();
    }
}
