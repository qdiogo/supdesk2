
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background: #4682B4;">
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
		<div class="sidebar-brand-icon rotate-n-15">
			<i class="fas fa-desktop"></i>
		</div>
		<div class="sidebar-brand-text mx-3">FASTDATE</sup></div>
	</a>

  <hr class="sidebar-divider my-0">
	
  <!--<li class="nav-item active">
	<a class="nav-link" href="index.PHP">
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
			<a class="collapse-item" href="tipoprocedimento.asp"><i class="fas fa-user"></i> Tipo de Procedimento</a>
			<a class="collapse-item" href="tecnicos.asp"><i class="fas fa-user"></i> Usuário</a>
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
		<a class="collapse-item" href="registro_tarefas.asp"> <i class="fas fa-clipboard-check"></i> Gráfico Manual </a>
		<%
			if day(date) < 10 then
				dia="0" & day(date)
			else	
				dia=day(date)
			End if
			
			if month(date) < 10 then
				mes="0" & month(date)
			else	
				mes=month(date)
			End if
		%>
		<a class="collapse-item" href="metas_producao.asp?dd=<%=mes&dia&year(date)%>"> <i class="fas fa-chart-bar"></i> Metas de Produção </a>
	
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
		<a class="collapse-item" href="utilities-color.html">Autoriza??o</a>
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