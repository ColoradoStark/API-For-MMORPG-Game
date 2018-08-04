<?php
echo 'database setup';

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "GAME";

///////////////////////////////////////////////
// CREATE DB

try {
    $pdo = new PDO("mysql:host=localhost;", "$username", "$password");
    $stmt = $pdo->query("CREATE DATABASE $dbname");
    $stmt = $pdo->query("SHOW DATABASES");
    var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}
catch (PDOException $e) {
    echo $e->getMessage();
}

$pdo = NULL;

///////////////////////////////////////////////
// CREATE TABLE

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $sql = "CREATE TABLE Players (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    playername VARCHAR(30) NOT NULL,
    class ENUM('fighter', 'wizard', 'healer', 'archer'),
    weapon VARCHAR(30),
    weaponelement ENUM('none', 'ice', 'fire', 'earth', 'dark'),
    playerlevel INT UNSIGNED NOT NULL DEFAULT 0,
    weaponlevel INT UNSIGNED NOT NULL DEFAULT 0,
    hp INT UNSIGNED NOT NULL DEFAULT 20,
    mana INT UNSIGNED NOT NULL DEFAULT 20,
    gold INT UNSIGNED NOT NULL DEFAULT 100,
    strength INT UNSIGNED NOT NULL DEFAULT 8,
    dexterity INT UNSIGNED NOT NULL DEFAULT 8,
    intelligence INT UNSIGNED NOT NULL DEFAULT 8,
    constitution INT UNSIGNED NOT NULL DEFAULT 8,
    reg_date TIMESTAMP
    )";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Table MyGuests created successfully";

    $stmt = $conn->query("DESCRIBE Players");
    var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;

///////////////////////////////////////////////
// INSERT TEST DATA

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO Players (playername, class, playerlevel)
    VALUES ('Geronimo', 'archer', '66'),
    ('Sitting Bull', 'fighter', '21'),
    ('Pocahontas', 'healer', '33'),
    ('Sequoia', 'wizard', '99')";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "New record created successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;


?>
