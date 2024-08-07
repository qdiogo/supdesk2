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

          if (isset($_REQUEST)){
              $tb_user['nome'] = $_REQUEST['nome'];
              $tb_user['email'] = $_REQUEST['email'];
              $tb_user['cpf'] = $_REQUEST['cpf'];
              $tb_user['crm'] = $_REQUEST['crm'];
			  $tb_user['dt_nascimento'] = $_REQUEST['dt_nascimento'];
			  $tb_user['tipo'] = $_REQUEST['tipo'];
          }
          }?>
						<?php echo form_open('painel_controle/usuario/alterar/'.$tb_user['id'])  ?>
						<div class="row">
							<div class="col-md-12">
								<!-- Nome -->
								<div class="form-group has-feedback <?php if (form_error('nome')) {echo " has-error ";};?>">
									<label class="control-label">Nome</label>
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-user" aria-hidden="true"></i>
										</span>
										<input type="text" class="form-control" placeholder="Nome Completo" name="nome" value="<?php echo $tb_user['nome'] ?>">
									</div>
								</div>
								<?php echo form_error('nome'); ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<!-- Email -->
								<div class="form-group has-feedback <?php if (form_error('email')) {echo " has-error ";};?>">
									<label class="control-label">Email</label>
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-envelope" aria-hidden="true"></i>
										</span>
										<input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $tb_user['email'] ?>">
									</div>
								</div>
								<?php echo form_error('email'); ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<!-- CPF -->
								<div class="form-group has-feedback <?php if (form_error('cpf')) {echo " has-error ";};?>">
									<label class="control-label">CPF</label>
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-id-card" aria-hidden="true"></i>
										</span>
										<input id="cpf" type="text" class="form-control" placeholder="CPF" name="cpf" value="<?php echo $tb_user['cpf'] ?>">
									</div>
								</div>
								<?php echo form_error('cpf'); ?>
							</div>
							<div class="col-md-6">
								<!-- Numero do CRM -->
								<div class="form-group has-feedback <?php if (form_error('crm')) {echo " has-error ";};?>">
									<label class="control-label">CRM</label>
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-user-md" aria-hidden="true"></i>
										</span>
										<input type="text" class="form-control" placeholder="CRM" name="crm" value="<?php echo $tb_user['crm'] ?>">
									</div>
								</div>
								<?php echo form_error('crm'); ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<!-- Data de Nascimento -->
								<div class="form-group has-feedback <?php if (form_error('dt_nascimento')) {echo " has-error ";};?>">
									<label class="control-label">Data de Nascimento</label>
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-calendar" aria-hidden="true"></i>
										</span>
										<input type="date" class="form-control" placeholder="Data de Nascimento" name="dt_nascimento" value="<?php echo $tb_user['dt_nascimento'] ?>">
									</div>
									<?php echo form_error('dt_nascimento'); ?>
								</div>
							</div>
							<div class="col-md-6">
								<!-- Status da conta -->
								<div class="form-group has-feedback <?php if (form_error('status')) {echo " has-error ";};?>">
									<label class="control-label">Status da Conta</label>
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-user-circle" aria-hidden="true"></i>
										</span>
										<select class="form-control" placeholder="Grupo" name="status">
											<option value="" disabled selected>Status da Conta</option>
											<option value="1" <?php if ($tb_user[ 'status']=="1" ) {echo "selected";}?>
												>Ativar</option>
											<option value="2" <?php if ($tb_user[ 'status']=="2" ) {echo "selected";}?>
												>Bloquear</option>
										</select>
									</div>
									<?php echo form_error('status'); ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<!-- Tipo de Conta -->
								<div class="form-group has-feedback <?php if (form_error('tipo')) {echo " has-error ";};?>">
									<label class="control-label">Tipo de Conta</label>
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-user-circle" aria-hidden="true"></i>
										</span>
										<select class="form-control" placeholder="Grupo" name="tipo">
											<option value="" disabled selected>Tipo de Conta</option>
											<option value="0" <?php if ($tb_user[ 'tipo']=="0" ) {echo "selected";}?>
												>Administrador</option>
											<option value="1" <?php if ($tb_user[ 'tipo']=="1" ) {echo "selected";}?>
												>Usuário</option>
											<option value="2" <?php if (set_value( 'tipo')=="2" ) {echo "selected";}?>
												>Administrador Grupo</option>
										</select>
									</div>
								</div>
								<?php echo form_error('tipo'); ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<!-- Reset Senha -->
								<div class="form-group has-feedback">
									<label class="control-label">Resetar Senha?</label>
									<div class="input-group">
										<input type="checkbox" class="minimal" name="reset" value="1">
									</div>
								</div>
								<?php echo form_error('reset'); ?>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<button type="submit" class="btn btn-primary btn-block btn-flat" name="btn_alt" value="Alterar">Enviar</button>
							</div>
							<?php echo form_close() ?>
						</div>
				</div>
			</div>
		</div>
</section>