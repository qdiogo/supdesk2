<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alterar extends CI_Controller

{
    function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(TRUE);
        $this->load->model('usuario/Alterar_model');
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

    public function index($user_id){

        $dados['titulo'] = "Alterar";
        $dados['pg_header'] = "Editar Informação do Usuário";
        $dados['_view'] = 'painel/usuario/alterar';
        $dados['tb_user'] = $this->Alterar_model->selec_usuario('user', $user_id);
        $dados['usuario'] = $this->Login_model->dados_usuario($this->session->userdata('uid'));
        $this->load->view('painel/index', $dados);
    }

    public function usuario($user_id)
    {
        // Regras de validação do Formulario de registro de usuário
        $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
        $this->form_validation->set_rules('cpf', 'CPF', 'trim|required|callback_valid_cpf');
        $this->form_validation->set_rules('crm', 'CRM', 'trim|numeric|required');
        $this->form_validation->set_rules('dt_nascimento', 'Data de Nascimento', 'trim|required|callback_valid_dt_nascimento');
        $this->form_validation->set_rules('tipo', 'Tipo de Conta', 'trim|required');
        $this->form_validation->set_message('valid_cpf', 'Número do CPF invalido');
        $this->form_validation->set_message('valid_dt_nascimento', 'Data de Nascimento invalida!');

        if ($this->form_validation->run() == FALSE) {
            $dados['form_erro'] = validation_errors();
            
        } 
        else 
        {
            $reset_senha = $this->input->post('reset');
            $dados['parametros'] = [
                'nome' => $this->input->post('nome'),
                'email' => $this->input->post('email'),
                'cpf' => $this->rem_format($this->input->post('cpf')),
                'crm' => $this->input->post('crm'),
                'dt_nascimento' => $this->input->post('dt_nascimento'),
                // Tipo de Conta 0 - Admin / 1 - User / 2 - Admin Grupo.
                'tipo' => $this->input->post('tipo'),

                // Status 0 - Criado / 1 - Ativo / 2 - Inativo
                'status' => $this->input->post('status'),
                'senha' => md5('1234567'),
            ];
            if ($reset_senha != 1) {
                unset($dados['parametros']['senha']);
            }
            // Faz o update
            $dados['msg_banco'] = $this->Alterar_model->update_usuario('user', $user_id, $dados['parametros']);
            
            

        }

        $dados['titulo'] = "Alterar";
        $dados['pg_header'] = "Editar Informação do Usuário";
        $dados['_view'] = 'painel/usuario/alterar';
        $dados['tb_user'] = $this->Alterar_model->selec_usuario('user', $user_id);
        $dados['usuario'] = $this->Login_model->dados_usuario($this->session->userdata('uid'));
        $this->load->view('painel/index', $dados);
        
    }

    function valid_cpf($cpf)
    {

        // Verifiva se o numero digitado contem todos os digitos

        $cpf = str_pad(preg_replace('/[^0-9]/', '', $cpf), 11, '0', STR_PAD_LEFT);

        // Verifica se nenhuma das nenhuma abaixo foi digitada, caso seja, retorna falso

        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
            return FALSE;
        } else {

            // Calcula os numeros para verificar se o CPF é verdadeiro

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

    function valid_dt_nascimento($dt)
    {

        // Verifica se a data de entrada não maior ou igual ao dia atual.

        date_default_timezone_set("America/New_York");
        if ($dt >= date("Y-m-d")) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function rem_format($entrada){
        $chars = array(".","/","-",";");
         return str_replace($chars, "", $entrada);
    }
}
