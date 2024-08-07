<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lista extends CI_Controller

{
    function __construct()
    {
        parent::__construct();
        $this->load->model('grupo/Lista_model');
        $this->load->model('inicio/Login_model');
        $login_status = $this->session->userdata('login');
        if ($login_status != TRUE) {
            redirect('inicio');
        }

        // $user = $this->Login_model->dados_usuario($this->session->userdata('uid'));
        // if ($user[0]->tipo == 1) {
        //     redirect('painel_controle');

        //}


    }

    public

    function index()
    {
        $user = $this->Login_model->dados_usuario($this->session->userdata('uid'));
        $dados['titulo'] = "Grupos";
        $dados['pg_header'] = "Grupos";
        $dados['_view'] = 'painel/grupo/lista';
        $dados['tb_grupo'] = $this->Lista_model->tabela($user[0]->id);
        $dados['usuario'] = $this->Login_model->dados_usuario($this->session->userdata('uid'));
        $this->load->view('painel/index', $dados);
    }

    public function entrar($grupo_id){

        $dados['titulo'] = "Grupos";
        $dados['pg_header'] = "Grupos";
        $dados['_view'] = 'painel/grupo/lista_user';
        $dados['tb_user'] = $this->Lista_model->tabela_usuarios($grupo_id);
        $dados['usuario'] = $this->Login_model->dados_usuario($this->session->userdata('uid'));
        $this->load->view('painel/index', $dados);

    }

    
}
