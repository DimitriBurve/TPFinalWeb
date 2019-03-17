<?php

use Slim\Http\Request;
use Slim\Http\Response;

$users = [];

array_push($users,array("toto","toto"));

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
//    die();
    // Render index view
    $sth = $this->db->prepare("SELECT * FROM player");
    $sth->execute();
    $todos = $sth->fetchAll();

    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/todos', function (Request $request, Response $response, array $args) {
    $sth = $this->db->prepare("SELECT * FROM player ORDER BY Name");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

$app->get('/getToken', function (Request $request, Response $response, array $args){
    $token = sha1(date('Y-m-d'));
//    die();
    return $response->withJson(array("token"=>$token));
});

$app->post('/login', function (Request $request, Response $response, array $args){
    $token = sha1(date('Y-m-d'));
    $posts_data = $request->getParsedBody();
    $id = $posts_data["id"];
    $pwd = $posts_data["pwd"];
    $tokenClient = $posts_data["token"];

    $sth = $this->db->prepare("SELECT * FROM player WHERE Name=:id");
    $sth->bindParam("id", $id);
    $sth->execute();
    $todos = $sth->fetchObject();


    global $users;

//    var_dump($todos->Mdp);
//    var_dump($posts_data);
//    var_dump($tokenClient);
    if ($token == $tokenClient){
        $testTmp = false;

        if ($todos->Mdp == $pwd){
            $testTmp =true;
        }

        if ($testTmp==true) {
            $res = true;
//            var_dump("true");
            return $response->withJson(array("res" => $res));
        }else{
            $res = false;
            return $response->withJson(array("res"=>$res));
        }
    }else{
        $res = false;
        return $response->withJson(array("res"=>$res));
    }
});

$app->post('/register', function (Request $request, Response $response, array $args){
    $posts_data = $request->getParsedBody();
    $id = $posts_data["id"];
    $pwd = $posts_data["pwd"];

    global $users;
//    var_dump($users);
    $testTemp = true;
    for ($i = 0; $i < sizeof($users); $i++) {
        if ($users[$i][0] === $id) {
            $testTemp = true;
            break;
        }else {
            $testTemp = false;
        }
    }
    if ($testTemp == false) {
        array_push($users,array($id,$pwd));
        return $response->withJson(array("res"=>true));
    }else{
        return $response->withJson(array("res"=>false));
    }
});
