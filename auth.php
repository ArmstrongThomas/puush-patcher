<?php
include 'includes/config/Database.conf.php';
include 'includes/classes/Database.class.php';

$DB = new Database($dbhost, $dbport, $dbuser, $dbpass, $dbname);

if (isset($_POST["e"], $_POST["p"])) {
    $email = $_POST["e"];
    $password = $_POST["p"];

    $stmt = $DB->prepare("SELECT password, apikey FROM accounts WHERE email = ?");
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && password_verify($password, $result["password"])) {
        echo sprintf("1,%s,LIFETIME,0", $result["apikey"]);
    } else {
        echo "-1";
    }
} else if (isset($_POST["e"], $_POST["k"])) {
    echo $DB->userLoginByKey($_POST["e"], $_POST["k"]);
} else {
    echo "-1";
}
