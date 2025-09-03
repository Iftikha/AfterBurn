<?php
    use Gemini\Enums\ModelVariation;
    use Gemini\GeminiHelper;
    use Gemini\Client;
    function useGenAi($req){
    $API_KEY = $_ENV['GEMINI_API_KEY'];
    $client = Gemini::client($API_KEY);
    
    $result = $client->generativeModel('gemini-2.5-flash')->generateContent($req);

    if (!empty($result->candidates[0]->content->parts[0]->text)) {
        return $result->candidates[0]->content->parts[0]->text;
    } else {
        return "No response text found from Gemini.";
    }
}

?>