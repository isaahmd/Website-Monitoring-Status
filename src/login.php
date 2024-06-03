<?php 
session_start();
if (isset($_SESSION["authenticated"]) ) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $users = array(
        "user1" => "password1",
        "user2" => "password2",
        "isa" => "123",
        "zege" => "123",
        // Add more users as needed
    );

    // Validasi uname + pw
    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION["authenticated"] = true;
        header("Location: index.php");
        
    } else {
        echo "<div class='message'>
            <p>Invalid username or password</p>
            </div> <br>";
        // $_SESSION["authenticated"] = false;
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style\style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <form method="post" action="">
                <div class="field input">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username">
                    <br>
                </div>

                <div class="field input">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password">
                    <br>
                </div>

                <div class="field">
                    <button type="submit" class="btn">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
