<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Assinatura Digital com Certificado</title>
  <script>
    // Função para assinar o conteúdo
    async function signContent() {
      try {
        const htmlContent = "<html><head><title>Assinatura</title></head><body><h1>Conteúdo HTML</h1></body></html>";

        // Criar um hash do conteúdo HTML
        const encoder = new TextEncoder();
        const data = encoder.encode(htmlContent);
        const hashBuffer = await crypto.subtle.digest('SHA-256', data);

        // Agora, solicitamos que o navegador assine o hash usando o certificado do usuário
        // Isso normalmente exigiria um método de integração, mas vamos simular aqui
        const key = await getUserPrivateKey();

        // Assinar o hash
        const signature = await crypto.subtle.sign({ name: 'RSA-PSS', saltLength: 32 }, key, hashBuffer);

        console.log('Assinatura gerada:', new Uint8Array(signature));
      } catch (error) {
        console.error('Erro ao assinar:', error);
      }
    }

    // Simulação de obtenção da chave privada do usuário (em um cenário real, você usaria uma API específica para isso)
    async function getUserPrivateKey() {
      // Aqui você interagiria com a API de certificado do navegador
      // ou com uma solução que permitisse acessar a chave privada
      throw new Error("Função de acesso ao certificado não implementada.");
    }
  </script>
</head>
<body>
  <h1>Assinatura Digital com Certificado</h1>
  <button onclick="signContent()">Assinar Documento</button>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/pkcs12"></script>
<script>
  // Função para ler o arquivo P12 (certificado com a chave privada)
  function readP12File(file) {
    const reader = new FileReader();
    reader.onload = function(event) {
      const p12 = new PKCS12(event.target.result, 'senha_do_certificado');
      const key = p12.key;  // Aqui obtemos a chave privada
      const cert = p12.cert; // Aqui obtemos o certificado

      // Agora você pode usar `key` para assinar dados
      console.log('Certificado e chave privada carregados:', cert, key);
    };
    reader.readAsArrayBuffer(file);
  }

  // Exemplo de chamada
  const fileInput = document.getElementById('fileInput');
  fileInput.addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
      readP12File(file);
    }
  });
</script>

<input type="file" id="fileInput" />
