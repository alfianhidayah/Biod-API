<?php

/**
 * 
 */
class Auth_model extends CI_Model
{

    private $table_kreditor = "kreditor";

    function get_user($id_kreditor)
    {
        $this->db->where('id_kreditor', $id_kreditor);
        // $this->db->where('password', $password);
        return $this->db->get($this->table_kreditor)->row_array();
    }
}
