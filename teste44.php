<?php
/**
 * Assinador de PDF com Serpro - Versão PHP Puro
 * Não requer Composer ou bibliotecas externas
 */

class AssinadorSerproAPI {
    
    private $clientId;
    private $clientSecret;
    private $redirectUri;
    private $apiUrl = "https://serproid.serpro.gov.br";
    
    public function __construct($clientId, $clientSecret, $redirectUri) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;
    }
    
    /**
     * Gera URL para redirecionar o usuário para autorização
     */
    public function getAuthorizationUrl($state = null) {
        $params = [
            'response_type' => 'code',
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'scope' => 'signature_session'
        ];
        
        if ($state) {
            $params['state'] = $state;
        }
        
        return $this->apiUrl . "/oauth/v0/oauth/authorize?" . http_build_query($params);
    }
    
    /**
     * Troca o código de autorização por token de acesso
     */
    public function getAccessToken($code) {
        $url = $this->apiUrl . "/oauth/v0/oauth/token";
        
        $postFields = http_build_query([
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->redirectUri,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret
        ]);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Apenas para testes
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode == 200) {
            $result = json_decode($response, true);
            return $result['access_token'] ?? null;
        }
        
        return null;
    }
    
    /**
     * Assina um hash usando o token do usuário
     */
    public function signHash($accessToken, $hashBase64, $documentId) {
        $url = $this->apiUrl . "/oauth/v0/oauth/signature";
        
        $payload = [
            "hashes" => [
                [
                    "id" => $documentId,
                    "alias" => "Documento a ser assinado",
                    "hash" => $hashBase64,
                    "hash_algorithm" => "2.16.840.1.101.3.4.2.1", // SHA-256 OID
                    "signature_format" => "CMS"
                ]
            ]
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode == 200) {
            return json_decode($response, true);
        }
        
        return null;
    }
    
    /**
     * Calcula o hash SHA-256 de um arquivo
     */
    public function calculateFileHash($filePath) {
        $content = file_get_contents($filePath);
        $hash = hash('sha256', $content, true);
        return base64_encode($hash);
    }
}

// ============================================================
// EXEMPLO DE USO
// ============================================================

session_start();

// Configurações (substitua pelos seus dados)
$clientId = "SEU_CLIENT_ID";
$clientSecret = "SEU_CLIENT_SECRET";
$redirectUri = "http://localhost/supdesk2/callback.php";

$assinador = new AssinadorSerproAPI($clientId, $clientSecret, $redirectUri);

// Processar callback
if (isset($_GET['code'])) {
    // Obter token
    $token = $assinador->getAccessToken($_GET['code']);
    
    if ($token) {
        $_SESSION['access_token'] = $token;
        
        // Calcular hash do documento
        $hash = $assinador->calculateFileHash('documento.pdf');
        
        // Assinar
        $resultado = $assinador->signHash($token, $hash, 'doc_' . time());
        
        if ($resultado) {
            echo "<h2>? Documento assinado com sucesso!</h2>";
            echo "<pre>";
            print_r($resultado);
            echo "</pre>";
        } else {
            echo "<h2>? Erro na assinatura</h2>";
        }
    } else {
        echo "<h2>? Erro ao obter token</h2>";
    }
    exit;
}

// Iniciar fluxo de autorização
$authUrl = $assinador->getAuthorizationUrl();
header("Location: " . $authUrl);
?>