<style>
/* Estilo do topo alinhado ao painel azul; não altera links ou scripts. */
.topbar.navbar {
  min-height:64px;
  padding:0 18px;
  background-image:linear-gradient(110deg,#172b4d 0%,#253b80 52%,#456bd1 100%) !important;
  border:0;
  border-radius:0 0 12px 12px;
  box-shadow:0 5px 18px rgba(27,48,83,.18);
}
.topbar.navbar .nav-link { color:rgba(255,255,255,.9) !important; transition:background .18s ease,color .18s ease; }
.topbar.navbar .nav-link:hover, .topbar.navbar .nav-link:focus { color:#fff !important; background:rgba(255,255,255,.1); border-radius:8px; }
.topbar.navbar .topbar-divider { border-right:1px solid rgba(255,255,255,.24); height:34px; margin:auto 10px; }
.topbar.navbar #time { display:inline-block; margin:11px 12px 0; padding:7px 11px; border:1px solid rgba(255,255,255,.23); border-radius:20px; background:rgba(255,255,255,.1); color:#fff; font-size:12px; font-weight:600; white-space:nowrap; }
.topbar.navbar .badge-counter { border:2px solid #253b80; }
.topbar.navbar .dropdown-menu { border:1px solid #e5eaf2; border-radius:10px; box-shadow:0 10px 28px rgba(25,45,80,.18); overflow:hidden; }
.topbar.navbar .dropdown-header { background:#f2f6fd; color:#253b80; font-weight:700; }
.topbar.navbar .dropdown-item { padding-top:10px; padding-bottom:10px; }
.topbar.navbar .dropdown-item:hover { background:#edf4ff; }
.topbar.navbar .img-profile { width:34px; height:34px; object-fit:cover; border:2px solid rgba(255,255,255,.75); }

/* ===== BOTÕES RÁPIDOS HORIZONTAIS ===== */
.topbar.navbar .quick-bar{
  display:flex;
  align-items:center;
  gap:6px;
  margin:0 8px 0 6px;
  flex-wrap:nowrap;
  overflow-x:auto;
  scrollbar-width:none;
}
.topbar.navbar .quick-bar::-webkit-scrollbar{ display:none; }

.topbar.navbar .quick-bar .quick-btn{
  display:inline-flex;
  align-items:center;
  gap:5px;
  background:rgba(255,255,255,.14);
  color:#fff !important;
  border:1px solid rgba(255,255,255,.28);
  border-radius:18px;
  padding:6px 11px;
  font-size:11px;
  font-weight:700;
  letter-spacing:.2px;
  text-decoration:none;
  white-space:nowrap;
  transition:all .15s ease;
}
.topbar.navbar .quick-bar .quick-btn:hover,
.topbar.navbar .quick-bar .quick-btn:focus{
  background:rgba(255,255,255,.28);
  color:#fff !important;
  text-decoration:none;
  transform:translateY(-1px);
  box-shadow:0 3px 10px rgba(0,0,0,.18);
}
.topbar.navbar .quick-bar .quick-btn i{ font-size:12px; }
.topbar.navbar .quick-bar .quick-btn.q-success i{ color:#7ee88a; }
.topbar.navbar .quick-bar .quick-btn.q-primary i{ color:#8dbaff; }
.topbar.navbar .quick-bar .quick-btn.q-info i{ color:#8fdcff; }
.topbar.navbar .quick-bar .quick-btn.q-warning i{ color:#ffe066; }
.topbar.navbar .quick-bar .quick-btn.q-danger i{ color:#ff9b9b; }

@media (max-width:1199px){
  .topbar.navbar .quick-bar .quick-btn span{ display:none; }
  .topbar.navbar .quick-bar .quick-btn{ padding:7px 9px; }
}
@media (max-width:767px){
  .topbar.navbar { min-height:56px; padding:0 8px; border-radius:0 0 9px 9px; }
  .topbar.navbar #time { margin:8px 4px 0; padding:6px 8px; font-size:11px; }
  .topbar.navbar .topbar-divider { margin:0 4px; }
  .topbar.navbar .quick-bar{ gap:4px; margin:0 4px; }
  .topbar.navbar .quick-bar .quick-btn{ padding:6px 8px; font-size:10px; }
}
</style>

<nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 14px;">
  <!-- Sidebar Toggle (Topbar) -->
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>

  <!-- ===== BOTÕES RÁPIDOS HORIZONTAIS ===== -->
  <div class="quick-bar">
	<?php if (!empty($_SESSION["USUARIOX"])) {?>
		<a class="quick-btn q-success" href="/cliente_chamados?ATITUDE=0" title="Abrir Novo Chamado">
		  <i class="fas fa-plus-circle"></i>
		  <span>Novo Chamado</span>
		</a>

		<a class="quick-btn q-primary" href="cliente_chamados.php" title="Central de Chamados">
		  <i class="fas fa-clipboard-list"></i>
		  <span>Chamados Abertos</span>
		</a>

		<a class="quick-btn q-warning" href="cliente_chamados.php?TIPO=2" title="Chamados Fechados">
		  <i class="fas fa-check-circle"></i>
		  <span>Fechados</span>
		</a>

		<a class="quick-btn q-primary" href="/cliente_chamados.php?TIPO=3" title="Registro de Tarefas">
		  <i class="fas fa-tasks"></i>
		  <span>Em Pausa</span>
		</a>

	<?php }else{ ?>
		<a class="quick-btn q-success" href="chamados.php?ATITUDE=0" title="Abrir Novo Chamado">
		  <i class="fas fa-plus-circle"></i>
		  <span>Novo Chamado</span>
		</a>

		<a class="quick-btn q-primary" href="chamados" title="Central de Chamados">
		  <i class="fas fa-clipboard-list"></i>
		  <span>Chamados</span>
		</a>

		<a class="quick-btn q-info" href="chamados?TIPO=4" title="Meus Chamados">
		  <i class="fas fa-user-check"></i>
		  <span>Meus</span>
		</a>

		<a class="quick-btn q-warning" href="chamados?TIPO=2" title="Chamados Fechados">
		  <i class="fas fa-check-circle"></i>
		  <span>Fechados</span>
		</a>

		<a class="quick-btn q-primary" href="registro_tarefas?TIPO=1" title="Registro de Tarefas">
		  <i class="fas fa-tasks"></i>
		  <span>Tarefas</span>
		</a>

		<a class="quick-btn q-danger" href="lembretes.php" title="Lembretes">
		  <i class="fas fa-bell"></i>
		  <span>Lembretes</span>
		</a>

		<a class="quick-btn q-info" href="rel_produtividade_tecnico" title="Produtividade por Técnico">
		  <i class="fas fa-chart-bar"></i>
		  <span>Produtividade</span>
		</a>
	<?php } ?>
  </div>
  <!-- ===== FIM BOTÕES RÁPIDOS ===== -->

  <!-- Topbar Navbar -->
  <ul class="navbar-nav ml-auto">

    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
    <li class="nav-item dropdown no-arrow d-sm-none">
      <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-search fa-fw"></i>
      </a>
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
      <BR><BR>
      <div id="time">Tempo na página</div>
    </li>

    <!-- Nav Item - Alerts -->
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <span class="badge badge-danger badge-counter">3+</span>
      </a>
      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">Mensagens</h6>
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
      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
        <h6 class="dropdown-header">Lembretes</h6>
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
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline small" style="color: white;"><?PHP ECHO $_SESSION["NOME"]?></span>
        <?php
        $XSQL="SELECT FIRST 1 CAMINHO, TABELA FROM DOCUMENTOS WHERE TABELA='USUARIOS' AND  GRUPO=" . $rowXA["USUARIO1"] . " ORDER BY CODIGO DESC  " ;
        $FOTO=ibase_fetch_assoc(ibase_query($conexao,$XSQL));
        if (!empty($FOTO["CAMINHO"])){?>
          <img class="img-profile rounded-circle" src="/arquivos/<?PHP ECHO $FOTO["CAMINHO"]?>">
        <?php }else{ ?>
          <img class="img-profile rounded-circle" src="/img/fotouser.png">
        <?php } ?>
      </a>
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <?php if (!empty($_SESSION["USUARIOX"])){?>
          <a class="dropdown-item" href="usuarios_cliente">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Perfil
          </a>
        <?php } else { ?>
          <a class="dropdown-item" href="usuarios">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Perfil
          </a>
        <?php } ?>
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
        <?php } ?>
      </div>
    </li>

  </ul>

</nav>