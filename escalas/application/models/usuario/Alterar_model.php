<?php

class Alterar_model  extends CI_Model

{
    function __construct()
    {
        parent::__construct();
    }

    // Seleciona registro

    function selec_usuario($tabela, $id)
    {
        return $this->db->get_where($tabela, array(
            'id' => $id
        ))->row_array();
    }

    // Atualisa dados da tabela

    function update_usuario($tabela, $id, $parametros)
    {
        $consulta = $this->db->get_where($tabela, array(
            'id' => $id
        ))->row_array();

        $msg = array();

        // Verifica duplicidade no banco
        if ($consulta['email'] != $parametros['email']) {
            if ($this->db->get_where($tabela, array('email' => $parametros['email']))->row_array()) {
                array_push($msg, '<div class="alert alert-danger" role="alert">Já existe um usuário com este Email!</div>');
            }
        }
        if ($consulta['cpf'] != $parametros['cpf']) {
            if ($this->db->get_where($tabela, array('cpf' => $parametros['cpf']))->row_array()) {
                array_push($msg, '<div class="alert alert-danger" role="alert">Já existe um usuário com este CPF!</div>');
            }
        }
        if ($consulta['crm'] != $parametros['crm']) {
            if ($this->db->get_where($tabela, array('crm' => $parametros['crm']))->row_array()) {
                array_push($msg, '<div class="alert alert-danger" role="alert">Já existe um usuário com este CRM!</div>');
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
}