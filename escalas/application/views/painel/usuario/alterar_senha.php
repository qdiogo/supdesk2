<section class="content">
  <div class="row">
    <div class="col-md-6 col-offset-md-6">
      <div class="box">
        <div class="box-body">
          <?php
          // Mostra mensagem de alerta
          if (isset($msg_banco)) {
          echo '<div class="' . $msg_banco['tipo'] . '" role="alert">' . $msg_banco['msg'] . '</div>';
          }?>
          <?php echo form_open('painel_controle/usuario/alterar/senha/' .$tb_user['id']) ?>
          
          <!-- Linha 1 -->
          <div class="row">
            <!-- Coluna 1 -->
            <div class="col-md-12">
              <!-- Senha Antiga -->
              <div class="form-group has-feedback <?php if (form_error('senha_a')) {echo " has-error ";};?>">
                <label class="control-label">Antiga</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-key"></i>
                  </span>
                  <input type="password" class="form-control" name="senha_a" >
                </div>
                <?php echo form_error('senha_a'); ?>
              </div>
              </div>
              <!-- ./Coluna 1 -->
            </div>
            <!-- ./Linha 1 -->

            <!-- Linha 2 -->
          <div class="row">
            <!-- Coluna 1 -->
            <div class="col-md-12">
              <!-- Senha Antiga -->
              <div class="form-group has-feedback <?php if (form_error('senha_n')) {echo " has-error ";};?>">
                <label class="control-label">Nova</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-key"></i>
                  </span>
                  <input type="password" class="form-control" name="senha_n">
                </div>
              </div>
                <?php echo form_error('senha_n'); ?>
              </div>
              <!-- ./Coluna 1 -->
            </div>
            <!-- ./Linha 2 -->

            <!-- Linha 3 -->
          <div class="row">
            <!-- Coluna 1 -->
            <div class="col-md-12">
              <!-- Senha Antiga -->
              <div class="form-group has-feedback <?php if (form_error('senha_c')) {echo " has-error ";};?>">
                <label class="control-label">Confirma</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-key"></i>
                  </span>
                  <input type="password" class="form-control" name="senha_c">
                </div>
              </div>
                <?php echo form_error('senha_c'); ?>
              </div>
              <!-- ./Coluna 1 -->
            </div>
            <!-- ./Linha 3 -->

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

