<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lista extends CI_Controller

{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('usuario/Lista_model');
        $this->load->model('inicio/Login_model');
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
        $dados['titulo'] = "Usuários";
        $dados['pg_header'] = "Usuários do Sistema";
        $dados['_view'] = 'painel/usuario/lista';
        $dados['tb_user'] = $this->Lista_model->tabela('user');
        $dados['usuario'] = $this->Login_model->dados_usuario($this->session->userdata('uid'));
        $this->load->view('painel/index', $dados);
    }
}

