<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Inicio_login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Usuário
$route['painel_controle/usuarios'] = 'painel/usuario/Lista';
$route['painel_controle/cadastro/usuario'] = 'painel/usuario/Cadastro';
$route['painel_controle/cadastrar/usuario'] = 'painel/usuario/Cadastro/novo';
$route['painel_controle/usuario/(:num)'] = 'painel/usuario/Alterar/index/$1';
$route['painel_controle/usuario/alterar/(:num)'] = 'painel/usuario/Alterar/usuario/$1';
$route['painel_controle/usuario/alterar/senha/(:num)'] = 'painel/usuario/Alterar_senha/usuario/$1';

// Grupo
$route['painel_controle/grupos'] = 'painel/grupo/Lista';
$route['painel_controle/cadastro/grupo'] = 'painel/grupo/Cadastro';
$route['painel_controle/cadastro/grupo/novo'] = 'painel/grupo/Cadastro/novo';
$route['painel_controle/grupo/(:num)'] = 'painel/grupo/Alterar/index/$1';
$route['painel_controle/grupo/alterar/(:num)'] = 'painel/grupo/Alterar/grupo/$1';
$route['painel_controle/grupo/entrar/(:num)'] = 'painel/grupo/Lista/entrar/$1';
$route['painel_controle/meus_grupos'] = 'painel/grupo/Meus_grupos';
$route['painel/grupo/meus_grupos/informacao/(:num)'] = 'painel/grupo/Info/index/$1';
$route['painel/grupo/meus_grupos/informacao/novo/(:num)'] = 'painel/grupo/Info/adicionar/$1';
$route['painel/grupo/meus_grupos/informacao/remover/(:num)'] = 'painel/grupo/Info/remover/$1';

// Inicio
$route['inicio'] = 'inicio/acesso/Login';
$route['login'] = 'inicio/acesso/Login/entrar';
$route['logout'] = 'inicio/acesso/Login/sair';
$route['usuario'] = 'inicio/cadastro/Usuario';
$route['usuario/novo'] = 'inicio/cadastro/Usuario/novo';

// Painel de controle
$route['painel_controle'] = 'painel/Main';














