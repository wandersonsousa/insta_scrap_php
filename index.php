<?php 
require_once './vendor/autoload.php';

use Goutte\Client;

$client = new Client();

$crawler = $client->request('GET', 'https://www.instagram.com/wander_dev/');

//echo $crawler->filterXpath('//meta[@property="og:image"]')->attr('content');

header('Content-Type: application/json');
$data = [
    "data"=> $crawler->html('<b>Error</b>')
];

echo json_encode($data);