<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meus_grupos extends CI_Controller

{
    function __construct()
    {
        parent::__construct();
        $this->load->model('grupo/Meus_grupos_model');
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

    public function index()
    {
        $dados['titulo'] = "Meus Grupos";
        $dados['pg_header'] = "Meus Grupos";
        $dados['_view'] = 'painel/grupo/meus_grupos';
        $dados['tb_grupo'] = $this->Meus_grupos_model->tabela($this->session->userdata('uid'));
        $dados['usuario'] = $this->Login_model->dados_usuario($this->session->userdata('uid'));
        $this->load->view('painel/index', $dados);
    }

    
}

