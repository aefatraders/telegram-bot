<?php
$botToken = "YOUR_BOT_TOKEN";
$adminID = "YOUR_ADMIN_ID";

// Log raw input
$raw = file_get_contents("php://input");
file_put_contents("webhook_debug.txt", date('Y-m-d H:i:s') . " | RAW: $raw" . PHP_EOL, FILE_APPEND);

$update = json_decode($raw, TRUE);

// Log decoded array
file_put_contents("webhook_debug.txt", date('Y-m-d H:i:s') . " | DECODED: " . print_r($update, true) . PHP_EOL, FILE_APPEND);

// Ensure the message exists
if (!isset($update["message"])) {
    exit;
}

$message = $update["message"];
$text = $message["text"] ?? '';
$chatID = $message["chat"]["id"] ?? '';
$username = $message["from"]["username"] ?? "Unknown";

if (empty($chatID)) {
    exit;
}

function sendMessage($chatID, $text, $keyboard = null) {
    global $botToken;
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $post = [
        'chat_id' => $chatID,
        'text' => $text,
        'parse_mode' => 'Markdown'
    ];
    if ($keyboard) {
        $post['reply_markup'] = json_encode($keyboard);
    }
    file_get_contents($url . "?" . http_build_query($post));
}

if ($text === "/start") {
    sendMessage($chatID, "Welcome to *AEFA Changer* Bot on Render.
Please enter the amount you want to convert:");
}
?>
