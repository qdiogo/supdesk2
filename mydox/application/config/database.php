<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		
		$active_group = 'default';
		$active_record = TRUE;

		$db['default']['hostname'] = 'localhost';
		$db['default']['username'] = 'root'; //informe o usuário do banco
		$db['default']['password'] = 'root'; //informe a senha do usuário do banco
		$db['default']['database'] = 'mysql';
		$db['default']['dbdriver'] = 'mysqli';
		$db['default']['dbprefix'] = '';
		$db['default']['pconnect'] = TRUE;
		$db['default']['db_debug'] = TRUE;
		$db['default']['cache_on'] = FALSE;
		$db['default']['cachedir'] = '';
		$db['default']['char_set'] = 'utf8';
		$db['default']['dbcollat'] = 'utf8_unicode_ci';
		$db['default']['swap_pre'] = '';
		$db['default']['autoinit'] = TRUE;
		$db['default']['stricton'] = FALSE;
?>
