<?php

class Transaksiadmin_model extends CI_Model
{

    public function tambahTransaksi($data)
    {
        $this->db->insert('transaksi', $data);

        return $this->db->affected_rows();
    }

    public function getBarangId($id_barang, $id_kreditor)
    {
        $this->db->select("id_barang");
        $this->db->from("barang");
        $this->db->where("barang.id_barang", $id_barang);
        $this->db->where("barang.id_kreditor", $id_kreditor);
        $query = $this->db->get()->row_array();
        // var_dump($query);
        return $query;
    }

    public function updateTransaksi($data, $id_transaksi)
    {
        $this->db->update("transaksi", $data, ["id_transaksi" => $id_transaksi]);
        return $this->db->affected_rows();
    }
}
