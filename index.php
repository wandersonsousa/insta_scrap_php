<?php 
require_once './vendor/autoload.php';

use Goutte\Client;

$client = new Client();

$crawler = $client->request('GET', 'https://www.instagram.com/wander_dev/');

//echo $crawler->filterXpath('//meta[@property="og:image"]')->attr('content');

echo json_encode([
    "data"=> $crawler->html('<b>Error</b>')
]);