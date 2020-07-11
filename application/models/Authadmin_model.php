<?php

/**
 * 
 */
class Authadmin_model extends CI_Model
{

    private $table_kreditor = "user_admin";

    function get_user($username, $password)
    {
        $this->db->select("id");
        $this->db->select("username");
        $this->db->select("password");
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        return $this->db->get($this->table_kreditor)->row();
    }
}
