<?php

class Lista_model extends CI_Model

{
    function __construct()
    {
        parent::__construct();
    }

    // Select All

    function tabela($user_id)
    {
        $this->db->select(['user.nome admin', 'grupo.id', 'grupo.status', 'grupo.nome grupo']);
        $this->db->from('user');
        $this->db->join('grupo', 'user.id = grupo.id_user_admin');
        $result = $this->db->get()->result_array();
        for ($i=0; $i < count($result) ; $i++) { 
            $ts = $this->consulta_grupo($user_id,$result[$i]['id']);
            if ($ts) {
                $result[$i] = $result[$i] + ['pertence' => '1'];
            } else {
                $result[$i] = $result[$i] + ['pertence' => '0'];
            }
        }
        return  $result;

    }

    function consulta_grupo($user_id,$grupo_id){
        $this->db->select('*');
        $this->db->from('user_grupo');
        $this->db->where(array('id_user' => $user_id, 'id_grupo' => $grupo_id));
        return $this->db->get()->result_array();
    }

    function tabela_usuarios($grupo_id){
        $this->db->select(['user.nome', 'user_grupo.id_grupo', 'user_grupo.user_status']);
        $this->db->from('user');
        $this->db->join('user_grupo', 'user.id = user_grupo.id_user ');
        $this->db->where('id_grupo', $grupo_id);
        //$this->db->group_by('id_grupo');
        $result = $this->db->get()->result_array();
        print_r($result);   
        return $result;
    }

    
}
