
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<link href="/bootstrap-3.3.7-dist/example/assets/main.css" rel="stylesheet">
<script language="text/javascript" src="/javascript/jquery-3.2.0.min.js"></script>
<script type="text/javascript" src="/javascript/jquery.quick.search.js"></script>
<script type="text/javascript" src="/javascript/javascript_master.js"></script>
<script type="text/javascript" src="/bootstrap-3.3.7-dist/src/alertify.js"></script>
<script type="text/javascript" src="/bootstrap-3.3.7-dist/simply-toast-master/simply-toast.js"></script>
<link rel="stylesheet" href="/bootstrap-3.3.7-dist/themes/alertify.core.css" />
<link rel="stylesheet" href="/bootstrap-3.3.7-dist/themes/alertify.default.css" id="toggleCSS" />
<script>
$(document).ready(function(){
  $('.dropdown-submenu a.test').on("click", function(e){
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });
});
</script>


<script>
	$(document).ready(function(){
		$(".nav-tabs a").click(function(){
			$(this).tab('show');
		});
	});
		function enfocus()
		{
		   document.forms[0].Data.focus()
		   document.forms[0].Copy.value = document.forms[0].Data.value
		   setTimeout("enblur()", 500)
		}
		function enblur()
		{
		   document.forms[0].Data.blur()
		   setTimeout("enfocus()", 5)
		}
</script>
<script>
function mascaraData( campo, e )
	{
		var kC = (document.all) ? event.keyCode : e.keyCode;
		var data = campo.value;
		if( kC!=8 && kC!=46 )
		{
			if( data.length==2 )
			{
				campo.value = data += '/';
			}
			else if( data.length==5 )
			{
				campo.value = data += '/';
			}
			else
			campo.value = data;
		}
	}
	function verificardata( campo, e ){
		var data = campo.value;
		 exp = /\d{2}\/\d{2}\/\d{4}/
		var cor = "#ff9999"
		var xcorfont = document.getElementById(campo.id).style.color ="#FFF";
		var campox = document.getElementById(campo.id).id;
		if (data.length != "") {
			if (data.length < 10) {
				 alert("Data Inválida menor que o solicitado!");
				 document.getElementById(campo.id).style.backgroundColor = cor;
				 xcorfont;
			}else if (data.length > 10){
				 alert("Data Inválida maior que o solicitado!");
				 document.getElementById(campo.id).style.backgroundColor = cor;
				 xcorfont;
			}else if (!exp.test(campo.value)){
				alert("Formato Inválido" + " No seguinte Caracteres " + campo.value + " Verificar o Campo Data: "  + campox);
				document.getElementById(campo.id).style.backgroundColor = cor;
				xcorfont;
			}else{
				document.getElementById(campo.id).style.backgroundColor = "#FFF";
				corfont = document.getElementById(campo.id).style.color ="#000";
			}
		}else{
		document.getElementById(campo.id).style.backgroundColor = "#FFF";
				corfont = document.getElementById(campo.id).style.color ="#000";
		}
	}
	function mascarahora( campo, e )
	{
	var kC = (document.all) ? event.keyCode : e.keyCode;
	var hota = campo.value;
	
	if( kC!=8 && kC!=46 )
	{
		if( hota.length==2 )
		{
				campo.value = hota += ':';
			}
		else if( hota.length==2 )
		{
			campo.value = hota += ':';
			}
			else
				campo.value = hota;
		}
	}
	function verificarhora( campo, e ){
		var hora = (campo.value.substring(0,2));
		var min = (campo.value.substring(3,5));
		var varhora= hora + ":" + min;
		exp = hora + min;
		var cor = "#ff9999"
		var xcorfont = document.getElementById(campo.id).style.color ="#FFF";
		var campox = document.getElementById(campo.id).id;
		if (campo.value !=""){
			if (((hora < 00 ) || (hora > 23) || ( min < 00) ||( min > 59))) {
				 alert("Hora Inválida!");
				 document.getElementById(campo.id).style.backgroundColor = cor;
				 xcorfont;
			}else if (varhora.length < 5){
				 alert("Hora Inválida!");
				 document.getElementById(campo.id).style.backgroundColor = cor;
				 xcorfont;
			}else{
				document.getElementById(campo.id).style.backgroundColor = "#FFF";
				corfont = document.getElementById(campo.id).style.color ="#000";
			}
		}
	}
</script>
<script language="javascript" type="text/javascript">
function openAjax() {
	var Ajax;
	try {Ajax = new XMLHttpRequest(); // XMLHttpRequest para browsers mais populares, como: Firefox, Safari, dentre outros.
	}catch(ee){
		try {Ajax = new ActiveXObject("Msxml2.XMLHTTP"); // Para o IE da MS
		}catch(e){
		try {Ajax = new ActiveXObject("Microsoft.XMLHTTP"); // Para o IE da MS
		}catch(e){Ajax = false;}
		}
	}
		return Ajax;
	} 

	function carregaAjax(pagina,  getURL) {
	document.getElementById("pagina").style.display = "block";
		if(document.getElementById) { // Para os browsers complacentes com o DOM W3C.
			var exibeResultado = document.getElementById("pagina"); // div que exibirá o resultado.
			var Ajax = openAjax(); // Inicia o Ajax.
			Ajax.open("GET", getURL, true); // fazendo a requisição
			Ajax.onreadystatechange = function(){
				if(Ajax.readyState == 1) { // Quando estiver carregando, exibe: carregando...
				exibeResultado.innerHTML = "<div>Carregando</div>";
				}
				if(Ajax.readyState == 4) { // Quando estiver tudo pronto.
					if(Ajax.status == 200) {
					var resultado = Ajax.responseText; // Coloca o retornado pelo Ajax nessa variável
					resultado = resultado.replace(/\+/g,""); // Resolve o problema dos acentos (saiba mais aqui: http://www.plugsites.net/leandro/?p=4)
					//resultado = resultado.replace(/ã/g,"a");
					resultado = unescape(resultado); // Resolve o problema dos acentos
					exibeResultado.innerHTML = resultado;
					} else {
					exibeResultado.innerHTML = "Por favor, tente novamente!";
					}
				}
			}
			Ajax.send(null); // submete
		}
	}
</script>
<style>

tbody:nth-child(odd) {
   background-color: #4682B4;
}
</style>
<script type="text/javascript" src="jquery.js"></script>
<style type="text/css" media="screen">
	.relcabecalho{
		border : 1px solid black; font-size 7px; font-family: verdana,  color: helvetica, sans-serif, arial;
	}
	body{
		min-width: auto;
		max-width: auto;
		html: auto;
	}
	.border{
		border: 3px solid teal;
		min-width: auto;
		max-width: auto;
		margin-top: auto;
		margin: auto;
		padding: auto;
		padding: 13;
	}
	.xfont{
		color: #FFF;
		font-family: verdana, arial, sans-serif, helvetica;
	}
	.top{
		background: teal;
		border: 1px solid teal;
		font-family: verdana, helvetica, arial, sans-serif;
		color: #FFFFFF; 
		font-size: 15px;
		min-width: auto;
		max-width: auto;
		margin-top: auto;
		margin: auto;
		padding: auto;
		text-align: center
		border-radius: 200px;
		text-align: center;
		
	}
	.footer{
		font-family: verdana, helvetica, sans_serif, arial;
		font-size: 12px;
		position: relative;
		min-width: auto;
		max-width: auto;
		width: 100%;
		heigth: 100%;
		background: #1a1a1a;
		margin-top: 25%;
		padding: auto;
		color: #FFFFFF;
		
	}
	#xxas
	{
		font-size: 12px;
		font-family: verdana, helvetica, sans-serif, arial;
		background: #191970;
		width: 100%;
		height: 12%;
		color: #FFF;
	}
	.font{
	color: #FFF;
	font-family: verdana, helvetica, sans-serif, arial;
	}
	.div{
	background-color: rgba(255,255,255,0.8);
	height: 440px;
	width: 30%;
	max-width: auto;
	min-width: 250px;
	margin: 10%;
	border-radius: 15px;
	width-max: 2000px;
	width-min: 600px;
  }
  .selecao{
	background: linear-gradient(to bottom, #4682B4 0%, #4682B4 100%)
	width: 20px;
	height: 120px;
	background: #4682B4;
	border-radius: 10PX;
	font-size: 20px;
	color: white;
	padding: 30px;
  }
  .selecaonome{
	color: #FFFFFF;
	font-family: verdana, helvetica, arial , sans-serif;
	font-size: 50px;
	background: linear-gradient(to bottom, #4682B4 0%, #4682B4 100%);
	height: 400px;
	border-radius: 20PX;
  }
  .selecao:hover{
  background: #4682B4;
	-webkit-transition-duration: 1.60s; /* Safari */
	transition-duration: 1.60s;
  }
  .table {
	border : medium solid teal;
	}
	
	.button {
		background-color: #00477e; /* Green */
		border: none;
		color: white;
		padding: 15px 32px;
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
		background-color: #2db300; /* Green */
		border: none;
		color: white;
		width: 140px;
		padding: 1px 30px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 18px;
		margin: 4px 2px;
		cursor: pointer;
		-webkit-transition-duration: 0.4s; /* Safari */
		transition-duration: 0.4s;
		border-radius: 200px;
	}
	.buttoninfo {
		background-color: #4db8ff; /* Green */
		border: none;
		color: white;
		width: 140px;
		padding: 1px 30px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 4px 2px;
		cursor: pointer;
		-webkit-transition-duration: 0.4s; /* Safari */
		transition-duration: 0.4s;
		border-radius: 200px;
	}
	.buttondelet {
		background-color: #FF0000; /* Green */
		border: none;
		color: white;
		width: 140px;
		padding: 1px 30px;
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
		padding: 1px 30px;
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
  User-agent: *
  Disallow:
  #xtable:hover {
		background: #DDDDDD;
 }
</style>
<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }
</style>