<?php
include 'includes/config/Database.conf.php';
include 'includes/config/Global.conf.php';
include 'includes/classes/Database.class.php';

$DB = new Database($dbhost, $dbport, $dbuser, $dbpass, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
        $stmt = $DB->prepare("SELECT email FROM accounts WHERE email = ?");
        $stmt->bindParam(1, $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Email already exists.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $apiKey = substr(hash('sha256', $email . time()), 0, 24);

            $stmt = $DB->prepare("INSERT INTO accounts (email, password, apikey, domain) VALUES (?, ?, ?, ?)");
            $stmt->bindParam(1, $email);
            $stmt->bindParam(2, $hashedPassword);
            $stmt->bindParam(3, $apiKey);
            $stmt->bindParam(4, $domain);

            if ($stmt->execute()) {
                echo "Registration successful!";
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
            }
        }
    } else {
        echo "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<form method="POST" action="">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Register</button>
</form>
</body>
</html>