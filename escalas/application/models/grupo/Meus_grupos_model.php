<?php

class Meus_grupos_model extends CI_Model

{
    function __construct()
    {
        parent::__construct();
    }

    // Select All

    function tabela($user)
    {
        $this->db->select('*');
        $this->db->from('user_grupo');
        $this->db->join('grupo', 'user_grupo.id_grupo = grupo.id');
        $this->db->where(['user_grupo.id_user' => $user]);
        return $this->db->get()->result_array();
    }
}
