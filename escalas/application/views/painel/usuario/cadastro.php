<section class="content">
  <div class="row">
    <div class="col-md-7 col-offset-md-5">
      <div class="box">
        <div class="box-body">
          <?php
          // Mostra mensagem de alerta
          if (isset($msg_banco)) {
          foreach ($msg_banco as $msg) {
            echo $msg;
          }
          }?>
          <?php echo form_open('painel_controle/cadastrar/usuario') ?>
          <!-- Linha 1 -->
          <div class="row">
            <!-- Coluna 1 -->
            <div class="col-md-12">
              <!-- Nome -->
              <div class="form-group has-feedback <?php if (form_error('nome')) {echo " has-error ";};?>">
                <label class="control-label">Nome</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-user" aria-hidden="true"></i>
                  </span>
                  <input type="text" class="form-control" placeholder="Nome Completo" name="nome" value=<?php echo set_value( 'nome') ?>>
                </div>
                <?php echo form_error('nome'); ?>
              </div>
              <!-- ./Coluna 1 -->
            </div>
            <!-- ./Linha 1 -->
          </div>
          <!-- Linha 2 -->
          <div class="row">
            <!-- Coluna 1  -->
            <div class="col-md-12">
              <!-- Email -->
              <div class="form-group has-feedback <?php if (form_error('email')) {echo " has-error ";};?>">
                <label class="control-label">Email</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                  </span>
                  <input type="email" class="form-control" placeholder="Email" name="email" value=<?php echo set_value( 'email') ?>>
                </div>
                <?php echo form_error('email'); ?>
              </div>
              <!-- ./Coluna 1 -->
            </div>
            <!-- ./Linha 2 -->
          </div>
          <!-- Linha 3 -->
          <div class="row">
            <!-- Coluna 1 -->
            <!-- CPF -->
            <div class="col-md-6">
              <div class="form-group has-feedback <?php if (form_error('cpf')) {echo " has-error ";};?>">
                <label class="control-label">CPF</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-id-card" aria-hidden="true"></i>
                  </span>
                  <input id="cpf" type="text" class="form-control" placeholder="CPF" name="cpf" value=<?php echo set_value( 'cpf') ?>>
                  </div>
                <?php echo form_error('cpf'); ?>
              </div>
              <!-- ./Coluna 1 -->
            </div>
            <!-- Coluna 2 -->
            <div class="col-md-6">
              <!-- Numero do CRM -->
              <div class="form-group has-feedback <?php if (form_error('crm')) {echo " has-error ";};?>">
                <label class="control-label">CRM</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-user-md" aria-hidden="true"></i>
                  </span>
                  <input type="text" class="form-control" placeholder="CRM" name="crm" value=<?php echo set_value( 'crm') ?>>
                </div>
                <?php echo form_error('crm'); ?>
              </div>
              <!-- ./Coluna 2 -->
            </div>
            <!-- ./Linha 3 -->
          </div>
          <!-- Linha 4 -->
          <div class="row">
            <!-- Coluna 1 -->
            <div class="col-md-6">
              <!-- Data de Nascimento -->
              <div class="form-group has-feedback <?php if (form_error('dt_nascimento')) {echo " has-error ";};?>">
                <label class="control-label">Data de Nascimento</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                  </span>
                  <input type="date" class="form-control" placeholder="Data de Nascimento" name="dt_nascimento" value=<?php echo set_value( 'dt_nascimento') ?>>
                </div>
                <?php echo form_error('dt_nascimento'); ?>
              </div>
            </div>
              <!-- ./Coluna 1 -->

              <!-- Coluna 2 -->
              <div class="col-md-6">
                <div class="form-group has-feedback <?php if (form_error('tipo')) {echo " has-error ";};?>">
                <label class="control-label">Tipo de Conta</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                  </span>
                  <select class="form-control " placeholder="Grupo" name="tipo">
                    <option value="" disabled selected>Tipo de Conta</option>
                    <option value="0" <?php if (set_value( 'tipo')=="0" ) {echo "selected";}?>
                    >Administrador</option>
                    <option value="1" <?php if (set_value( 'tipo')=="1" ) {echo "selected";}?>
                    >Usuário</option>
                    <option value="2" <?php if (set_value( 'tipo')=="0" ) {echo "selected";}?>
                    >Administrador Grupo</option>
                  </select>
                </div>
                <?php echo form_error('tipo'); ?>
                <!-- ./Coluna 2 -->
                </div>
              </div>
            <!-- ./Linha 4 -->
          </div>
          
          
            <!-- ./Linha 6 -->
          </div>
          <div class="row">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Enviar</button>
            </div>
            <!-- /.col -->
          </div>
          <?php echo form_close() ?>
        </div>
      </div>
    </div>
  </div>
</section>