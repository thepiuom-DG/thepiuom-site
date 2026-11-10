<?php
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo '{"ok":false}'; exit; }
if (!empty($_POST['website'])) { echo '{"ok":true}'; exit; } // honeypot
$name = trim(strip_tags($_POST['name'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$topic = trim(strip_tags($_POST['topic'] ?? ''));
$msg = trim(strip_tags($_POST['message'] ?? ''));
if (!$name || !$email || !$msg || strlen($msg) > 5000) { http_response_code(400); echo '{"ok":false}'; exit; }
$name = str_replace(["\r","\n"], ' ', $name);
$to = 'ah.priom@gmail.com';
$subject = 'thepiuom.com enquiry: ' . $topic;
$body = "Name: $name\nEmail: $email\nTopic: $topic\n\n$msg\n";
$headers = "From: thepiuom.com <no-reply@thepiuom.com>\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8\r\n";
$ok = @mail($to, $subject, $body, $headers);
echo json_encode(['ok' => (bool)$ok]);
