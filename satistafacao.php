<!DOCTYPE html>
<?php
	date_default_timezone_set('America/Bahia');
    $timestamp = date('Y-m-d H:i');
    header('Content-Type: text/html; charset=iso-8859-1');
?>
<html lang="pt-BR">
  <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <title>Avaliação de Chamado</title>
	<STYLE>
		body{
			margin: 0;
			padding: 0;
			background: #252d3d;
			}

			.rating{
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%,-50%) rotateY(180deg);
			display: flex;
			}

			.rating input{
			display: none;
			}

			.rating label{
				display: block;
				cursor: pointer;
				width: 50px;
			}

			.rating label:before{
			content: '\f005';
			font-family: fontAwesome;
			position: relative;
			display: block;
			font-size: 50px;
			color: #0e1316;
			}

			.rating label:after{
			content: '\f005';
			font-family: fontAwesome;
			position: absolute;
			display: block;
			font-size: 50px;
			color: #ffff00;
			top: 0;
			opacity: 0;
			transition: .5;
			text-shadow: 0 4px 5px rgba(0, 0, 0, .5);
			}
			.rating label:hover:after,
			.rating label:hover ~ label:after,
			.rating input:checked ~ label:after{
			opacity: 1;
			}
			.titulo{
				color: white;
				text-align:center;
				font-size:20px;
				font-family: verdana;
			}
	</STYLE>
	<script>
		function createRequestObject()
		{
			var ro;
			var browser = navigator.appName;
			if(browser == "Microsoft Internet Explorer")
			{
				ro = new ActiveXObject("Microsoft.XMLHTTP");
			}
			else
			{
				ro = new XMLHttpRequest();
			}
			return ro;
		}
		

		var http1 = createRequestObject();
		function avaliacao(campo)
		{
			if (campo==1){
			  var texto = prompt("Conte a gente o que aconteceu ?", "");
			}
			
			if ((campo==1) && (texto==""))
			{
				alert("Por favor informe o que aconteceu com esse atendimento");
			}else{
				http1.open('get', 'avaliacao_dados?chamado=<?php echo $_GET["CHAMADO"]?>&avaliacao='+ campo + "&texto="+texto);
				http1.onreadystatechange = xcatx1;
				http1.send(null);
			}
			
		}
		function xcatx1()
		{
			if(http1.readyState == 4)
			{
				var response = http1.responseText;
				alert(response);
			}
		}
	</script>
  </head>

  <body>
	<div class="titulo"><h2>Avaliação do Atendimento</h2></div>
    <h3 class="titulo">
		Prezado(a),

		Gostaria de solicitar sua avaliação sobre nosso atendimento recente. Sua opinião é muito importante para nós e nos ajuda a aprimorar nossos serviços.

		Por favor, avalie nosso atendimento usando a escala de estrelas abaixo: <br>
		Excelente: * * * * *<br>
		Bom: * * * *<br>
		Regular: * * * <br>
		Ruim: * <br>
		Sua resposta será tratada com a máxima confidencialidade. Agradecemos sinceramente por seu tempo e atenção.
	</h3>
	<div class="rating">	
	  <input type="radio" name="star" onclick="avaliacao(5)" id="star1"><label for="star1"></label>
      <input type="radio" name="star" onclick="avaliacao(4)" id="star2"><label for="star2"></label>
      <input type="radio" name="star" onclick="avaliacao(3)" id="star3"><label for="star3"></label>
      <input type="radio" name="star" onclick="avaliacao(2)" id="star4"><label for="star4"></label>
      <input type="radio" name="star" onclick="avaliacao(1)" id="star5"><label for="star5"></label>
    </div>
  </body>
</html>