<?php

use Slim\Http\Request;
use Slim\Http\Response;

$users = [];

array_push($users, array("toto", "toto"));

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


$app->get('/game/id={id}', function (Request $request, Response $response, array $args) {
//    var_dump($args['id']);
    $sth = $this->db->prepare("SELECT id FROM player WHERE Name=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $todos = $sth->fetchObject();
    $sth2 = $this->db->prepare("SELECT * FROM partie WHERE idPlayer=:id");
    $sth2->bindParam("id", $todos->id);
    $sth2->execute();
    $todos2 = $sth2->fetchAll();
//    var_dump($todos2);
    return $response->withJson(array("requete" => $todos2));
});

$app->post('/game/add', function (Request $request, Response $response, array $args) {
    $posts_data = $request->getParsedBody();
    $id = $posts_data["id"];
    $token = $posts_data["token"];
    $enCours = $posts_data["enCours"];
    $NumPhoto = $posts_data["NumPhoto"];
    $time = $posts_data["time"];
    $Score = $posts_data["Score"];
    $idPlayer = $posts_data["idPlayer"];
    $sthb = $this->db->prepare("SELECT id FROM player WHERE Name=:id");
    $sthb->bindParam("id", $idPlayer);
    $sthb->execute();
    $todosb = $sthb->fetchObject();
    $sql = "INSERT INTO partie(id, token, enCours, NumPhoto, time, Score, idPlayer) VALUES (:id,:token,:enCours,:NumPhoto,:time2,:Score,:idPlayer)";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("id", $id);
    $sth->bindParam("token", $token);
    $sth->bindParam("enCours", $enCours);
    $sth->bindParam("NumPhoto", $NumPhoto);
    $sth->bindParam("time2", $time);
    $sth->bindParam("Score", $Score);
    $sth->bindParam("idPlayer", $todosb->id);
    $sth->execute();
//    $todos = $sth->fetchAll();
    return $response->withJson(array("requete" => $posts_data));
});

$app->post('/game/update',function (Request $request, Response $response, array $args){
    $posts_data = $request->getParsedBody();
    $id = $posts_data["id"];
    $token = $posts_data["token"];
    $enCours = $posts_data["enCours"];
    $NumPhoto = $posts_data["NumPhoto"];
    $time = $posts_data["time"];
    $Score = $posts_data["Score"];
    $idPlayer = $posts_data["idPlayer"];
    $sthb = $this->db->prepare("SELECT id FROM player WHERE Name=:id");
    $sthb->bindParam("id", $idPlayer);
    $sthb->execute();
    $todosb = $sthb->fetchObject();
    $sql = "UPDATE partie SET token=:token, enCours=:enCours, NumPhoto=:NumPhoto, time=:time2, Score=:Score, idPlayer=:idPlayer WHERE id=:id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("id", $id);
    $sth->bindParam("token", $token);
    $sth->bindParam("enCours", $enCours);
    $sth->bindParam("NumPhoto", $NumPhoto);
    $sth->bindParam("time2", $time);
    $sth->bindParam("Score", $Score);
    $sth->bindParam("idPlayer", $todosb->id);
    $sth->execute();
    $posts_data["idPlayer"] = $todosb->id;
    return $response->withJson(array("requete" => $posts_data));
});

$app->get('/todos', function (Request $request, Response $response, array $args) {
    $sth = $this->db->prepare("SELECT * FROM player ORDER BY Name");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

$app->get('/getToken', function (Request $request, Response $response, array $args) {
    $token = sha1(date('Y-m-d'));
//    die();
    return $response->withJson(array("token" => $token));
});

$app->post('/login', function (Request $request, Response $response, array $args) {
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
    if ($token == $tokenClient) {
        $testTmp = false;

        if ($todos->Mdp == $pwd) {
            $testTmp = true;
        }

        if ($testTmp == true) {
            $res = true;
//            var_dump("true");
            return $response->withJson(array("res" => $res));
//            return $this->renderer->render($response, 'game.html', $args);
        } else {
            $res = false;
            return $response->withJson(array("res" => $res));
        }
    } else {
        $res = false;
        return $response->withJson(array("res" => $res));
    }
});

$app->post('/register', function (Request $request, Response $response, array $args) {
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
        } else {
            $testTemp = false;
        }
    }
    if ($testTemp == false) {
        array_push($users, array($id, $pwd));
        return $response->withJson(array("res" => true));
    } else {
        return $response->withJson(array("res" => false));
    }
});
