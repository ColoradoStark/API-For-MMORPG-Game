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

////////////////////////////////////////////////////////////////////////////
//Login 
////////////////////////////////////////////////////////////////////////////
$app->post('/user/login', function(Request $request, Response $response){
    $email = $request->getParam('email');
    $password = $request->getParam('password');

    $myObj->id = "777";
    $myObj->name = "Colorado Stark";

    $myJSON = json_encode($myObj);

    echo $myJSON;
});

///////////////////////////////////////////////////////////////////////
// Create
///////////////////////////////////////////////////////////////////////

$app->post('/api/createnewplayer', function(Request $request, Response $response){
    $playername = $request->getParam('playername');
    $playerclass = $request->getParam('playerclass');

    $sql = "INSERT INTO Players (playername, playerclass) VALUES
    (:playername,:playerclass)";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':playername', $playername);
        $stmt->bindParam(':playerclass',  $playerclass);
        $stmt->execute();
        //echo '{"notice": {"text": "Player Added"}';
        $Response->id = $db->lastInsertId();
        $Response->message = "Success";
        $JsonResponse = json_encode($Response);
        echo $JsonResponse;
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
	
    $sql = "SELECT * FROM Players WHERE id = :id";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        
	$stmt = $db->prepare($sql);
	
    $stmt->bindParam(':id', $id);
	$stmt->execute();
		
        $players = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($players[0]);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

///////////////////////////////////////////////////////////////////////
// Update
///////////////////////////////////////////////////////////////////////

$app->put('/api/updateplayer', function(Request $request, Response $response){
    //$id = $request->getAttribute('id');
    $id = $request->getParam('id');
    $playername = $request->getParam('playername');
    $playerclass = $request->getParam('playerclass'); 
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
				playerclass   = :playerclass,
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
        $stmt->bindParam(':playerclass',   $playerclass);
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
        
        $Response->id = $id;
        $Response->message = "Success";
        $JsonResponse = json_encode($Response);
        echo $JsonResponse;
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

///////////////////////////////////////////////////////////////////////
// Delete
///////////////////////////////////////////////////////////////////////

$app->delete('/api/deleteplayerbyid/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "DELETE FROM Players WHERE id = :id";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
		
        $stmt->execute();
        $db = null;
        //echo '{"notice": {"text": "Customer Deleted"}';
        $Response->id = $id;
        $Response->message = "Success";
        $JsonResponse = json_encode($Response);
        echo $JsonResponse;
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});



// ********************************************************************************************
// ********************************************************************************************
// ********************************************************************************************
// THIS NEXT METHOD IS AN EXAMPLE OF A SQL INJECTION VULNERABILITIES
// USING THIS IN PRODUCTION CAN EASILY LEAD TO BEING HACKED
// DELETE THIS AFTER YOU HAVE TESTED THE EXAMPLE AND DO NOT USE
// ********************************************************************************************
// ********************************************************************************************
// ********************************************************************************************



$app->get('/api/inject/{id}', function (Request $request, Response $response) {
    $id = $request->getattribute('id');
	
    $sql = "SELECT * FROM Players WHERE id = $id";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        
	$stmt = $db->prepare($sql);
	$stmt = $db->query($sql);
	
        $players = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($players[0]);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


