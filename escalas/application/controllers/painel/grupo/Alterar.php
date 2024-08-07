<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alterar extends CI_Controller

{
    function __construct() {

        parent::__construct();
        $this->load->model('grupo/Alterar_model');
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

    public function index($grupo_id) {

        $dados['titulo'] = "Alterar";
        $dados['pg_header'] = "Editar Informações do Grupo";
        $dados['_view'] = 'painel/grupo/alterar';
        $dados['tb_grupo'] = $this->Alterar_model->selec_grupo('grupo', $grupo_id);
        $dados['usuario'] = $this->Login_model->dados_usuario($this->session->userdata('uid'));
        $dados['user_admin'] = $this->Alterar_model->select_admin();
        $this->load->view('painel/index', $dados);
    }

    public function grupo($grupo_id)
    {

        $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
        $this->form_validation->set_rules('admin', 'Nome', 'trim|required');
        $this->form_validation->set_rules('visualizar', 'Visualizar', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $dados['form_erro'] = validation_errors();
        } else {
            $dados['parametros'] = array(
                'id' => 'default',
                'nome' => $this->input->post('nome'),
                'id_user_admin' => $this->input->post('admin'),
                'visualizar' => $this->input->post('visualizar')
            );

            $dados['msg_banco'] = $this->Alterar_model->update_grupo('grupo', $grupo_id, $dados['parametros']);

        }

        $dados['titulo'] = "Alterar";
        $dados['pg_header'] = "Editar Informações do Grupo";
        $dados['_view'] = 'painel/grupo/alterar';
        $dados['tb_grupo'] = $this->Alterar_model->selec_grupo('grupo', $grupo_id);
        $dados['user_admin'] = $this->Alterar_model->select_admin();
        $dados['usuario'] = $this->Login_model->dados_usuario($this->session->userdata('uid'));
        $this->load->view('painel/index', $dados);
    }
}

