<?php
require __DIR__ . '/vendor/autoload.php';

$certPath = __DIR__ . '/certs/cacert.pem'; // Ajusta según tu estructura
$testUrl = 'https://oauth2.googleapis.com/token';

try {
    $client = new \GuzzleHttp\Client(['verify' => $certPath]);

    $response = $client->request('POST', $testUrl, [
        'form_params' => [
            'client_id' => 'TEST',  // No hace falta que sean reales
            'client_secret' => 'TEST',
            'code' => 'TEST',
            'grant_type' => 'authorization_code',
            'redirect_uri' => 'https://camachobarber.nue.dom.my.id/google-callback'
        ]
    ]);

    echo "SSL funciona correctamente: " . $response->getStatusCode();
} catch (\Exception $e) {
    echo "Error SSL: " . $e->getMessage();
}
