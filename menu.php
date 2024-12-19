
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137);">
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
		<div class="sidebar-brand-icon rotate-n-15">
			<i class="fas fa-desktop"></i>
		</div>
		<div class="sidebar-brand-text mx-3">SUP-DESK</sup></div>
		
	</a>

  <hr class="sidebar-divider my-0">
	
  <!--<li class="nav-item active">
	<a class="nav-link" href="index">
	  <i class="fas fa-fw fa-tachometer-alt"></i>
	  <span>Dashboard</span></a>
  </li>-->

  <hr class="sidebar-divider">

  <div class="sidebar-heading">
	Interface
  </div>
  <li class="nav-item">
	<a class="nav-link collapsed in active" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
	  <i class="fas fa-fw fa-cog"></i>
	  <span>Arquivos(Base)</span>
	</a>
	<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
	  <div class="bg-white py-2 collapse-inner rounded">
		<h6 class="collapse-header">Cadastros</h6>
		<a class="collapse-item" href="inicio"><i class="fas fa-user"></i> Inicio</a>
		<?php if (($_SESSION["XNIVEL"])=="4"){ ?>
			<a class="collapse-item" href="tecnicos"><i class="fas fa-user"></i> Técnicos</a>
			<a class="collapse-item" href="Empresas"> <i class="fab fa-buffer"></i> Empresas</a>
		<?php } ?> 
		<a class="collapse-item" href="categorias"> <i class="fab fa-buffer"></i> Categorias</a>
		<a class="collapse-item" href="setor"> <i class="fab fa-buffer"></i> Setor</a>
	  </div>
	</div>
  </li>



  <hr class="sidebar-divider">

  <div class="sidebar-heading">
	Modulos
  </div>

  <li class="nav-item">
	<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
	  <i class="fas fa-fw fa-folder"></i>
	  <span>Modulos</span>
	</a>
	<div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
	  <div class="bg-white py-2 collapse-inner rounded">
		<h6 class="collapse-header">Modulo</h6>
		<a class="collapse-item" href="chamados"> <i class="fas fa-clipboard-check"></i> Chamados </a>
		<a class="collapse-item" href="chamados?TIPO=2"> <i class="fas fa-clipboard-check"></i> Chamados (Fechados) </a>
		<a class="collapse-item" href="chamados?TIPO=3"> <i class="fas fa-clipboard-check"></i> Chamados (Pausa) </a>
		<a class="collapse-item" href="chamados?TIPO=4"> <i class="fas fa-clipboard-check"></i> Meus Chamados </a>
		<a class="collapse-item" href="chamados?TIPO=1"> <i class="fas fa-clipboard-check"></i> Agendados </a>
		<a class="collapse-item" href="indexc?TIPO=1"> <i class="fas fa-clipboard-check"></i> Rotinas </a>
		<a class="collapse-item" href="registro_tarefas?TIPO=1"> <i class="fas fa-clipboard-check"></i> Registro de Tarefas </a>
		<a class="collapse-item" href="bloco"> <i class="fas fa-clipboard-check"></i> Bloco Anotações  </a>
		<a class="collapse-item" href="QUADROS"> <i class="fas fa-clipboard-check"></i> Quadros/Rotinas  </a>
		<a class="collapse-item" href="BOOT"> <i class="fas fa-clipboard-check"></i> Atendimento Eletronico  </a>
		<a class="collapse-item" href="sobreaviso_chamados"> <i class="fas fa-clipboard-check"></i> Sobreaviso </a>
		<a class="collapse-item" href="controlevalidade"> <i class="fas fa-clipboard-check"></i> Controle </a>
		<?php if ((($_SESSION["XNIVEL"])=="3") || (($_SESSION["XNIVEL"])=="4")){ ?>
			
			<a class="collapse-item" href="monitorrespostas"> <i class="fas fa-clipboard-check"></i> Monitor de Respostas </a>
			<a class="collapse-item" href="financeiro"> <i class="fas fa-clipboard-check"></i> Despesas (Viagens) </a>
		<?php } ?>
	  </div>
	</div>
  </li>
  
  
  <div class="sidebar-heading">
	Relatórios<i class="fas fa-chart-bar"></i>
  </div> 

  <li class="nav-item">
	<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#relatorios" aria-expanded="true" aria-controls="collapsePages">
	  <i class="fas fa-fw fa-folder"></i>
	  <span>Relatório</span>
	</a>
	<div id="relatorios" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
	  <div class="bg-white py-2 collapse-inner rounded">
		<h6 class="collapse-header">Anal??o:</h6>
		<a class="collapse-item" href="filtro_chamados"> <i class="fas fa-chart-bar"></i> Rel por Chamados</a>
		<a class="collapse-item" href="FILTRO_CHAMADOSPDF"> <i class="fas fa-chart-bar"></i> Rel por Chamados (PDF)</a>
		<a class="collapse-item" href="FILTRO_TAREFAS"> <i class="fas fa-chart-bar"></i> Rel de Tarefas (PDF)</a>
		<a class="collapse-item" href="FILTRO_SOBREAVISOPDF"> <i class="fas fa-chart-bar"></i> Sobreaviso Rel (PDF)</a>
	  </div>
	</div>
  </li>
  
  
  
  <hr class="sidebar-divider d-none d-md-block">

  <div class="text-center d-none d-md-inline">
	<button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>