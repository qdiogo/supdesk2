
<style>
/* Refinamento visual do menu lateral; links e permissões permanecem inalterados. */
#accordionSidebar {
  background:linear-gradient(180deg,#172b4d 0%,#203a65 55%,#182e52 100%) !important;
  box-shadow:4px 0 18px rgba(18,35,63,.18);
}
#accordionSidebar .sidebar-brand { min-height:76px; padding:14px 10px; color:#fff; }
#accordionSidebar .sidebar-brand-text { font-size:15px; font-weight:800; letter-spacing:1.6px; }
#accordionSidebar .sidebar-brand-icon { color:#b9d4ff; }
#accordionSidebar .sidebar-heading { padding:12px 16px 7px; color:#a9c2e8; font-size:10px; font-weight:800; letter-spacing:1.1px; text-transform:uppercase; }
#accordionSidebar .sidebar-divider { margin:8px 14px; border-top:1px solid rgba(220,234,255,.15); }
#accordionSidebar .nav-item { margin:3px 9px; }
#accordionSidebar .nav-item .nav-link { display:flex; align-items:center; gap:9px; padding:11px 13px; border-radius:9px; color:rgba(245,248,255,.84); transition:background .18s ease,color .18s ease,transform .18s ease; }
#accordionSidebar .nav-item .nav-link i { width:18px; color:#a9c8f7; text-align:center; }
#accordionSidebar .nav-item .nav-link:hover { background:rgba(225,238,255,.12); color:#fff; transform:translateX(2px); }
#accordionSidebar .nav-item .nav-link.active { background:rgba(116,164,236,.22); color:#fff; box-shadow:inset 3px 0 #8dbaff; }
#accordionSidebar .collapse-inner { margin:2px 0 8px; padding:10px 8px !important; border:1px solid rgba(209,222,241,.8); border-radius:10px !important; box-shadow:0 7px 18px rgba(7,20,41,.16); }
#accordionSidebar .collapse-header { padding:5px 10px 8px; color:#73819a; font-size:10px; font-weight:800; letter-spacing:.8px; text-transform:uppercase; }
#accordionSidebar .collapse-item { display:flex; align-items:center; gap:8px; margin:2px 0; padding:8px 10px; border-radius:7px; color:#36445b; font-size:12px; transition:background .15s ease,color .15s ease; }
#accordionSidebar .collapse-item i { width:16px; color:#5579b6; text-align:center; }
#accordionSidebar .collapse-item:hover { background:#edf4ff; color:#234b91; text-decoration:none; }
#accordionSidebar #sidebarToggle { background:rgba(225,238,255,.2); }
#accordionSidebar #sidebarToggle:hover { background:rgba(225,238,255,.32); }
#accordionSidebar.toggled .sidebar-brand-text,
#accordionSidebar.toggled .sidebar-heading,
#accordionSidebar.toggled .sidebar-divider { display:none !important; }
#accordionSidebar.toggled .nav-item { margin:4px 6px; }
#accordionSidebar.toggled .nav-item .nav-link { display:flex; flex-direction:column; justify-content:center; gap:0; padding:12px 4px; text-align:center; }
#accordionSidebar.toggled .nav-item .nav-link span { display:none !important; }
#accordionSidebar.toggled .nav-item .nav-link i { width:auto; margin:0; font-size:16px; }
#accordionSidebar.toggled .collapse { display:none !important; }
#accordionSidebar.toggled .sidebar-brand { min-height:62px; }
@media (max-width:767px) {
  #accordionSidebar .nav-item { margin-left:6px; margin-right:6px; }
  #accordionSidebar .nav-item .nav-link { padding:10px 9px; }
}
</style>
<script>
document.addEventListener('click', function(event) {
  var elemento = event.target;
  while (elemento && elemento !== document) {
    if (elemento.matches && elemento.matches('#accordionSidebar.toggled .nav-item > .nav-link')) {
      event.preventDefault();
      event.stopPropagation();
      if (event.stopImmediatePropagation) event.stopImmediatePropagation();
      document.getElementById('accordionSidebar').classList.remove('toggled');
      return;
    }
    elemento = elemento.parentNode;
  }
});
</script>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">
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
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
	  <i class="fas fa-fw fa-cog"></i>
	  <span>Arquivos(Base)</span>
	</a>
	<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
	  <div class="bg-white py-2 collapse-inner rounded">
		<h6 class="collapse-header">Cadastros</h6>
		<a class="collapse-item" href="inicio"><i class="fas fa-user"></i> Inicio</a>
		<?php if ((($_SESSION["XNIVEL"])=="3") || (($_SESSION["XNIVEL"])=="4") || (($_SESSION["XNIVEL"])=="5")){ ?>
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
		<a class="collapse-item" href="chamados?TIPO=5"> <i class="fas fa-clipboard-check"></i> Chamados (Pendentes) </a>
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
		<?php if ((($_SESSION["XNIVEL"])=="3") || (($_SESSION["XNIVEL"])=="4") || (($_SESSION["XNIVEL"])=="5")){ ?>
			
			<a class="collapse-item" href="monitorrespostas"> <i class="fas fa-clipboard-check"></i> Monitor de Respostas </a>
		<?php } ?>
		<a class="collapse-item" href="financeiro"> <i class="fas fa-clipboard-check"></i> Despesas (Viagens) </a>
		
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
		<a class="collapse-item" href="filtrovalidade"> <i class="fas fa-chart-bar"></i> Controle Licença</a>
		<a class="collapse-item" href="dashboard_financeiro"> <i class="fas fa-clipboard-check"></i> Despesas Dashboard </a>
	  </div>
	</div>
  </li>
  
  
  
  <hr class="sidebar-divider d-none d-md-block">

  <div class="text-center d-none d-md-inline">
	<button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
