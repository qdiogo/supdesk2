 
<?php
session_start(); 
    function generateAIContent($apiKey, $prompt) {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-lite:generateContent?key={$apiKey}";

        $postData = json_encode([
            "contents" => [
                [
                    "parts" => [
                        ["text" => $prompt],
						["text" => "um bom texto e limpo, sem Assunto"],
						["text" => $_GET["tipo"]]
                    ]
                ]
            ],
            "generationConfig" => [
                "temperature" => 0.9,
                "topK" => 1,
                "topP" => 1,
                "maxOutputTokens" => 2000,
                "stopSequences" => []
            ],
            "safetySettings" => [
                [
                    "category" => "HARM_CATEGORY_HARASSMENT",
                    "threshold" => "BLOCK_ONLY_HIGH"
                ],
                [
                    "category" => "HARM_CATEGORY_HATE_SPEECH",
                    "threshold" => "BLOCK_ONLY_HIGH"
                ],
                [
                    "category" => "HARM_CATEGORY_SEXUALLY_EXPLICIT",
                    "threshold" => "BLOCK_ONLY_HIGH"
                ],
                [
                    "category" => "HARM_CATEGORY_DANGEROUS_CONTENT",
                    "threshold" => "BLOCK_ONLY_HIGH"
                ]
            ]
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($postData)
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);

        if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            return $responseData['candidates'][0]['content']['parts'][0]['text'];
        } else {
            return "Texto n�o gerado.";
        }
    }

    $apiKey="AIzaSyDgIYPsyX6e2FCdlqe_kfq8cXbf-f5ixqE";
	
	function tirarAcentos($string){
		return preg_replace(array("/(�|�|�|�|�)/","/(�|�|�|�|�)/","/(�|�|�|�)/","/(�|�|�|�)/","/(�|�|�|�)/","/(�|�|�|�)/","/(�|�|�|�|�)/","/(�|�|�|�|�)/","/(�|�|�|�)/","/(�|�|�|�)/","/(�)/","/(�)/"),explode(" ","a A e E i I o O u U n N"),$string);
	}
	
    $prompt="sem *, sem Assunto: ".tirarAcentos($_GET["texto"]);

    $generatedText = generateAIContent($apiKey, $prompt);
	$generatedText=str_replace("Formaliza��o do texto conclu�da.","","".$generatedText."");
	$generatedText=str_replace("[Seu nome]","".$_SESSION["NOMEUSUARIO"]."","".$generatedText."");
	$generatedText=str_replace("[Nome do destinat�rio]","Cliente","".$generatedText."");
	$generatedText=str_replace("[Nome do Destinat�rio]","Cliente","".$generatedText."");
	$generatedText=str_replace("[Seu Nome]","".$_SESSION["NOMEUSUARIO"]."","".$generatedText."");
    echo trim($generatedText);

    ?>
