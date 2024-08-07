<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio_login extends CI_Controller

{
    public

    function __construct()
    {
        parent::__construct();

        $this->load->model('inicio/Inicio_model');
        $this->load->helper('form');
        $this->Inicio_model->get_admin();
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

    public

    function index()
    {
        $dados['titulo'] = "Login";
        $dados['pg_header'] = "Login";
        $this->load->view('inicio/login/index', $dados);
    }
}
