<?php

#require 'Connectiondb.php'
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
#require 'Connectiondb.php'
require '../vendor/autoload.php';

$app = new \Slim\App;



$app->get('/get_phrase/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});


$app = new \Slim\App;
$app->get('/get_phrase1/{name}', function (Request $request, Response $response, array $args) {
	    $name = $args['name'];
	    $rsp["error"] = false;
	    $conn = getConnection();
	    $stmt = $conn->query("SELECT * FROM my_phrase");
             $rsp['message'] = $stmt;
		    return $response
		            ->withStatus(201)
		            ->withJson($rsp);
});



$app = new \Slim\App;


$app->add(function ($req, $res, $next) {
	    $response = $next($req, $res);
	        return $response
			            ->withHeader('Access-Control-Allow-Origin', 'http://3.86.67.120')
			                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
				            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
}); 


$app->post('/create_phrase/data', function (Request $request, Response $response, $arg){

    $_input = $request->getParsedBody();

    $_data_1 = $_input['myPhrase'];
    $rsp = array();

    if(!empty($_data_1)){

        $rsp["error"] = false;
	$conn = getConnection();
	$sql = "INSERT INTO my_phrase(id,phrase) VALUES(?,?)";
	$stmt = $conn->prepare($sql);
	$stmt->execute(['',$_data_1]);
	$rsp["message"]= "success";

    }else{

        $rsp["error"] = false;
        $rsp['message'] = "you have not posted any data" ;
    }

    return $response
        ->withStatus(201)
	->withJson($rsp);
});



$app->run();

  function getConnection() {
	 $dbhost="myapiinstance.cluster-codpc1xvsr06.us-east-1.rds.amazonaws.com";
	 $dbuser="MyAPIInstance";
	 $dbpass="MyAPIInstance";
	 $dbname="MyAPIDatabase";
	 $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);  
	 $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 return $dbh;
	    }
