 
<?php
session_start(); 
    function generateAIContent($apiKey, $prompt) {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key={$apiKey}";

        $postData = json_encode([
            "contents" => [
                [
                    "parts" => [
                        ["text" => "me passe um diagnostico"],
						["text" => "QUAL É O EXAME ESPECIFICADO QUE O PACIENTE PODE FAZER"],
						["text" => "QUAL É O POSSIVEL TRATAMENTO E PORQUE PORQUE ESSES TRATAMENTOS"],
						["text" => "me passe o cid desse diagnostico"],
						["text" => "cor da classificacao de risco atraves do protocolo manchester"],
						["text" => $prompt]
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
            return "Texto não gerado.";
        }
    }

    $apiKey="AIzaSyDUGbQFwT8B-b9B2B08F78dTS3X7iZfShs";
	
	function tirarAcentos($string){
		return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
	}
	
    $prompt="".$_GET["tipo"].", sem *, sem Assunto: ".tirarAcentos($_GET["texto"]);

    $generatedText = generateAIContent($apiKey, $prompt);
	$generatedText=str_replace("*","<br>","".$generatedText."");
	$generatedText=str_replace("<br><br>","<br>","".$generatedText."");
	$generatedText=str_replace("Protocolo de Manchester","","".$generatedText."");
	$generatedText=str_replace("Manchester Triagem","","".$generatedText."");
	$generatedText=str_replace("do Protocolo Manchester","","".$generatedText."");
	echo trim($generatedText);

    ?>
