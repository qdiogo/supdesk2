<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller

{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('inicio/Usuario_model');
        $this->load->library('auxiliar');
        $login_status = $this->session->userdata('login');
        if ($login_status == TRUE) {
            $data = array(
                'login' => '',
                'uname' => '',
                'uid' => ''
            );
            $this->session->unset_userdata($data);
            $this->session->sess_destroy();
            redirect('inicio');
        }
    }

    public function index()
    {
        $dados['titulo'] = "Cadastro";
        $dados['pg_header'] = "Cadastro";
        $this->load->view('inicio/cadastro/index', $dados);

    }

    public function novo()
    {
        $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
        $this->form_validation->set_rules('cpf', 'CPF', 'trim|required|callback_valid_cpf');
        $this->form_validation->set_rules('crm', 'CRM', 'trim|numeric|required');
        $this->form_validation->set_rules('dt_nascimento', 'Data de Nascimento', 'trim|required|callback_valid_dt_nasc');
        $this->form_validation->set_rules('conf_senha', 'Confirma', 'trim|required|min_length[6]|matches[senha]');
        $this->form_validation->set_rules('senha', 'Nova', 'trim|required|min_length[6]');
        $this->form_validation->set_message('valid_cpf', 'Número do CPF inválido!');
        $this->form_validation->set_message('valid_dt_nasc', 'Data de Nascimento inválida!');

        if ($this->form_validation->run() == FALSE) {
            $dados['form_erro'] = validation_errors();
        } else {
            $dados['parametros'] = [
                'id' => 'default',
                'nome' => $this->input->post('nome'),
                'email' => $this->input->post('email'),
                'cpf' => $this->auxiliar->rem_format($this->input->post('cpf')),
                'crm' => $this->input->post('crm'),
                'dt_nascimento' => $this->input->post('dt_nascimento'),
                'senha' => md5($this->input->post('senha')),
                // Tipo de Conta 0 - Admin / 1 - User.
                'tipo' => 1,
                // Status 0 - Criado / 1 - ativo / 2 - Bloqueado
                'status' => 1,
            ];

            // Faz insert no banco
            $dados['msg_banco'] = $this->Usuario_model->ins_user('user', $dados['parametros']);
            $dados['status'] = array_pop($dados['msg_banco']);

           
        }

        $dados['titulo'] = "Cadastro";
        $dados['pg_header'] = "Cadastro";
        $this->load->view('inicio/cadastro/index', $dados);

    }

    function valid_cpf($cpf)
    {

        // Verifiva se o numeor digitado contem todos os digitos

        $cpf = str_pad(preg_replace('/[^0-9]/', '', $cpf), 11, '0', STR_PAD_LEFT);

        // Verifica se nenhuma das sequencias abaixo foi digitada, caso seja, retorna falso

        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
            return FALSE;
        } else {

            // Calcula os numeros para verificar se o CPF são verdadeiro

            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf
                        {
                        $c} * (($t + 1) - $c);
                }

                $d = ((10 * $d) % 11) % 10;
                if ($cpf
                    {
                    $c} != $d) {
                    return FALSE;
                }
            }

            return TRUE;
        }
    }

    function valid_dt_nasc($dt)
    {

        // Verifica se a data de entrada são maior ou igual ao dia atual.

        date_default_timezone_set("America/New_York");
        if ($dt >= date("Y-m-d")) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}

