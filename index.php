<?php
$method = $_SERVER['REQUEST_METHOD'];

// Get the JSON contents
$json = file_get_contents('php://input');

$servers = [];
foreach($_SERVER as $m=>$w){
    $servers[$m] = $w;
}

$headers = getallheaders();
$headerUse = $headers;
unset($headerUse['Cookie']);
unset($headerUse['X-Real-IP']);
unset($headerUse['X-Forwarded-Host']);
unset($headerUse['X-Forwarded-Server']);
unset($headerUse['X-Forwarded-Proto']);
unset($headerUse['X-Forwarded-Port']);
unset($headerUse['destination']);
unset($headerUse['alt-used']);
unset($headerUse['Content-Length']);
unset($headerUse['User-Agent']);

$destination = $headers['Destination'] ?? $headers['destination'];
$uri = $_SERVER['REQUEST_URI'];
$endpoint = $destination . $uri;
$host = parse_url($destination, PHP_URL_HOST);
$headerUse['Host'] = $host;

$head = [];
foreach($headerUse as $k => $v) {
    $head[] = "$k: $v";
}

$ch = curl_init();

curl_setopt_array($ch, array(
    CURLOPT_URL => $endpoint,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => $method,
    CURLOPT_POSTFIELDS => $json,
    CURLOPT_HTTPHEADER => $head,
    CURLOPT_HEADER => 1,
  ));

$response = curl_exec($ch);

$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headerResp = substr($response, 0, $header_size);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlinfo = curl_getinfo($ch);
$bodyResp = substr($response, $header_size);

http_response_code($httpcode);

foreach(explode("\n", $headerResp) as $hdr) {
    $hdr = rtrim($hdr);
    if (strlen($hdr) > 0) {
        header($hdr);
    }
}

header("redirected-to: $endpoint");
header("header-sent: " . json_encode($headerUse));

echo $bodyResp;

function dd()
{
    $args = func_get_args();
    
    foreach($args as $arg){
        var_dump($arg);
        echo "\n------------\n";
    }
    
    die();
}