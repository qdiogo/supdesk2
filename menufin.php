 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137);">
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="inicio.PHP">
	<div class="sidebar-brand-icon rotate-n-15">
	<i class="fa fa-align-left" aria-hidden="true"></i>

	</div>
	<div class="sidebar-brand-text mx-3">FINANCEIRO</sup></div>
  </a>

  <hr class="sidebar-divider my-0">

  <li class="nav-item active">
	<a class="nav-link" href="indexfin.PHP">
	  <i class="fas fa-fw fa-tachometer-alt"></i>
	  <span>Dashboard</span></a>
  </li>

  <hr class="sidebar-divider">

  <div class="sidebar-heading">
	Interface
  </div>

  <li class="nav-item">
	<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
	  <i class="fas fa-fw fa-cog"></i>
	  <span>Cadastros</span>
	</a>
	<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
	  <div class="bg-white py-2 collapse-inner rounded">
		<h6 class="collapse-header">Cadastros</h6>
		<a class="collapse-item" href="contas.php"><i class="fas fa-archway"></i> Contas</a>
		<a class="collapse-item" href="natureza.php"><i class="fas fa-archway"></i> Planos de Contas</a>
		<a class="collapse-item" href="ccusto.php"><i class="fas fa-archway"></i> C. Custo</a>
		<a class="collapse-item" href="clifor.php"> <i class="fas fa-book-reader"></i> Clifor</a>
		<a class="collapse-item" href="tipodocumento.php"> <i class="fas fa-book-medical"></i> Tipo Documento</a>
		<a class="collapse-item" href="TABELABANCO.php"><i class="fas fa-book-medical"></i> Tabela bancos</a>
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
		<h6 class="collapse-header"><i class="fas fa-undo-alt"></i> Movimentação:</h6>
		<a class="collapse-item" href="rp1.php?TIPO=P"><i class="fa fa-money" aria-hidden="true"></i> Contas A Pagar</a>
		<a class="collapse-item" href="rp1.php?TIPO=R"><i class="fa fa-money" aria-hidden="true"></i> Contas A Receber</a>	
		<a class="collapse-item" href="#">----------------</a>
		<a class="collapse-item" href="m1.php"><i class="fas fa-undo-alt"></i> Movimentação</a>
		<a class="collapse-item" href="baixa.php"><i class="fas fa-download"></i> Baixa de Titulos</a>
	  </div>
	</div>
  </li>
  
  
  <div class="sidebar-heading">
	Relatórios
  </div>

  <li class="nav-item">
	<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#relatorios" aria-expanded="true" aria-controls="collapsePages">
	  <i class="fas fa-fw fa-folder"></i>
	  <span><i class="far fa-chart-bar"></i> Relatórios </span>
	</a>
	<div id="relatorios" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
	  <div class="bg-white py-2 collapse-inner rounded">
		<h6 class="collapse-header">Analíticos:</h6>
		<a class="collapse-item" href="filtro_rp1.php"><i class="far fa-chart-bar"></i> Listagem de Contas a Pagar / Receber</a>
		<a class="collapse-item" href="filtroanalitico_contas.php"><i class="far fa-chart-bar"></i> Listagem de contas</a>
		<a class="collapse-item" href="filtro_sinteticocontas.php"><i class="far fa-chart-bar"></i> Listagem de Contas (Sintetico)</a>
	  </div>
	</div>
  </li>
  
  
  <!--<li class="nav-item">
	<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
	  <i class="fas fa-fw fa-wrench"></i>
	  <span>Ultilitarios</span>
	</a>
	<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
	  <div class="bg-white py-2 collapse-inner rounded">
		<h6 class="collapse-header">Ultilitarios:</h6>
		<a class="collapse-item" href="utilities-color.html">Autorização</a>
		<a class="collapse-item" href="utilities-border.html">Borders</a>
		<a class="collapse-item" href="utilities-animation.html">Animations</a>
		<a class="collapse-item" href="utilities-other.html">Other</a>
	  </div>
	</div>
  </li>
  
  <li class="nav-item">
	<a class="nav-link" href="charts.html">
	  <i class="fas fa-fw fa-chart-area"></i>
	  <span>Charts</span></a>
  </li>

  <li class="nav-item">
	<a class="nav-link" href="tables.html">
	  <i class="fas fa-fw fa-table"></i>
	  <span>Tables</span></a>
  </li>
  -->
  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
	<button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>