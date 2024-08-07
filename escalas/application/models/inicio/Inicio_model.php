<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inicio_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_admin()
    {
        $email = "admin@admin.com";
        if ($this->db->get_where('user', array('email' => $email))->row_array()) {
            return TRUE;
        } else {

            $parametros = array('id' => 'default',
                'nome' => 'admin',
                'email' => 'admin@admin.com',
                'senha' => md5('@admin'),
                'cpf' => '000',
                'crm' => '000',
                'dt_nascimento' => date('Y-m-d'),
                'tipo' => '0',
                'status' => '1',
            );
            $this->db->insert('user', $parametros);
        }

    }
} ?>