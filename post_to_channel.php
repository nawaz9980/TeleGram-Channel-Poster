<?php
// Replace with your bot token and channel ID
$botToken = 'please enter your bot_token';
$channelId = 'Channel Id =-2i3i3o23o3 in this format';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image'])) {
    $imageDescription = $_POST['image_description'];
    $buttonName = $_POST['button_name'];
    $buttonLink = $_POST['button_link'];

    // Handle the image upload
    $imagePath = $_FILES['image']['tmp_name'];
    $imageName = $_FILES['image']['name'];
    $imageType = mime_content_type($imagePath);

    // Telegram API URL for sending photo
    $url = "https://api.telegram.org/bot$botToken/sendPhoto";

    // Create the inline button
    $inlineKeyboard = [
        'inline_keyboard' => [
            [
                ['text' => $buttonName, 'url' => $buttonLink]
            ]
        ]
    ];

    // Create the message data
    $postData = [
        'chat_id' => $channelId,
        'photo' => new CURLFile($imagePath, $imageType, $imageName),
        'caption' => $imageDescription,
        'reply_markup' => json_encode($inlineKeyboard)
    ];

    // Use cURL to send the POST request
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    $response = curl_exec($ch);
    curl_close($ch);

    // Check if the request was successful
    $responseData = json_decode($response, true);
    if ($responseData['ok']) {
        echo "Message posted successfully!";
    } else {
        echo "Failed to post message: " . $responseData['description'];
    }
}
?>
