<script>
	window.onload = function enviarmensagem(numero, mensagem)
	{
		w = screen.width;
		h = screen.height;
		meio1 = (h-570)/2;
		meio2 = (w-780)/2;
		
		location.href='https://wa.me/55<?php echo $_GET["numero"]?>?text=<?php echo $_GET["text"]?>';
		location.href='https://wa.me/55<?php echo $_GET["numero"]?>?text=<?php echo $_GET["text"]?>';
	}
</script>