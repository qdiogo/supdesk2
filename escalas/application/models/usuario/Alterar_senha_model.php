<?php

class Alterar_senha_model extends CI_Model

{
    function __construct()
    {
        parent::__construct();
    }

    // Select + Where

    function selec_usuario($tabela, $id)
    {
        return $this->db->get_where($tabela, array(
            'id' => $id
        ))->row_array();
    }
    
    // Update

    function update_senha($tabela, $id, $parametros)
    {
        $dados = $this->db->get_where($tabela, array(
            'id' => $id
        ))->row_array();

        if ($dados['senha'] != $parametros['senha_a']) {
            return array(
                'tipo' => 'alert alert-danger',
                'msg' => 'Erro senha atual invalida!'
            );
        } else {
            unset($parametros['senha_a']);
            $this->db->where('id', $id);
            $this->db->update($tabela, $parametros);
            return array(
                'tipo' => 'alert alert-success',
                'msg' => 'Dados do usuário alterados com sucesso!'
            );
        }
    }
}