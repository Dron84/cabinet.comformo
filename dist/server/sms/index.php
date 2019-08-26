<?php
namespace server\sms;

use Nexmo\Client;
use Slim\App;

require __DIR__.'/../vendor/autoload.php';
define('API_KEY' , '5ba0c3bd');
define('API_SECRET', 'z405zUaYjsCvXGRx');
$api_sicret = 'z405zUaYjsCvXGRx';
//new Nexmo\client\Client\Credentials\Basic(API_KEY, API_SECRET)
$client = new Client(new Client\Credentials\Basic(API_KEY, API_SECRET));

$Signature_Secret = 'qkeHbUhALFLUeQjRA20RsaiqLnnbcJvCJG0HGMO4GKoFwYAv8U';

$app = new App();
$handler = function (Request $request, Response $response) {
    $params = $request->getParsedBody();
    // Fall back to query parameters if needed
    if (!count($params)){
        $params = $request->getQueryParams();
    }
    error_log(print_r($params, true));
    return $response->withStatus(204);
};
$app->get('/server/sms/', $handler);
$app->post('/server/sms/', $handler);
$app->run();