<section class="content">
	<div class="row">
		<!-- Controle -->
		<div class="col-md-3">
			<div class="box">
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<h3 class="text-center">Adicionar Integrantes</h3>
							<?php echo form_open('painel/grupo/meus_grupos/informacao/novo/' .$id_grupo) ?>

							<!-- Seleção de Integrante -->
							<div class="form-group has-feedback <?php if (form_error('user')) {echo " has-error ";};?>">
								<label class="control-label">Usuários</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-user-circle" aria-hidden="true"></i>
									</span>
									<select id="select" class="form-control" name="user">
										<option value="" disabled selected> </option>
										<?php
                      foreach ($tb_user as $linha) {
                        echo "<option value=" .$linha['id']. ">" .$linha['nome']. "</option>" ;
                      }
                      ?>
									</select>
								</div>
							</div>
							<?php echo form_error('user'); ?>
							<button type="submit" class="btn btn-primary text-center">Enviar</button>
							<?php echo form_close() ?>
						</div>
					</div>
				</div>

				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<h3 class="text-center">Remover Integrantes</h3>
							<?php echo form_open('painel/grupo/meus_grupos/informacao/remover/' .$id_grupo, ['id' => 'remover']) ?>

							<!-- Seleção de Integrante -->
							<div class="form-group has-feedback <?php if (form_error('user')) {echo " has-error ";};?>">
								<label class="control-label">Usuários</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-user-circle" aria-hidden="true"></i>
									</span>
									<select id="select2" class="form-control" name="user">
										<option value="" disabled selected> </option>
										<?php
                      foreach ($tb_grupo as $linha) {
                        echo "<option value=" .$linha['id']. ">" .$linha['nome']. "</option>" ;
                      }
                      ?>
									</select>
								</div>
							</div>
							<?php echo form_error('user'); ?>
							
							<?php echo form_close() ?>
							<button onclick="remover()" class="btn btn-danger text-center">Enviar</button>
						</div>
					</div>
				</div>

			</div>
		</div>

		<!-- Tabela -->
		<div class="col-md-6">
			<div class="box">
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">

							<h3 class="text-center">Integrantes do Grupo</h3>
							<table id="tabela_info" class="text-center" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Nome</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($tb_grupo as $tb) {
                            ?>
									<tr>
										<td>
											<?php echo $tb['nome'] ?>
										</td>
										<td>
											<?php  if($tb['user_status'] == 1){
                                    echo "Ativo";
                                    } else
                                    { echo "Inativo";
                                    } ?>
										</td>

									</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


</section>
