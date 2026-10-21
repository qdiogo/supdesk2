<?PHP header('Content-Type: text/html; charset=ISO-8859.1');
?>
<a href="www.google.com.br"></a>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<meta charset="ISO8859.1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Sistema de Suporte">
<meta name="author" content="Diogo Monteiro">
<link rel="stylesheet" href="/css/xcss.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<title>Sistema de Suporte</title>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
<!-- Custom fonts for this template-->
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Verdana:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<!-- Custom styles for this template-->
<link href="css/sb-admin-2.min.css" rel="stylesheet">

<!-- Custom styles for this page -->
<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="/laudos/ckeditor.js"></script>
<script src="/laudos/samples/js/sample.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">

<link href="/select2-4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="/select2-4.0.13/dist/js/select2.min.js"></script> 

<script type="text/javascript" >

var startTime;

function display() {
  var endTime = new Date();
  var timeDiff = endTime - startTime;
  timeDiff /= 1000;
  var seconds = Math.round(timeDiff % 60);
  timeDiff = Math.floor(timeDiff / 60);
  var minutes = Math.round(timeDiff % 60);
  timeDiff = Math.floor(timeDiff / 60);
  var hours = Math.round(timeDiff % 24);
  timeDiff = Math.floor(timeDiff / 24);
  $("#time").text(hours + ":" + minutes + ":" + seconds);
  setTimeout(display, 1000);
}

startTime = new Date();
setTimeout(display, 1000);

$("#button").click(function() {
  alert("Meu tempo é: " + $("#time").text());
});

function limpa_formulário_cep() {
		//Limpa valores do formulário de cep.
		document.getElementById('ENDERECO').value=("");
		document.getElementById('BAIRRO').value=("");
		document.getElementById('CIDADE').value=("");
		document.getElementById('UF').value=("");
		document.getElementById('IBGE').value=("");
}

function meu_callback(conteudo) {
	if (!("erro" in conteudo)) {
		//Atualiza os campos com os valores.
		document.getElementById('ENDERECO').value=(conteudo.logradouro);
		document.getElementById('BAIRRO').value=(conteudo.bairro);
		document.getElementById('CIDADE').value=(conteudo.localidade);
		document.getElementById('UF').value=(conteudo.uf);
		document.getElementById('IBGE').value=(conteudo.ibge);
	} //end if.
	else {
		//CEP não Encontrado.
		limpa_formulário_cep();
		alert("CEP não encontrado.");
	}
}
	
function pesquisacep(valor) {
	//Nova variável "cep" somente com dígitos.
	var cep = valor.replace(/\D/g, '');

	//Verifica se campo cep possui valor informado.
	if (cep != "") {

		//Expressão regular para validar o CEP.
		var validacep = /^[0-9]{8}$/;

		//Valida o formato do CEP.
		if(validacep.test(cep)) {

			//Preenche os campos com "..." enquanto consulta webservice.
			document.getElementById('ENDERECO').value="...";
			document.getElementById('BAIRRO').value="...";
			document.getElementById('CIDADE').value="...";
			document.getElementById('UF').value="...";
			document.getElementById('IBGE').value="...";

			//Cria um elemento javascript.
			var script = document.createElement('script');

			//Sincroniza com o callback.
			script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

			//Insere script no documento e carrega o conteúdo.
			document.body.appendChild(script);

		} //end if.
		else {
			//cep é inválido.
			limpa_formulário_cep();
			alert("Formato de CEP inválido.");
		}
	} //end if.
	else {
		//cep sem valor, limpa formulário.
		limpa_formulário_cep();
	}
};




</script>
<script type="text/javascript" src="config.js"></script> 


<style>
	.sistema2{
		background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137);
		text-align: center;
		color: #fff;
		font-size: 20px;
		font-weight:bold;
	}
	td{
		font-size: 13px;
		font-weight: bold;
		color: black;
	}
	th{
		font-size: 13px;
		font-weight: bold;
		color: black;
	}
	label{
		font-size: 13px;
		font-weight: bold;
		color: black;
	}
	input{
		font-size: 13px;
		font-weight: bold;
		color: black;
	}
	ul {
		list-style-type: none;

	}
	a {	display: block;}

	.button {
		background-color: #00477e; /* Green */
		border: none;
		color: white;
		paddinC: 15px 32px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 4px 2px;
		cursor: pointer;
		-webkit-transition-duration: 0.4s; /* Safari */
		transition-duration: 0.4s;
	}
	.buttoned {

		background-color:  linear-gradient(to bottom, #003366 0%, #0099cc 100%);; /* Green */
		border: none;
		color: white;
		width: 50px;
		paddinC: 1px 10px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 4px 2px;
		cursor: pointer;
		-webkit-transition-duration: 0.4s; /* Safari */
		transition-duration: 0.4s;
		border-radius: 125px;
	}
	.buttoninfo {

		background-color: #4db8ff; /* Green */
		border: none;
		color: white;
		width: 50px;
		paddinC: 1px 10px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 4px 2px;
		cursor: pointer;
		-webkit-transition-duration: 0.4s; /* Safari */
		transition-duration: 0.4s;
		border-radius: 125px;
	}
	.buttondelet {
		background-color: #FF0000; /* Green */
		border: none;
		color: white;
		width: 50px;
		paddinC: 1px 10px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 4px 2px;
		cursor: pointer;
		-webkit-transition-duration: 0.4s; /* Safari */
		transition-duration: 0.4s;
		border-radius: 125px;

	}
	.buttonpri {
		background-color: #008ae6; /* Green */
		border: none;
		color: white;
		width: 140px;
		paddinC: 1px 10px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 4px 2px;
		cursor: pointer;
		-webkit-transition-duration: 0.4s; /* Safari */
		transition-duration: 0.4s;
		border-radius: 125px;

	}
	.button1 {
		box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
	}

	.button2:hover {
		box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
	}
	.editar:hover {
		box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
	}
	.deletar:hover {
		box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
	}
	.primary:hover {
		box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
	}
	.info:hover {
		box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
	}

	input, select, textarea, .input-field, .form-control {
		background-color: #FFFACD; /* Cor global */
		color: #000; /* Cor do texto */
		border: 1px solid #ccc; /* Cor da borda */
		padding: 8px;
		border-radius: 4px; /* Bordas arredondadas */
		font-weight: bold;
	}
	input:focus, select:focus, textarea:focus{
		background-color: #F0E68C; /* Cor de foco */
		outline: none; /* Remover a borda de foco padrão */
		box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Sombra de foco */
	}
</style>
<script type="text/javascript" src="/jquery-1.7.2.min.js"></script>

<?php error_reporting(0);?>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function () {
    $('select.form-control').select2({
      placeholder: 'Selecione uma opção',
      allowClear: true,
      theme: 'bootstrap4' // Você pode usar outros temas se preferir
    });
  });
</script>

<style>
  /* Largura total */
  .select2-container {
    width: 100% !important;
  }

  /* Altura e tamanho grande */
  .select2-container .select2-selection--single {
    height: 40px; /* Altura do campo */
    background-color: #FFFACD; /* Fundo amarelo claro */
    border: 1px solid #000; /* Borda preta */
    border-radius: 5px; /* Arredondamento */
    display: flex; /* Alinha elementos internamente */
    align-items: center; /* Centraliza verticalmente */
  }

  /* Texto centralizado no campo */
  .select2-container .select2-selection__rendered {
    line-height: 40px; /* Igual à altura do campo */
    padding-left: 10px; /* Espaçamento do texto */
    font-size: 14px; /* Ajusta o tamanho do texto */
    color: #333; /* Cor do texto */
  }

  /* Ajuste da seta do dropdown */
  .select2-container .select2-selection__arrow {
    height: 40px; /* Igual à altura do campo */
  }
</style>


<style>
/* Camada de padronização visual do sistema. */
:root { --sup-navy:#172b4d; --sup-blue:#253b80; --sup-accent:#456bd1; --sup-border:#d3dce9; --sup-text:#26334d; --sup-soft:#f4f7fb; }
body { color:var(--sup-text); font-family:Verdana,Arial,sans-serif; }
.sistema2 { background:linear-gradient(110deg,var(--sup-blue),var(--sup-accent)) !important; color:#fff !important; border:0; border-radius:9px 9px 0 0; padding:12px 16px; }
td, th, label { color:var(--sup-text); }
th { font-weight:700; }
input, select, textarea, .input-field, .form-control { background:#fff !important; color:var(--sup-text) !important; border:1px solid var(--sup-border) !important; border-radius:8px !important; padding:8px 11px; font-weight:400; box-shadow:none; transition:border-color .15s,box-shadow .15s; }
input:focus, select:focus, textarea:focus, .form-control:focus { background:#fff !important; border-color:var(--sup-accent) !important; outline:0; box-shadow:0 0 0 3px rgba(69,107,209,.14) !important; }
.button, .buttoned, .buttoninfo, .buttonpri { background:linear-gradient(110deg,var(--sup-blue),var(--sup-accent)); color:#fff !important; border:0; border-radius:8px; padding:9px 15px; min-height:38px; width:auto; font-size:14px; font-weight:600; box-shadow:0 3px 8px rgba(37,59,128,.16); transition:transform .15s,box-shadow .15s,filter .15s; }
.button:hover, .buttoned:hover, .buttoninfo:hover, .buttonpri:hover { color:#fff; filter:brightness(1.06); transform:translateY(-1px); box-shadow:0 6px 14px rgba(37,59,128,.22); }
.buttondelet { background:#d64b57; color:#fff !important; border:0; border-radius:8px; padding:8px 12px; width:auto; min-height:36px; }
.buttondelet:hover { background:#bf3946; color:#fff; }
table { border-color:#e2e8f0; }
thead th { background:#edf2fb; color:#293956; border-color:#dfe6f0; }
tbody tr:nth-child(even) { background:#f8faff; }
a { color:var(--sup-blue); }
a:hover { color:var(--sup-accent); }
.select2-container { width:100% !important; }
.select2-container .select2-selection--single { height:40px; background:#fff !important; border:1px solid var(--sup-border) !important; border-radius:8px !important; display:flex; align-items:center; }
.select2-container .select2-selection__rendered { line-height:38px; padding-left:11px; font-size:14px; color:var(--sup-text) !important; }
.select2-container .select2-selection__arrow { height:38px; }
.select2-dropdown { border:1px solid var(--sup-border); border-radius:8px; overflow:hidden; box-shadow:0 8px 18px rgba(27,48,83,.12); }
.select2-container--default .select2-results__option--highlighted[aria-selected] { background:var(--sup-blue); }
.select2-container--default .select2-results__option[aria-selected=true] { background:#edf4ff; color:var(--sup-blue); }
@media (max-width:767px) { input,select,textarea,.form-control { max-width:100%; } .button,.buttoned,.buttoninfo,.buttonpri { padding:8px 12px; font-size:13px; } }
</style>
