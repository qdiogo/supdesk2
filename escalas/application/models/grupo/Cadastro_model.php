<?php

class Cadastro_model extends CI_Model

{
    function __construct()
    {
        parent::__construct();
    }

    // Insert

    function ins_grupo($tabela, $parametros)
    {
        $msg = array();

        // Verifica se nome já existe no banco

        if ($this->db->get_where($tabela, array(
            'nome' => $parametros['nome']
        ))->row_array()) {
            array_push($msg, '<div class="alert alert-danger" role="alert">Já existe um grupo com este Nome!</div>');
        }

        if (count($msg) == 0) {
            $this->db->insert($tabela, $parametros);
            $resp = $this->db->insert_id();
            array_push($msg, '<div class="alert alert-success" role="alert">Grupo registrado com sucesso!</div>');
            array_push($msg, $resp);
            return $msg;
        } else
            return $msg;
    }

    function select_admin(){
        $this->db->select(array('id', 'nome', 'tipo'));
        $this->db->from('user');
        $this->db->where('tipo', '2');
        return $this->db->get()->result_array();

    }

    function ins_user_grupo($tabela, $parametros){
        return $this->db->insert($tabela, $parametros);

    }
}

 
 


