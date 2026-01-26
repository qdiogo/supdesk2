<?php
// Cria uma nova imagem 400x200 com fundo branco
$largura = 400;
$altura = 200;
$imagem = imagecreatetruecolor($largura, $altura);

// Define as cores
$branco = imagecolorallocate($imagem, 255, 255, 255);
$preto  = imagecolorallocate($imagem, 0, 0, 0);

// Preenche o fundo
imagefilledrectangle($imagem, 0, 0, $largura, $altura, $branco);

// Texto com quebra de linha (\n)
$texto = "Diogo Costa\nCNPJ: 13.612.457/0001-07";

// Fonte padrão do PHP
$fonte = 5;

// Posição inicial
$x = 50;
$y = 70;

// Divide o texto em linhas
$linhas = explode("\n", $texto);

// Escreve cada linha
foreach ($linhas as $linha) {
    imagestring($imagem, $fonte, $x, $y, $linha, $preto);
    $y += imagefontheight($fonte) + 5; // espaçamento entre linhas
}

// Captura a imagem
ob_start();
imagepng($imagem);
$conteudo = ob_get_clean();

// Converte para Base64
$base64 = base64_encode($conteudo);

imagedestroy($imagem);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Imagem com várias linhas</title></head>
<body>
    <h3>Imagem com nome e CNPJ em Base64:</h3>
    <img src="data:image/png;base64,<?= $base64 ?>" alt="Imagem com texto">
</body>
</html>
