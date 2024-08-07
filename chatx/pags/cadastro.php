<div class="row">
	<div class="col-sm-5 cadastro-form" style="background-color: #FFF">
		<h4>Cadastre-se</h4>
		<p class="small"></p>
		<hr>
		<form method="POST" enctype="multipart/form-data">
			<p><input type="text" name="nome" class="form-control" placeholder="Seu nome" required></p>
			<p><input type="text" name="usuario" class="form-control" placeholder="Usuário"  required></p>
			<p><input type="email" name="email" class="form-control" placeholder="Email"  required></p>
			<p><input type="password" name="senha" class="form-control" placeholder="Senha"  required></p>
			<p><label>Grupo de trabalho</label>
			<select class="form-control" name="sexo" required>
				<option value="10">Enfermagem</option>
				<option value="11">Médico</option>
				<option value="91">Suicidio</option>
				<option value="92">Integração</option>
			</select>
			</p><label>Imagem de perfil</label>
			<p><input type="file" name="userfile" class="form-control" accept="image/*" required></p>
			<input type="submit" value="Cadastrar" class="btn btn-outline-success btn-lg btn-block">
			<input type="hidden" name="env" value="cad">
		</form><br>
		<?php $chat = new chat($pdo); $chat->cadastro();?>
	</div>
	
</div>