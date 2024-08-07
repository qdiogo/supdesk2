<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller

{
    public

    function __construct()
    {
        parent::__construct();
        $this->load->model('inicio/Login_model');
        $login_status = $this->session->userdata('login');
        if ($login_status != TRUE) {
            redirect('inicio');
        }
    }

    function index()
    {
        $dados['titulo'] = "Painel de Controle";
        $dados['pg_header'] = "Painel de Controle";
        $dados['usuario'] = $this->Login_model->dados_usuario($this->session->userdata('uid'));
        $this->load->view('painel/index', $dados);
    }
}

