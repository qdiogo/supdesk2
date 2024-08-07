<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function verifica_login($email, $pwd)
    {
        $this->db->where('email', $email);
        $this->db->where('senha', md5($pwd));
        $query = $this->db->get('user');
        return $query->result();
    }

    function dados_usuario($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('user');
        return $query->result();
    }
} ?>