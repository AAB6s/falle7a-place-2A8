<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'] ?? '';

    if (!empty($description)) {
        // Utilisez votre clé API OpenAI
        $apiKey = '';

        // Préparer les données pour l'API
        $data = [
            'text' => $description,
            'voice' => 'en-US', // Modifier la voix si nécessaire
            'format' => 'mp3'    // Format du fichier audio
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/audio/text-to-speech");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json"
        ]);

        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($status === 200) {
            $response = json_decode($result, true);

            if (isset($response['audio'])) {
                header("Content-Type: audio/mpeg");
                echo base64_decode($response['audio']);
            } else {
                echo json_encode(['error' => 'Invalid response from API']);
            }
        } else {
            echo json_encode(['error' => 'API request failed', 'details' => $result]);
        }

        curl_close($ch);
    } else {
        echo json_encode(['error' => 'No description provided']);
    }
}
?>
