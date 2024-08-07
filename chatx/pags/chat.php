<script type="text/javascript">seta_status(true);</script>
<div class="title-chat">
  <div class="u-info"><i class="fas fa-chevron-left" onclick="seta_status(false)" id="backbtn"></i><img src="<?php $chat = new chat($pdo); echo $chat->dados_user($this->verifica_nomes_chat($explode['1']),"foto")?>"> <?php echo $chat->dados_user($this->verifica_nomes_chat($explode['1']),"nome")?>
  </div>
</div>
<input type="hidden" id="id_post" value="<?php echo $explode['1'];?>" >
<div class="msg_history" id="msghistory">
  <div id="mensagens"></div>
</div>

<div class="type_msg">
    <div class="input_msg_write">
      <form id="sendmsg" enctype="multipart/form-data">
        
		<input type="hidden" id="id_chat" value="<?php echo $explode['1'];?>" >
        <input type="text" class="write_msg" name="msg" id="msg" autocomplete="off" placeholder="Digite sua mensagem" />
		<!--<p><input type="file" id="userfile" class="preview form-control" name="userfile" class="form-control" accept="image/*" ></p>-->
        <button class="msg_send_btn" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
        <button class="msg_send_btn_file" data-toggle="modal" data-target="#exampleModal" type="button"><i class="fa fa-file" aria-hidden="true"></i></button>
		
		<input type="hidden" name="env" value="ms">
      </form>
      <?php
          $chat->atualiza_lido($explode['1']);
          //$chat->form_mensagem();
      ?>
    </div>
 </div>
 
 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content  alert alert-info">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Anexar um aruivo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post"  action="sys/upload_arquivoform.php" enctype="multipart/form-data">
			<input type="hidden" id="id_chat" name="id_chat" value="<?php echo $explode['1'];?>" ><br>
			Texto do Arquivo <br><input type="text" class="form-control" id="textarquivo" name="textarquivo" required value="Anexo de Arquivo" >
			Anexar um aruivo <br> <p><input type="file" name="userfile" class="form-control" required accept="image/*" required></p>
			<input type="hidden" name="env" value="ms">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Enviar</button>
		</form>
      </div>
    </div>
  </div>
</div>