<?php
require_once './vendor/autoload.php';

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\CssSelector;


$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://www.instabrasil.com',
    'cookies' => true
]);



function respond($pageResponse)
{
    header('Content-type: application/json');
    echo json_encode($pageResponse);
}



if (!isset($_GET['username'])) {
    $pageResponse = [
        'success' => false,
        'msg' => 'invalid username'
    ];
    respond($pageResponse);
    exit();
}
$username = $_GET['username'];

$data = [
    'usuario' => $username,
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
            header('Content-type: application/json');

            $dom = new Crawler((string) $paymentRes->getBody());
            try {
                $imgProfile = $dom->filter('#body > .container .row .list-group-item img')->attr('src');

                $pageResponse = [
                    'img' => $imgProfile
                ];
                respond($pageResponse);
                exit();
            } catch (\Throwable $th) {
                $pageResponse = [
                    'success' => false,
                    'msg' => 'invalid username'
                ];
                respond($pageResponse);
                exit();
            }
        }
    }
} catch (\Throwable $th) {
    print_r($th);
}
