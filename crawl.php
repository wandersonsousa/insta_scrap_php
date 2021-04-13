<?php
require_once './vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://www.instabrasil.com',
    'cookies' => true
]);

$data = [
    'usuario' => 'wander_dev',
    'quantidade' => '250',
    'reposicao' => '0'
];

try {
    $response = $client->post('verificar-dados', [
        'form_params' => $data
    ]);
    if ($response->getStatusCode() == 200) {
        $paymentRes = $client->post('https://www.instabrasil.com/pagamento');
        if ($paymentRes->getStatusCode() == 200) {
            print (string) $paymentRes->getBody();
            exit();
        }
    }
} catch (\Throwable $th) {
    print_r($th);
}
