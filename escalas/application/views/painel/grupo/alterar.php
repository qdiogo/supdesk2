<section class="content">
  <div class="row">
    <div class="col-md-6 col-offset-md-6">
      <div class="box">
        <div class="box-body">
          <?php
          // Mostra mensagem de alerta
          if (isset($msg_banco)) {
          foreach ($msg_banco as $msg) {
            echo $msg;
          }
          if (isset($_REQUEST)){
              $tb_grupo['nome'] = $_REQUEST['nome'];
              $tb_grupo['id_user_admin'] = $_REQUEST['admin'];
              $tb_grupo['visualizar'] = $_REQUEST['visualizar'];
          }

          }?>
            <?php echo form_open('painel_controle/grupo/alterar/'.$tb_grupo['id'])?>
            <div class="row">
              <div class="col-md-12">
                <!-- Nome do Grupo -->
                <div class="form-group has-feedback <?php if (form_error('nome')) {echo " has-error ";};?>">
                  <label class="control-label">Nome</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-group"></i></span>
                    <input type="text" class="form-control" name="nome" value="<?php echo $tb_grupo['nome'] ?>">
                  </div>
                  <?php echo form_error('nome'); ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <!-- Administrador do Grupo -->
                <div class="form-group has-feedback <?php if (form_error('admin')) {echo " has-error ";};?>">
                  <label class="control-label">Administrador</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-user-circle" aria-hidden="true"></i>
                    </span>
                    <select class="form-control" name="admin">
                      <option value="" disabled selected>Administrador</option>
                      <?php
                      foreach ($user_admin as $linha) {
                        if($linha['id'] == $tb_grupo['id_user_admin']){
                        echo "<option value=" .$linha['id']. " selected >" .$linha['nome']. "</option>" ;
                        }
                        else {
                        echo "<option value=" .$linha['id']. ">" .$linha['nome']. "</option>" ;
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <?php echo form_error('tipo'); ?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <!-- Visualizar outros grupos -->
                <div class="form-group has-feedback">
                  <label class="control-label">Pode visualizar Outros Grupos?</label>
                  <div class="input-group">
                    <p>
                      <label class="minimal">Sim</label>
                      <input type="radio" class="minimal" name="visualizar" value="1" <?php if ($tb_grupo['visualizar'] == 1){ echo "checked";}?>>
                      <label class="minimal"> Não</label>
                      <input type="radio" class="minimal" name="visualizar" value="0" <?php if ($tb_grupo['visualizar'] == 0){ echo "checked";}?>>
                    </p>
                  </div>
                </div>
                <?php echo form_error('reset'); ?>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Enviar</button>
              </div>
            </div>
            <?php echo form_close() ?>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>