<?php

class Info_model extends CI_Model

{
    function __construct()
    {
        parent::__construct();
    }

    // Select All

    function tabela($user_id)
    {
        $this->db->select(['user.nome admin', 'grupo.id', 'grupo.status', 'grupo.nome grupo']);
        $this->db->from('user');
        $this->db->join('grupo', 'user.id = grupo.id_user_admin');
        $result = $this->db->get()->result_array();
        for ($i=0; $i < count($result) ; $i++) { 
            $ts = $this->consulta_grupo($user_id,$result[$i]['id']);
            if ($ts) {
                $result[$i] = $result[$i] + ['pertence' => '1'];
            } else {
                $result[$i] = $result[$i] + ['pertence' => '0'];
            }
        }
        return  $result;

    }

    function mostra($array){
        foreach($array as $linha){
            echo '<span>';
            print_r($linha);
            echo '</span>';
           echo "<br>";
        }
    }

    function lista_usuarios_grupo($id){
        $this->db->select(['user.nome','user.id', 'user_grupo.id_grupo', 'user_grupo.user_status']);
        $this->db->from('user');
        $this->db->join('user_grupo', 'user.id = user_grupo.id_user ');
        $this->db->where('id_grupo', $id);
        $this->db->order_by('user_status', 'desc'); 
        $this->db->group_by(['user.nome', 'user.id']);
        $result = $this->db->get()->result_array();
        return $result;
    }

    function lista_usuarios($id)
    {   $grupo = $this->lista_usuarios_grupo($id);
        //$this->mostra($grupo);
        $this->db->select(['user.id', 'user.nome']);
        $this->db->from('user');
        $user = $this->db->get()->result_array();
        //$this->mostra($user);
        $user_dim = count($user);
        $grupo_dim = count($grupo);
        for($i=0; $i<$user_dim; $i++ ){
            for($j=0; $j<$grupo_dim; $j++ ){
                if($user[$i]['id'] == $grupo[$j]['id'] && $grupo[$j]['user_status'] == 1){
                    unset($user[$i]);
                    break;
                }
            }
        }
        //$this->mostra($user);
        return $user;
    }

    function ins_user_grupo($parametros){
        $this->db->select();
        $busca = [
            'id_user' => $parametros['id_user'],
            'id_grupo' => $parametros['id_grupo']
        ];
        $this->db->from('user_grupo');
        $this->db->where($busca);
        $result = $this->db->get()->result_array();
        if($result){
            $dados = [
                'user_status' => 1,
            ];
            $this->db->select('id_grupo', 'id_user', 'status');
            $this->db->where($busca);
            $this->db->update('user_grupo',$dados);
        } else {

        $this->db->insert('user_grupo', $parametros);
        }

    }

    function rem_user_grupo($parametros){
        $busca = [
            'id_user' => $parametros['id_user'],
            'id_grupo' => $parametros['id_grupo']
        ];
        $dados = [
            'user_status' => 0,
        ];
        $this->db->select('id_grupo', 'id_user', 'status');
        $this->db->where($busca);
        $this->db->update('user_grupo',$dados);
        
        
    }

    

    
}

