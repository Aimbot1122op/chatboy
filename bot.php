<?php

// Telegram bot API token
define('API_TOKEN', '7485793077:AAHuwHaHT-I7nvunSKRjs07mlafK3gsFQJg');

// ID of the group where messages will be forwarded
define('GROUP_ID', '-1002248406302');

// List of admin user IDs
$admin_ids = ['7102355757', '6657480603'];

// Get updates from Telegram
$update = json_decode(file_get_contents('php://input'), true);

// Check if the user sent /start command
// Check if the user sent /start command
if(isset($update['message']['text']) && $update['message']['text'] == '/start') {
    // Prepare video message
    $video_url = "https://t.me/ananbpig/3";
    $caption = "*😍😍Reply will come only after enabling your forward message.*\n{Check-out above demo Video}\n\n*⚠️ Remember:*\n\nAdmin will never DM you 1st,\n\nNow you can tell us your problem below 👇";
    sendVideo($update['message']['chat']['id'], $video_url, $caption);
}else {
  
    // Check if the message is from an admin and a reply
    if (in_array($update['message']['from']['id'], $admin_ids) && isset($update['message']['reply_to_message'])) {
        // Get the original sender's chat ID
        $original_chat_id = $update['message']['reply_to_message']['forward_from']['id'];

        // Copy the message to the original sender's chat
        copyMessage($update['message']['chat']['id'], $original_chat_id, $update['message']['message_id']);
        exit();
    }

  // Forward message to the group
    forwardMessage($update['message']['chat']['id'], GROUP_ID, $update['message']['message_id']);


    // Send confirmation message to the user
    $confirmationMessage = "Your message has been sent to the admin. Please wait for their response 😊";
    sendMessage($update['message']['chat']['id'], $confirmationMessage);
}

// Function to send video message to Telegram
function sendVideo($chat_id, $video_url, $caption) {
    $url = 'https://api.telegram.org/bot' . API_TOKEN . '/sendVideo';
    $params = [
        'chat_id' => $chat_id,
        'video' => $video_url,
        'caption' => $caption,
        'parse_mode' => 'Markdown'
    ];

    // Use cURL to send POST request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
}


// Function to send message to Telegram
function sendMessage($chat_id, $message) {
    $url = 'https://api.telegram.org/bot' . API_TOKEN . '/sendMessage';
    $params = [
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'Markdown'
    ];

    // Use cURL to send POST request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
}

// Function to forward message to a group
function forwardMessage($from_chat_id, $to_chat_id, $message_id) {
    $url = 'https://api.telegram.org/bot' . API_TOKEN . '/forwardMessage';
    $params = [
        'chat_id' => $to_chat_id,
        'from_chat_id' => $from_chat_id,
        'message_id' => $message_id
    ];

    // Use cURL to send POST request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
}

// Function to copy message to another chat
function copyMessage($from_chat_id, $to_chat_id, $message_id) {
    $url = 'https://api.telegram.org/bot' . API_TOKEN . '/copyMessage';
    $params = [
        'chat_id' => $to_chat_id,
        'from_chat_id' => $from_chat_id,
        'message_id' => $message_id
    ];

    // Use cURL to send POST request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
}
