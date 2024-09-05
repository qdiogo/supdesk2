
<nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 14px;">
	  <!-- Sidebar Toggle (Topbar) -->
	  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
		<i class="fa fa-bars"></i>
	  </button>
	  <!-- Topbar Navbar -->
	  <ul class="navbar-nav ml-auto">

		<!-- Nav Item - Search Dropdown (Visible Only XS) -->
		<li class="nav-item dropdown no-arrow d-sm-none">
		  <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-search fa-fw"></i>
		  </a>
		  <!-- Dropdown - Messages -->
		  <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
			<form class="form-inline mr-auto w-100 navbar-search">
			  <div class="input-group">
				<input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
				<div class="input-group-append">
				  <button class="btn btn-primary" type="button">
					<i class="fas fa-search fa-sm"></i>
				  </button>
				</div>
			  </div>
			</form>
		  </div>
		</li>
		<li>
		</li>
		<li>
			<BR><BR>
			<div id="time">Tempo na página</div>
		</li>
		<!-- Nav Item - Alerts -->
		<li class="nav-item dropdown no-arrow mx-1">
		  <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-bell fa-fw"></i>
			<!-- Counter - Alerts -->
			<span class="badge badge-danger badge-counter">3+</span>
		  </a>
		  <!-- Dropdown - Alerts -->
		  <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
			<h6 class="dropdown-header">
			  Mensagens
			</h6>
			<a class="dropdown-item d-flex align-items-center" href="#">
			  <div class="mr-3">
				<div class="icon-circle bg-primary">
				  <i class="fas fa-file-alt text-white"></i>
				</div>
			  </div>
			  <div>
				<div class="small text-gray-500">Processo Finalizado</div>
				<span class="font-weight-bold">Teste!</span>
			  </div>
			</a>
			
			<a class="dropdown-item text-center small text-gray-500" href="#">Abrir todos os Alertas</a>
		  </div>
		</li>

		<!-- Nav Item - Messages -->
		<li class="nav-item dropdown no-arrow mx-1">
		  <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-envelope fa-fw"></i>
			<!-- Counter - Messages -->
			<span class="badge badge-danger badge-counter"><?php echo $_SESSION["LEMBRETES"]?></span>
		  </a>
		  <?PHP
			$DATA="";
			$DATA=date("Y/m/d");
			$SQLB="SELECT CODIGO, TITULO, RESPONSAVEL, (SELECT NOME FROM TECNICOS WHERE CODIGO=USUARIO1) AS NOMECRIOU, USUARIO1, CAST(OBSERVACAO AS VARCHAR(2000)) AS OBSERVACAO, DATA, HORA, (SELECT FANTASIA FROM EMPRESAS WHERE CODIGO=CLIENTE) AS NOMECLIENTE FROM MARCACAO WHERE DATA='".$DATA."' and TECNICO='".$_SESSION["USUARIO"]."'";
			$tabelaSI=ibase_query($conexao,$SQLB); 
			$_SESSION["LEMBRETES"]="";
			$B=0;
			while ($rowXA=ibase_fetch_assoc($tabelaSI)){
			$B=$B + 1;
			$_SESSION["LEMBRETES"]=$B;
			$XSQL="SELECT FIRST 1 CAMINHO, TABELA FROM DOCUMENTOS WHERE TABELA='USUARIOS' AND  GRUPO=" . $rowXA["USUARIO1"] . " ORDER BY CODIGO DESC  " ; 
			$FOTO=ibase_fetch_assoc(ibase_query($conexao,$XSQL));
		  ?>
		  <!-- Dropdown - Messages -->
		  <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
			<h6 class="dropdown-header">
			  Lembretes
			</h6>
			<a class="dropdown-item d-flex align-items-center" href="lembretes.php">
			  <div class="dropdown-list-image mr-3">
			  	<?php if (!empty($FOTO["CAMINHO"])){?>
					<img class="img-profile rounded-circle" src="/arquivos/<?PHP ECHO $FOTO["CAMINHO"]?>">
				<?php }else{ ?>
					<img class="img-profile rounded-circle" src="/img/fotouser.png"> <?PHP ECHO $rowXA["NOMECRIOU"]?>
				<?php } ?>
				<div class="status-indicator bg-success"></div>
			  </div>
			  <div class="font-weight-bold">
				<div class="text-truncate"><?php echo $rowXA["TITULO"]?>: <?php echo $rowXA["DATA"]?>-<?php echo $rowXA["HORA"]?>.</div>
			</div>
			 
			</a>
			<br><br>
		  </div>
		  <?php } ?>
		</li>

		<div class="topbar-divider d-none d-sm-block"></div>

		<!-- Nav Item - User Information -->
		<li class="nav-item dropdown no-arrow" >
		  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<span class="mr-2 d-none d-lg-inline  small" style="color: white;"><?PHP ECHO $_SESSION["NOME"]?></span>
			<?php 
			$XSQL="SELECT FIRST 1 CAMINHO, TABELA FROM DOCUMENTOS WHERE TABELA='USUARIOS' AND  GRUPO=" . $rowXA["USUARIO1"] . " ORDER BY CODIGO DESC  " ; 
			$FOTO=ibase_fetch_assoc(ibase_query($conexao,$XSQL));
			if (!empty($FOTO["CAMINHO"])){?>
				<img class="img-profile rounded-circle" src="/arquivos/<?PHP ECHO $FOTO["CAMINHO"]?>">
			<?php }else{ ?>
				<img class="img-profile rounded-circle" src="/img/fotouser.png">
			<?php } ?>
		  </a>
		  <!-- Dropdown - User Information -->
		  <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
			<a class="dropdown-item" href="usuarios_cliente.php?ATITUDE=<?PHP ECHO $_SESSION["USUARIO"]?>">
			  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
			  Perfil
			</a>
			<?php  if (!empty($_SESSION["USUARIOX"])) { ?>   
				<a class="dropdown-item" href="saircliente.php">
				  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
				  Sair
				</a>
			<?php }else{ ?> 
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="sair.php">
				  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
				  Sair
				</a>
			<?php }	?> 
		  </div>
		</li>

	  </ul>

	</nav>