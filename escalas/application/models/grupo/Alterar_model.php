<?php

class Alterar_model extends CI_Model

{
    function __construct()
    {
        parent::__construct();
    }

    function selec_grupo($tabela, $id)
    {
        return $this->db->get_where($tabela, array('id' => $id))->row_array();
    }


    function update_grupo($tabela, $id, $parametros)
    {
        $consulta = $this->db->get_where($tabela, array('id' => $id))->row_array();
        $msg = array();

        // Verifica duplicidade no banco
        if ($consulta['nome'] != $parametros['nome']) {
            if ($this->db->get_where($tabela, array('nome' => $parametros['nome']))->row_array()) {
                array_push($msg, '<div class="alert alert-danger" role="alert">Já existe um Grupo com este nome!</div>');
            }
        }
        if (count($msg) == 0) {
            $this->db->where('id', $id);
            $this->db->update($tabela, $parametros);
            array_push($msg, '<div class="alert alert-success" role="alert">Dados alterados com sucesso!!!</div>');
            return $msg;
        } else {
            return $msg;
        }
    }

    function select_admin(){
        $this->db->select(array('id', 'nome', 'tipo'));
        $this->db->from('user');
        $this->db->where('tipo', '2');
        return $this->db->get()->result_array();

    }

}