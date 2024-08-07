<!DOCTYPE html>
<html lang="pt">
<head> 
<?php include "css.php"?>


<?php
/*
* Getting MAC Address using PHP
* Md. Nazmul Basher
*/



function GetMAC(){
    ob_start();
    system('getmac');
    $Content = ob_get_contents();
    ob_clean();
    return substr($Content, strpos($Content,'\\')-20, 17);
}


$servidor = "127.0.0.1:C:\SGBD\pessoal.fdb";
$NOME="";
$TIPO="";
if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','ISO8859_1', '9000', '1')))
die('Erro ao conectar: ' .  ibase_errmsg());

IF (empty($_SESSION["NOME"]))
{
	session_start();
	$NOME=strtoupper($_POST["NOME"]);
	$_SESSION["NOME"]=$_POST["NOME"];
}else{
	$NOME=strtoupper($_SESSION["NOME"]);
}

$SQL="SELECT UPPER(NOME) AS NOME, SENHA, AGENDA_DATA FROM USUARIOS WHERE UPPER(NOME)='DIOGO COSTA'";
$tabela=ibase_query($conexao,$SQL); 
$open=ibase_fetch_assoc($tabela); 


IF (empty($_SESSION["NOME"]))
{
	if (!empty($tabela))
	{
		session_start();
		$_SESSION["NOME"]=$_POST["NOME"];
		header("Location: https://192.168.100.77:5858");
	}
}

if (!empty($open["AGENDA_DATA"]))
{
	$TIPO="Lembrando que  tem uma agenda";
}


?>



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

    <?PHP if (!empty($_GET["auto"])) { ?>
	function pausecomp(millis)
	{
		var date = new Date();
		var curDate = null;
		do { curDate = new Date(); }
		while(curDate-date < millis);
	}
	window.onload = function mensagem1()
	{
		pausecomp(1000);
		document.getElementById("TIPO"+<?php echo $_GET["TIPO"]?>+"").click();
	}
	<?php } ?>
	
    function mensagem(tipo)
	{
        var data = "";
		var titulo = "";
		if (tipo=='1')
        {
            document.getElementById("message").value='Luz da Sala Ligada.'+document.getElementById("nome").value+' '
        
        }else if (tipo=='2'){
            document.getElementById("message").value='Luz da Sala Desligada.'+document.getElementById("nome").value+''
        
        }else if (tipo=='3'){
            document.getElementById("message").value='Luz do Quarto Ligada.'+document.getElementById("nome").value+''
        
        }else if (tipo=='4'){
            document.getElementById("message").value='Luz do Quarto Desligada.'+document.getElementById("nome").value+''
        }else if (tipo=='5'){
            document.getElementById("message").value='Luz Auxiliar Ligada.'+document.getElementById("nome").value+''
        }else if (tipo=='6'){
            document.getElementById("message").value='Luz Auxiliar Desligada.'+document.getElementById("nome").value+''
        
		}else if (tipo=='7'){
            document.getElementById("message").value='Modo geral Ligado.'+document.getElementById("nome").value+''
        
		}else if (tipo=='8'){
            document.getElementById("message").value='Modo geral Desligado.'+document.getElementById("nome").value+'';
        }else if (tipo=='15'){
            document.getElementById("message").value='Informe a data para o agendamento.'+document.getElementById("nome").value+'';
			var data = prompt("Data do Agendamento com Exemplo: 12/12/2021", "17/10/2021");
			
			document.getElementById("message").value='Informe o titulo do agendamento.'+document.getElementById("nome").value+'';
			var titulo = prompt("Titulo do Agendamento", "");
			location.href='arduino?TIPO=' + tipo  + '&data='+data+'&titulo='+titulo+'&AGENDA=S';
		}else if (tipo=='16'){
            document.getElementById("message").value='Lipar Agendamento.'+document.getElementById("nome").value+'';
			
			location.href='arduino?TIPO=' + tipo  + '&data='+data+'&titulo='+titulo+'&LIMPARAGENDA=S';
		}else{
			 document.getElementById("message").value='Comando não reconhecido.'+document.getElementById("nome").value+'';
			 history.go(-1);
        }
		
        var http1 = createRequestObject();
        http1.open('get', 'arduino2?TIPO=' + tipo  + '&data='+data+'&titulo='+titulo+' ');
		
		http1.send(null);
        document.getElementById("speak").click();
		<?PHP if (!empty($_GET["auto"])) { ?>
			history.go(-1);
		<?php } ?>
	}
	
	
</script>  
</head>
<body id="page-top"> 
	<div class="container" align="center">
		<?php if (!empty($_GET["AGENDA"])) {
			$sql="UPDATE USUARIOS SET AGENDA_DATA='".$_GET["data"]."', AGENDA_TITULO='".$_GET["titulo"]."' WHERE UPPER(NOME)='".strtoupper($_SESSION["NOME"])."' ";
			$tabela= ibase_query ($conexao, $sql);
			header("Location: https://192.168.100.77:5858");
		}
		
		if (!empty($_GET["LIMPARAGENDA"])) {
			$sql="UPDATE USUARIOS SET AGENDA_DATA=NULL, AGENDA_TITULO=NULL WHERE UPPER(NOME)='".strtoupper($_SESSION["NOME"])."' ";
			$tabela= ibase_query ($conexao, $sql);
			header("Location: https://192.168.100.77:5858");
		}
		
		if (empty($open)) {?>
			<form method="post" action="arduino.php?INSERT=S">
				<div class="row">
					<div class="col-md-12">
						<img src="753173.png" width="100" height="100">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<h3>Por favor Cadastre-Se</h3>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label>Nome</label>
						<input type="text" name="NOME" ID="NOME" class="form-control" maxlength="100" required>
					</div>
					<div class="col-md-12">
						<label>Telefone</label>
						<input type="text" name="TELEFONE" ID="TELEFONE" class="form-control" maxlength="14"required>
					</div>
					<div class="col-md-12">
						<label>E-mail</label>
						<input type="email" name="USUARIO" ID="USUARIO" class="form-control" maxlength="100" required>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<input type="hidden" name="senha" ID="senha" readonly value="<?php echo GetMAC()?>" required class="form-control" maxlength="100">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<button class="btn btn-success">Salvar Dados</button>
					</div>
				</div>
			</form>
			<?php if (!empty($_GET["INSERT"])) {
				$SQL="SELECT NOME, SENHA, AGENDA_DATA FROM USUARIOS WHERE UPPER(NOME)='".strtoupper($_POST["NOME"])."' ";
				
				$tabela=ibase_query($conexao,$SQL);
				
				if (empty($tabela))
				{
					$sql="INSERT INTO USUARIOS (NOME, SENHA, TELEFONE, USUARIO) VALUES ('".strtoupper($_POST["NOME"])."', '".$_POST["senha"]."', '".$_POST["TELEFONE"]."',  '".$_POST["USUARIO"]."')";
					$tabela= ibase_query ($conexao, $sql);
					header("Location: https://192.168.100.77:5858");
				}else{
					
					$open=ibase_fetch_assoc($tabela); 
					session_start();
					$_SESSION["NOME"]=strtoupper($open["NOME"]);
				}
				
			}?>
		
		<?php }else{ ?>
			<table>
				<tr>
					<td colspan=2>
						<img src="/img/roobo.gif" id="ponto" width='500'height='500'>
					</td>
				</tr>
				<INPUT type="hidden" id="nome" VALUE="<?PHP ECHO $_SESSION["NOME"] . ", " . $TIPO?>">
				<tr>
					<td colspan=2>
						<h1 align="center">Modo de Automação</h1>
					</td>
				</tr>
				<tr>
				
			<?php
				echo "<tr><td colspan=2><h2 align='center'>Cozinha</h2></td></tr><tr><td width=1><button onclick='mensagem(1)' id='TIPO1' class='btn btn-success btn-lg btn-block'>Ligar</button></td>";
				echo "<td width=1><button onclick='mensagem(2)' class='btn btn-danger btn-lg btn-block' id='TIPO2'>Desligar</button></td></tr>";
				echo "<tr><td colspan=2><h2 align='center'>Quarto</h2></td></tr><tr><td width=1><button id='TIPO3' onclick='mensagem(3)' class='btn btn-success btn-lg btn-block'>Ligar</button></td>";
				echo "<td width=1><button onclick='mensagem(4)' class='btn btn-danger btn-lg btn-block' id='TIPO4'>Desligar</button></td></tr>";
				echo "<tr><td colspan=2><h2 align='center'>Quarto Auxiliar</h2></td></tr><tr><td width=1><button id='TIPO5'onclick='mensagem(5)' class='btn btn-success btn-lg btn-block'>Ligar</button></td>";
				echo "<td width=1><button onclick='mensagem(6)' class='btn btn-danger btn-lg btn-block' id='TIPO6'>Desligar</button></td></tr>";
				echo "<tr><td colspan=2><h2 align='center'>Modo Geral</h2></td></tr><tr><td width=1><button  id='TIPO7' onclick='mensagem(7)' class='btn btn-success btn-lg btn-block'>Ligar</button></td>";
				echo "<td width=1><button onclick='mensagem(8)' class='btn btn-danger btn-lg btn-block' id='TIPO8'>Desligar</button></td></tr>";
				echo "<td width=1><button onclick='mensagem(15)' class='btn btn-danger btn-lg btn-block' id='TIPO15'>Agendar</button></td></tr>";
				echo "<td width=1><button onclick='mensagem(16)' class='btn btn-danger btn-lg btn-block' id='TIPO16'>Limpar Agendar</button></td></tr>";
			?>

			</tr>
			<div class="row">
				  <div class="col s6">
					<p class="range-field">
					  <input type="hidden" id="rate" min="1" max="100" value="10" />
					</p>
				  </div>
				  <div class="col s6">
					<p class="range-field">
					  <input type="hidden" id="pitch" min="0" max="2" value="1" />
					</p>
				  </div>
				  <div class="col s12">
				  </div>
				</div>
				<div class="row">
				  <div class="input-field col s12">
					<input type='hidden' value='' id='message' class='materialize-textarea'>
				  </div>
				</div>
				<INPUT type="hidden"  id="speak">
			</table>
		<?php } ?>
	</div> 
<?php include "rodape.php" ?>	

<script>
	
   $(function(){
	  if ('speechSynthesis' in window) {
		speechSynthesis.onvoiceschanged = function() {
		  var $voicelist = $('#voices');

		  if($voicelist.find('option').length == 0) {
			speechSynthesis.getVoices().forEach(function(voice, index) {
			  var $option = $('<option>')
			  .val(index)
			  .html(voice.name + (voice.default ? ' (default)' :''));

			  $voicelist.append($option);
			});

			$voicelist.material_select();
		  }
		}
		
		$('#speak').click(function(){
		  var text = $('#message').val();
		  var msg = new SpeechSynthesisUtterance();
		  var voices = window.speechSynthesis.getVoices();
		  msg.voice = voices[$('#voices').val()];
		  msg.rate = $('#rate').val() / 10;
		  msg.pitch = $('#pitch').val();
		  msg.text = text;

		  msg.onend = function(e) {
			console.log('Finished in ' + event.elapsedTime + ' seconds.');
		  };

		  speechSynthesis.speak(msg);
		})
	  } else {
		$('#modal1').openModal();
	  }
	});
	
	$(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
          if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
            $('.fixed-plugin .dropdown').addClass('open');
          }

        }

        $('.fixed-plugin a').click(function(event) {
          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .active-color span').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
          }
        });

        $('.fixed-plugin .background-color .badge').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('background-color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-background-color', new_color);
          }
        });

        $('.fixed-plugin .img-holder').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).parent('li').siblings().removeClass('active');
          $(this).parent('li').addClass('active');


          var new_image = $(this).find("img").attr('src');

          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            $sidebar_img_container.fadeOut('fast', function() {
              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $sidebar_img_container.fadeIn('fast');
            });
          }

          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $full_page_background.fadeOut('fast', function() {
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
              $full_page_background.fadeIn('fast');
            });
          }

          if ($('.switch-sidebar-image input:checked').length == 0) {
            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
          }
        });

        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');

          $input = $(this);

          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }

            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }

            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }

            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }

            background_image = false;
          }
        });

        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');

          $input = $(this);

          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

          } else {

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

            setTimeout(function() {
              $('body').addClass('sidebar-mini');

              md.misc.sidebar_mini_active = true;
            }, 300);
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);

        });
      });
    });
  </script>
  <script>
    
	$(document).ready(function() {
      //init DateTimePickers
      md.initFormExtendedDatetimepickers();
	 });
	
  </script>
</body>
</html>