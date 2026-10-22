<style>
/* Refinamento visual do menu lateral; links e permissões permanecem inalterados. */
#accordionSidebar {
  background:linear-gradient(180deg,#172b4d 0%,#203a65 55%,#182e52 100%) !important;
  box-shadow:4px 0 18px rgba(18,35,63,.18);
  width:15rem !important;
}
#accordionSidebar .sidebar-brand { min-height:70px; padding:12px 8px; color:#fff; overflow:hidden; }
#accordionSidebar .sidebar-brand-text { font-size:13px; font-weight:800; letter-spacing:.8px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:110px; }
#accordionSidebar .sidebar-brand-icon { color:#b9d4ff; flex-shrink:0; font-size:.95rem; }
#accordionSidebar .sidebar-heading { padding:11px 14px 6px; color:#a9c2e8; font-size:9px; font-weight:800; letter-spacing:1px; text-transform:uppercase; }
#accordionSidebar .sidebar-divider { margin:7px 12px; border-top:1px solid rgba(220,234,255,.15); }
#accordionSidebar .nav-item { margin:2px 7px; }
#accordionSidebar .nav-item .nav-link { display:flex; align-items:center; gap:8px; padding:9px 11px; border-radius:8px; color:rgba(245,248,255,.84); font-size:12px; transition:background .18s ease,color .18s ease,transform .18s ease; }
#accordionSidebar .nav-item .nav-link i { width:16px; font-size:12px; color:#a9c8f7; text-align:center; flex-shrink:0; }
#accordionSidebar .nav-item .nav-link:hover { background:rgba(225,238,255,.12); color:#fff; transform:translateX(2px); }
#accordionSidebar .nav-item .nav-link.active { background:rgba(116,164,236,.22); color:#fff; box-shadow:inset 3px 0 #8dbaff; }

#accordionSidebar .collapse-inner { margin:2px 0 6px; padding:6px 4px !important; border:1px solid rgba(209,222,241,.8); border-radius:8px !important; box-shadow:0 7px 18px rgba(7,20,41,.16); }
#accordionSidebar .collapse-header { padding:3px 6px 5px; color:#73819a; font-size:8px; font-weight:800; letter-spacing:.6px; text-transform:uppercase; }
#accordionSidebar .collapse-item {
  display:flex; align-items:center; gap:3px; margin:0; padding:5px 5px; border-radius:5px;
  color:#36445b; font-size:9px; line-height:1.15; white-space:nowrap;
  overflow:hidden; text-overflow:ellipsis;
  transition:background .15s ease, color .15s ease;
}
#accordionSidebar .collapse-item i { width:10px; color:#5579b6; text-align:center; flex-shrink:0; font-size:9px; }
#accordionSidebar .collapse-item:hover { background:#edf4ff; color:#234b91; text-decoration:none; }

#accordionSidebar #sidebarToggle { background:rgba(225,238,255,.2); }
#accordionSidebar #sidebarToggle:hover { background:rgba(225,238,255,.32); }

#accordionSidebar.toggled { width: 5rem !important; }
#accordionSidebar.toggled .sidebar-brand-text,
#accordionSidebar.toggled .sidebar-heading,
#accordionSidebar.toggled .sidebar-divider { display:none !important; }
#accordionSidebar.toggled .sidebar-brand { min-height:58px; }
#accordionSidebar.toggled .nav-item { margin:3px 4px; }
#accordionSidebar.toggled .nav-item .nav-link { display:flex; flex-direction:column; justify-content:center; gap:0; padding:10px 3px; text-align:center; }
#accordionSidebar.toggled .nav-item .nav-link span { display:none !important; }
#accordionSidebar.toggled .nav-item .nav-link i { width:auto; margin:0; font-size:15px; }
#accordionSidebar.toggled .collapse { display:none !important; }


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
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/cliente_chamados.PHP">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-desktop"></i>
    </div>
    <div class="sidebar-brand-text">SUP-DESK</div>
  </a>

  <hr class="sidebar-divider my-0">

  <hr class="sidebar-divider">

  <div class="sidebar-heading">Meus Chamados</div>

  <li class="nav-item active">
    <a class="nav-link" href="cliente_chamados.PHP">
      <i class="fas fa-play"></i>
      <span>Chamados (Abertos)</span>
    </a>
  </li>

  <li class="nav-item active">
    <a class="nav-link" href="cliente_chamados.php?TIPO=2">
      <i class="fas fa-times-circle"></i>
      <span>Chamados (Fechados)</span>
    </a>
  </li>

  <li class="nav-item active">
    <a class="nav-link" href="cliente_chamados.php?TIPO=3">
      <i class="fas fa-pause-circle"></i>
      <span>Chamados (Em Pausa)</span>
    </a>
  </li>

  <hr class="sidebar-divider">

  <li class="nav-item active">
    <a class="nav-link" href="cliente_chamados.php?ATITUDE=0">
      <i class="fas fa-plus-circle"></i>
      <span>Abrir Novo Chamado</span>
    </a>
  </li>

  <hr class="sidebar-divider d-none d-md-block">

  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>