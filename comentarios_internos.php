<?php
ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);
include "conexao.php";

$grupo = isset($_REQUEST["GRUPO"]) ? (int)$_REQUEST["GRUPO"] : 0;
if ($grupo <= 0) {
    http_response_code(400);
    exit("Parâmetro GRUPO inválido.");
}

$ACESSO = "Timeline de Comentários";
$mensagemErro = "";
$mensagemOk = "";
$tecnicoOrigem = isset($_SESSION["USUARIO"]) ? (int)$_SESSION["USUARIO"] : 0;
$comentarioDigitado = "";
$paraSelecionado = 0;
$imagemDataUrl = "";

function h($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES, "UTF-8");
}

function lerBlobBase64($conexao, $valorBlob) {
    if ($valorBlob === null || $valorBlob === false || $valorBlob === "") {
        return "";
    }
    if (is_string($valorBlob) && strpos($valorBlob, "data:image/") === 0) {
        return $valorBlob;
    }
    $handle = @ibase_blob_open($conexao, $valorBlob);
    if (!$handle) {
        return "";
    }
    $conteudo = "";
    while (true) {
        $parte = ibase_blob_get($handle, 8192);
        if ($parte === false || $parte === "") {
            break;
        }
        $conteudo .= $parte;
    }
    ibase_blob_close($handle);
    return $conteudo;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $comentario = isset($_POST["COMENTARIO"]) ? trim($_POST["COMENTARIO"]) : "";
    $para = isset($_POST["PARA"]) ? (int)$_POST["PARA"] : 0;
    $imagemDataUrl = isset($_POST["IMAGEM_BASE64"]) ? trim($_POST["IMAGEM_BASE64"]) : "";
    /* Mantém os valores no formulário quando há erro de validação ou gravação. */
    $comentarioDigitado = isset($_POST["COMENTARIO"]) ? $_POST["COMENTARIO"] : "";
    $paraSelecionado = $para;

    if ($comentario === "") {
        $mensagemErro = "Digite o comentário.";
    } elseif (strlen($comentario) > 2000) {
        $mensagemErro = "O comentário não pode ultrapassar 2.000 caracteres.";
    } elseif ($para <= 0) {
        $mensagemErro = "Selecione o técnico destinatário.";
    } elseif ($tecnicoOrigem <= 0) {
        $mensagemErro = "Não foi possível identificar o técnico que está realizando a transferência. Entre novamente no sistema.";
    }

    if ($mensagemErro === "" && $imagemDataUrl !== "") {
        if (!preg_match('/^data:image\/(png|jpeg|jpg|gif|webp);base64,([A-Za-z0-9+\/=\r\n]+)$/', $imagemDataUrl, $m)) {
            $mensagemErro = "Imagem inválida. Cole novamente a captura.";
        } else {
            $bytesImagem = base64_decode($m[2], true);
            if ($bytesImagem === false || @getimagesizefromstring($bytesImagem) === false) {
                $mensagemErro = "Não foi possível validar a imagem colada.";
            } elseif (strlen($bytesImagem) > 5 * 1024 * 1024) {
                $mensagemErro = "A imagem excede o limite de 5 MB.";
            }
        }
    }

    if ($mensagemErro === "") {
        $dataSql = date("Y-m-d");
        $horaSql = date("H:i:s");

        /* Busca o cliente associado ao chamado, como fazia o INSERT antigo. */
        $sqlCliente = "SELECT CLIENTE FROM CHAMADOS WHERE CODIGO=" . (int)$grupo;
        $resCliente = @ibase_query($conexao, $sqlCliente);
        $rowCliente = $resCliente ? ibase_fetch_assoc($resCliente) : false;
        $clienteChamado = ($rowCliente && isset($rowCliente["CLIENTE"])) ? (int)$rowCliente["CLIENTE"] : 0;

        if (!$rowCliente) {
            $mensagemErro = "Não foi possível localizar o cliente associado a este chamado.";
        } else {
            /* Mantém os campos históricos antigos e grava também a imagem como BLOB. */
            $sqlInsert = "INSERT INTO COMENTARIOS_INTERNOS
                (GRUPO, DATAALTERACAO, HORAALTERACAO, TECNICO, CLIENTE, COMENTARIO, PARA, IMAGEM)
                VALUES (?, ?, ?, ?, ?, ?, ?, CAST(? AS BLOB SUB_TYPE TEXT))";
            $stmt = @ibase_prepare($conexao, $sqlInsert);
        }

        if ($mensagemErro === "" && !$stmt) {
            $mensagemErro = "Falha ao preparar INSERT. Verifique se CLIENTE, TECNICO e IMAGEM existem e se IMAGEM é BLOB SUB_TYPE TEXT.";
        } elseif ($mensagemErro === "") {
            $ok = @ibase_execute($stmt, $grupo, $dataSql, $horaSql, $tecnicoOrigem, $clienteChamado, $comentario, $para, $imagemDataUrl);
            if (!$ok) {
                $mensagemErro = "Não foi possível salvar. Confira se as colunas TECNICO e IMAGEM existem e o tamanho máximo do POST no PHP.";
            } else {
                /* Atualiza o responsável do chamado somente depois de gravar o histórico da transferência. */
                $SQLx = "UPDATE CHAMADOS SET TECNICO=" . (int)$para . " WHERE CODIGO=" . (int)$grupo;
                if (!@ibase_query($conexao, $SQLx)) {
                    $mensagemErro = "O histórico da transferência foi gravado, mas não foi possível atualizar o técnico responsável pelo chamado.";
                } else {
                    header("Location: comentarios_internos.php?GRUPO=" . urlencode((string)$grupo) . "&salvo=1");
                    exit;
                }
            }
        }
    }
}

if (isset($_GET["salvo"]) && $_GET["salvo"] === "1") {
    $mensagemOk = "Comentário e imagem salvos com sucesso no banco de dados.";
}

$ACESSO = "Timeline de Comentários";
include "controleacesso.php";

$sql = "SELECT C.CODIGO, CAST(C.COMENTARIO AS VARCHAR(2000)) AS COMENTARIO,
               C.PARA, C.DATAALTERACAO, C.HORAALTERACAO, C.IMAGEM,
               (SELECT T.NOME FROM TECNICOS T WHERE T.CODIGO = C.TECNICO) AS USUARIO,
               (SELECT T.NOME FROM TECNICOS T WHERE T.CODIGO = C.PARA) AS USUARIOPARA
        FROM COMENTARIOS_INTERNOS C
        WHERE C.GRUPO = " . (int)$grupo . "
        ORDER BY C.CODIGO DESC";
$tabela = @ibase_query($conexao, $sql);
if (!$tabela) {
    http_response_code(500);
    exit("Erro ao carregar timeline. Confirme que a coluna IMAGEM existe como BLOB SUB_TYPE TEXT.");
}
$tecnicos = ibase_query($conexao, "SELECT CODIGO, NOME FROM TECNICOS ORDER BY NOME");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo h($ACESSO); ?></title>
    <?php include "css.php"; ?>
    <style>
        .timeline { margin-top: 20px; }
        .timeline-item { border-left: 3px solid #007bff; padding: 0 0 24px 18px; margin-left: 8px; }
        .timeline-card { background: #f7f7f7; padding: 14px; border-radius: 6px; }
        .timeline-meta { font-size: 12px; color: #666; margin: 5px 0 10px; }
        .transferencia-pessoas { display:flex; flex-wrap:wrap; gap:8px; align-items:center; color:#34495e; }
        .transferencia-pessoas strong { color:#1b6da8; }
        .transferencia-seta { color:#7c8996; font-size:18px; }
        .timeline-image { max-width: 100%; max-height: 500px; border: 1px solid #ddd; padding: 4px; }
    </style>
</head>
<body id="page-top">
<div id="wrapper"><div id="content-wrapper" class="d-flex flex-column"><div id="content">
<div class="container-fluid"><div class="card shadow mb-4">
    <div class="card-header py-3"><h5><?php echo h($ACESSO); ?></h5></div>
    <div class="card-body">
        <?php if ($mensagemErro !== "") { ?><div class="alert alert-danger"><?php echo h($mensagemErro); ?></div><?php } ?>
        <?php if ($mensagemOk !== "") { ?><div class="alert alert-success"><?php echo h($mensagemOk); ?></div><?php } ?>

        <form method="post" action="comentarios_internos.php?GRUPO=<?php echo urlencode((string)$grupo); ?>" onsubmit="return validarEnvio();">
            <div class="form-group">
                <label for="COMENTARIO">Comentário interno</label>
                <textarea class="form-control" id="COMENTARIO" name="COMENTARIO" rows="4" maxlength="2000" required><?php echo h($comentarioDigitado); ?></textarea>
                <small class="form-text text-muted">Copie uma captura e cole aqui com Ctrl+V.</small>
            </div>
            <input type="hidden" id="IMAGEM_BASE64" name="IMAGEM_BASE64" value="<?php echo h($imagemDataUrl); ?>">
            <div class="form-group">
                <label>Pré-visualização da imagem</label><br>
                <img id="preview" alt="Pré-visualização" src="<?php echo h($imagemDataUrl); ?>" style="<?php echo $imagemDataUrl !== "" ? "display:inline-block;" : "display:none;" ?>max-width:100%;max-height:350px;border:1px solid #ccc;padding:4px;">
                <br><button type="button" id="removerImagem" class="btn btn-sm btn-outline-danger" style="<?php echo $imagemDataUrl !== "" ? "display:inline-block;" : "display:none;" ?>margin-top:8px;">Remover imagem</button>
            </div>
            <div class="form-group">
                <label for="PARA">Transferir para técnico</label>
                <select class="form-control" id="PARA" name="PARA" required>
                    <option value="">Selecione</option>
                    <?php if ($tecnicos) { while ($tecnico = ibase_fetch_assoc($tecnicos)) { ?>
                        <option value="<?php echo h($tecnico["CODIGO"]); ?>" <?php echo ((int)$paraSelecionado === (int)$tecnico["CODIGO"]) ? "selected" : ""; ?>><?php echo h($tecnico["NOME"]); ?></option>
                    <?php } } ?>
                </select>
            </div>
			
            <button type="submit" class="btn btn-success">Salvar comentário</button>
        </form>

        <hr><h5>Timeline</h5>
        <div class="timeline">
        <?php while ($item = ibase_fetch_assoc($tabela)) {
            $imagemSalva = lerBlobBase64($conexao, isset($item["IMAGEM"]) ? $item["IMAGEM"] : "");
            $imagemValida = ($imagemSalva !== "" && preg_match('/^data:image\/(png|jpeg|jpg|gif|webp);base64,[A-Za-z0-9+\/=\r\n]+$/', $imagemSalva));
        ?>
            <article class="timeline-item"><div class="timeline-card">
                <div class="transferencia-pessoas">
                    <span><strong>Transferido por:</strong> <?php echo h(isset($item["USUARIO"]) && $item["USUARIO"] !== null ? $item["USUARIO"] : "Usuário não identificado"); ?></span>
                    <span class="transferencia-seta">&rarr;</span>
                    <span><strong>Transferido para:</strong> <?php echo h(isset($item["USUARIOPARA"]) && $item["USUARIOPARA"] !== null ? $item["USUARIOPARA"] : "Destinatário não identificado"); ?></span>
                </div>
                <div class="timeline-meta"><?php echo h($item["DATAALTERACAO"]); ?> <?php echo h($item["HORAALTERACAO"]); ?></div>
                <div><?php echo nl2br(h($item["COMENTARIO"])); ?></div>
                <?php if ($imagemValida) { ?>
                    <div style="margin-top:12px;"><img class="timeline-image" src="<?php echo h($imagemSalva); ?>" alt="Imagem do comentário"></div>
                <?php } elseif (!empty($item["IMAGEM"])) { ?>
                    <div class="alert alert-warning" style="margin-top:10px;">Sem anexo</div>
                <?php } ?>
            </div></article>
        <?php } ?>
        </div>
    </div>
</div></div></div></div>
<script>
(function () {
    var comentario = document.getElementById("COMENTARIO");
    var campo = document.getElementById("IMAGEM_BASE64");
    var preview = document.getElementById("preview");
    var remover = document.getElementById("removerImagem");
    comentario.addEventListener("paste", function (event) {
        var clip = event.clipboardData || window.clipboardData;
        var itens = clip && clip.items;
        if (!itens) return;
        for (var i = 0; i < itens.length; i++) {
            if (itens[i].type && itens[i].type.indexOf("image/") === 0) {
                event.preventDefault();
                var arquivo = itens[i].getAsFile();
                if (!arquivo) return;
                if (arquivo.size > 5 * 1024 * 1024) { alert("A imagem excede o limite de 5 MB."); return; }
                var leitor = new FileReader();
                leitor.onload = function (e) { campo.value = e.target.result; preview.src = e.target.result; preview.style.display = "inline-block"; remover.style.display = "inline-block"; };
                leitor.readAsDataURL(arquivo);
                break;
            }
        }
    });
    remover.addEventListener("click", function () { campo.value = ""; preview.removeAttribute("src"); preview.style.display = "none"; remover.style.display = "none"; });
})();
function validarEnvio() {
    var valor = document.getElementById("IMAGEM_BASE64").value;
    if (valor.length > 7000000) { alert("A imagem é muito grande. Reduza o tamanho e tente novamente."); return false; }
    return true;
}
</script>
<?php include "rodape.php"; ?>
</body>
</html>
