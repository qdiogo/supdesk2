<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alterar_senha extends CI_Controller

{
    function __construct()
    {
        parent::__construct();
        $this->load->model('usuario/Alterar_senha_model');
        $this->load->model('inicio/Login_model');
        $this->load->library('auxiliar');
        $login_status = $this->session->userdata('login');
        if ($login_status != TRUE) {
            redirect('inicio');
        }
    }

    public

    function usuario($user_id)
    {
        $log_user_id = $this->session->userdata('uid');
        if ($log_user_id = !$user_id) {
            redirect('painel_controle');
        }


        // Regras de validação do Formulario de registro de usuário

        $this->form_validation->set_rules('senha_a', 'Antiga', 'trim|required');
        $this->form_validation->set_rules('senha_n', 'Nova', 'trim|required|min_length[6]|matches[senha_c]');
        $this->form_validation->set_rules('senha_c', 'Confirma', 'trim|required|min_length[6]');
        if ($this->form_validation->run() == FALSE) {
            $dados['form_erro'] = validation_errors();
        } else {
            $dados['parametros'] = array(
                'senha' => md5($this->input->post('senha_n')),
                'senha_a' => md5($this->input->post('senha_a')),
                'status' => 1,
            );

            // Retorno de informação do banco

            $dados['msg_banco'] = $this->Alterar_senha_model->update_senha('user', $user_id, $dados['parametros']);
        }

        $dados['titulo'] = "Alterar Senha";
        $dados['pg_header'] = "Alterar Senha";
        $dados['_view'] = 'painel/usuario/alterar_senha';
        $dados['tb_user'] = $this->Alterar_senha_model->selec_usuario('user', $user_id);
        $dados['usuario'] = $this->Login_model->dados_usuario($this->session->userdata('uid'));
        $this->load->view('painel/index', $dados);
    }

}