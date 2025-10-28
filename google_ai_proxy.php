<?php
require_once 'config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Debug logging function
function logDebug($message, $data = null) {
    $logFile = __DIR__ . '/google_ai_debug.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message\n";
    if ($data) {
        $logMessage .= print_r($data, true) . "\n";
    }
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Error handling function
function sendError($message, $code = 400, $apiResponse = null) {
    http_response_code($code);
    $error = ['error' => $message];
    if ($apiResponse) {
        $error['api_response'] = $apiResponse;
        logDebug("API Error Response", $apiResponse);
    }
    echo json_encode($error);
    exit;
}

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendError('Method not allowed', 405);
}

// Get the input data
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['message'])) {
    sendError('Invalid request data. Message is required.');
}

$message = $input['message'];
logDebug("Google AI Request", ['message' => $message]);

// Prepare the request data for Gemini API
$data = [
    'contents' => [
        [
            'parts' => [
                [
                    'text' => $message
                ]
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.7,
        'topK' => 40,
        'topP' => 0.95,
        'maxOutputTokens' => 2048,
    ]
];

// Make the API request
$apiKey = GOOGLE_AI_API_KEY;
$apiUrl = GOOGLE_AI_API_URL . '?key=' . $apiKey;

$options = [
    'http' => [
        'header' => "Content-Type: application/json\r\n",
        'method' => 'POST',
        'content' => json_encode($data)
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($apiUrl, false, $context);

if ($response === FALSE) {
    $error = error_get_last();
    logDebug("API Request Failed", $error);
    sendError('Failed to call Google AI API: ' . ($error['message'] ?? 'Unknown error'));
}

$result = json_decode($response, true);
logDebug("Google AI Response", $result);

if (isset($result['error'])) {
    sendError('Google AI API error: ' . json_encode($result['error']), 400, $result);
}

if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
    $responseText = $result['candidates'][0]['content']['parts'][0]['text'];
    
    // Return response in a format similar to other AI APIs
    echo json_encode([
        'success' => true,
        'content' => $responseText,
        'model' => 'gemini-2.0-flash',
        'usage' => $result['usageMetadata'] ?? null
    ]);
} else {
    sendError('Unexpected response format from Google AI API', 500, $result);
}
?>
