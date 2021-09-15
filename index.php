<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;
$app->get('/get_phrase/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->post('/create_phrase/data', function (Request $request, Response $response, $arg){

    $_input = $request->getParsedBody();

    $_data_1 = $_input['myPhrase'];
    $rsp = array();

    if(!empty($_data_1)){

        $rsp["error"] = false;
        $rsp['message'] = "hello my phrase is ".$_data_1;
    }else{

        $rsp["error"] = false;
        $rsp['message'] = "you have not posted any data" ;
    }

    return $response
        ->withStatus(201)
        ->withJson($rsp);
});


$app->run();
