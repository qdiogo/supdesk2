<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cadastro extends CI_Controller

{
    function __construct()
    {
        parent::__construct();
        $this->load->model('grupo/Cadastro_model');
        $this->load->model('inicio/Login_model');
        $this->load->library('auxiliar');
        $login_status = $this->session->userdata('login');
        if ($login_status != TRUE) {
            redirect('inicio');
        }

        $user = $this->Login_model->dados_usuario($this->session->userdata('uid'));
        if ($user[0]->tipo == 1) {
            redirect('painel_controle');
        }
    }

    public

    function index()
    {
        $dados['user_admin'] = $this->Cadastro_model->select_admin();
        $dados['titulo'] = "Cadastro";
        $dados['pg_header'] = "Cadastrar Grupo";
        $dados['_view'] = 'painel/grupo/cadastro';
        $dados['usuario'] = $this->Login_model->dados_usuario($this->session->userdata('uid'));
        $this->load->view('painel/index', $dados);
        
    }

    public

    function novo()
    {

        // Regras de validação do Formulario de registro de grupo

        $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
        $this->form_validation->set_rules('admin', 'Nome', 'trim|required');
        $this->form_validation->set_rules('visualizar', 'Visualizar', 'trim|required');

        // Caso as informações do formulario estejam corretas organiza e faz insert no banco.

        if ($this->form_validation->run() == FALSE) {
            $dados['form_erro'] = validation_errors();
        } else {
            $dados['parametros'] = [
                'id' => 'default',
                'nome' => $this->input->post('nome'),
                'id_user_admin' => $this->input->post('admin'),
                'visualizar' => $this->input->post('visualizar'),

                // Status  / 0 - inativo / 1 - ativo
                'status' => 1,
            ];
            
            //Faz include do admin dentro do grupo criado
            $dados['msg_banco'] = $this->Cadastro_model->ins_grupo('grupo', $dados['parametros']);
            $admin = [
                'id_user' => $this->input->post('admin'),
                'id_grupo' => $dados['msg_banco'][1],

                // Status  / 0 - inativo / 1 - ativo
                'user_status' => '1',
            ];

            $this->Cadastro_model->ins_user_grupo('user_grupo', $admin);


        }
        $dados['user_admin'] = $this->Cadastro_model->select_admin();
        $dados['titulo'] = "Cadastro";
        $dados['pg_header'] = "Cadastrar Grupo";
        $dados['_view'] = 'painel/grupo/cadastro';
        $dados['usuario'] = $this->Login_model->dados_usuario($this->session->userdata('uid'));
        $dados['txt_grupo'] = $this->input->post('txt_grupo');
        $this->load->view('painel/index', $dados);
    }
}
