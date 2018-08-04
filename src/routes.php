<?php

use Slim\Http\Request;
use Slim\Http\Response;

require '../src/db.php';


$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

///////////////////////////////////////////////////////////////////////
// Create
///////////////////////////////////////////////////////////////////////

$app->post('/api/addnewplayer', function(Request $request, Response $response){
    $playername = $request->getParam('playername');
    $class = $request->getParam('class');

    $sql = "INSERT INTO Players (playername, class) VALUES
    (:playername,:class)";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':playername', $playername);
        $stmt->bindParam(':class',  $class);
        $stmt->execute();
        echo '{"notice": {"text": "Customer Added"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

///////////////////////////////////////////////////////////////////////
// Read
///////////////////////////////////////////////////////////////////////

$app->get('/api/getallplayers', function (Request $request, Response $response) {
    $sql = "SELECT * FROM Players";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->query($sql);
        $players = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($players);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


$app->get('/api/getplayerbyid/{id}', function (Request $request, Response $response) {
    $id = $request->getattribute('id');
    $sql = "SELECT * FROM Players WHERE id = $id";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->query($sql);
        $players = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($players);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

///////////////////////////////////////////////////////////////////////
// Update
///////////////////////////////////////////////////////////////////////

$app->put('/api/updateplayer/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $playername = $request->getParam('playername');
    $class = $request->getParam('class');
    $weapon = $request->getParam('weapon');
    $weaponelement = $request->getParam('weaponelement');
    $playerlevel = $request->getParam('playerlevel');
    $weaponlevel = $request->getParam('weaponlevel');
    $hp = $request->getParam('hp');
    $mana = $request->getParam('mana');
    $gold = $request->getParam('gold');
    $strength = $request->getParam('strength');
    $dexterity = $request->getParam('dexterity');
    $intelligence = $request->getParam('intelligence');
    $constitution = $request->getParam('constitution');
    $sql = "UPDATE Players SET
				playername 	  = :playername,
				class   	  = :class,
                weapon		  = :weapon,
                weaponelement = :weaponelement,
                playerlevel	  = :playerlevel,
                weaponlevel   = :weaponlevel,
                hp  		  = :hp,
                mana		  = :mana,
                gold    	  = :gold,
                strength	  = :strength,
                dexterity	  = :dexterity,
                intelligence  = :intelligence,
                constitution  = :constitution
			WHERE id = $id";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':playername',    $playername);
        $stmt->bindParam(':class',         $class);
        $stmt->bindParam(':weapon',        $weapon);
        $stmt->bindParam(':weaponelement', $weaponelement);
        $stmt->bindParam(':playerlevel',   $playerlevel);
        $stmt->bindParam(':weaponlevel',   $weaponlevel);
        $stmt->bindParam(':hp',            $hp);
        $stmt->bindParam(':mana',          $mana);
        $stmt->bindParam(':gold',          $gold);
        $stmt->bindParam(':strength',      $strength);
        $stmt->bindParam(':dexterity',     $dexterity);
        $stmt->bindParam(':intelligence',  $intelligence);
        $stmt->bindParam(':constitution',  $constitution);
        $stmt->execute();
        echo '{"notice": {"text": "Customer Updated"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

$app->delete('/api/deleteplayer/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "DELETE FROM Players WHERE id = $id";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Customer Deleted"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});



