<?php

/**
 * 
 */
class Scanner_model extends CI_Model
{

    private $table_barang = "barang";
    private $table_kreditor = "kreditor";

    function get_kreditor($id_kreditor)
    {
        $this->db->select("id_kreditor");
        $this->db->select("nama_kreditor");
        $this->db->where('id_kreditor', $id_kreditor);
        return $this->db->get($this->table_kreditor)->row();
    }

    function get_barang($id_kreditor)
    {
        $this->db->select("id_barang");
        $this->db->select("nama_barang");
        $this->db->where('id_kreditor', $id_kreditor);
        $this->db->where('status_id', 1);
        return $this->db->get($this->table_barang)->result();
    }

    public function getIdTransaksi()
    {
        $this->db->select('RIGHT(transaksi.id_transaksi,4) as idtransaksi', FALSE);
        $this->db->order_by('id_transaksi', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get('transaksi');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->idtransaksi) + 1;
        } else {
            $kode = 1;
        }

        $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kodejadi = "TRS" . $kodemax;

        return $kodejadi;
    }
}
