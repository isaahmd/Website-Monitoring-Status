<?php
// URL security
session_start();
if (!isset($_SESSION["authenticated"]) ) {
    $_SESSION["login"]=true;
    header("Location: login.php");
    exit();
}
$hostname = 'testdb.cj4me64yy3cc.ap-southeast-1.rds.amazonaws.com'; // RDS endpoint
$username = 'ltka';            // RDS master username
$password = 'root1234';            // RDS master password

$conn = new mysqli($hostname, $username, $password, "ping");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handling form submissions
    if (isset($_POST["addTable"])) {
        $tableName = $_POST["tableName"];
        if (preg_match('/\s/', $tableName)) {
            echo "<div class='message'>
            <p>Location name should not contain spaces</p>
            </div> <br>";
        } else {
            createTable($conn, $tableName);
        }
    } elseif (isset($_POST["addIP"])) {
        $tableName = $_POST["tableNameForIP"];
        $ip = $_POST["ip"];
        $description = $_POST["description"];
        addIP($conn, $tableName, $ip, $description);
    } elseif (isset($_POST["deleteIP"])) {
        $tableName = $_POST["tableNameForIP"];
        $ip = $_POST["ipToDelete"];
        deleteIP($conn, $tableName, $ip);
    } elseif (isset($_POST["deleteTable"])) {
        $tableName = $_POST["tableNameToDelete"];
        deleteTable($conn, $tableName);
    }
}
function deleteTable($conn, $tableName) {
    $sql = "DROP TABLE IF EXISTS $tableName";
    $conn->query($sql);
}

function addIP($conn, $tableName, $ip, $description) {
    $sql = "INSERT INTO $tableName (ip, status, description) VALUES ('$ip', '0', '$description')";
    $conn->query($sql);
}

function deleteIP($conn, $tableName, $ip) {
    $sql = "DELETE FROM $tableName WHERE ip='$ip'";
    $conn->query($sql);
}

function createTable($conn, $tableName) {
    $sql = "CREATE TABLE IF NOT EXISTS $tableName (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ip VARCHAR(255) NOT NULL,
        status INT NOT NULL,
        description VARCHAR(255) NOT NULL
    )";
    $conn->query($sql);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style\style.css">
    <title>Admin Page</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="index.php">Admin Page</a> </p>
        </div>

        <div class="right-links">
            <a href="index.php" ><button class="btn" >Monitoring Page</button></a>
            <a href="logout.php"> <button class="btn">Log Out</button> </a>


        </div>
    </div>

    <!-- Add Table Form -->
    <div class="container">
        <div class="box form-box">
            <form method="post">
                <div class="field input">
                    <header>Add Remote Wifi</header>
                    <label for="tableName" ></label>
                    <input type="text" placeholder="Remote Wifi" name="tableName" required>
                    <button type="submit" class="btn" name="addTable">Add Remote Wifi</button>
                </div>

            </form>

            <!-- Add IP Form -->
            <form method="post">
                <div class="field input">
                    <header>Add IP</header>
                    <label for="tableNameForIP"></label>
                    <select name="tableNameForIP" required>
                        <?php
                        $result = $conn->query("SHOW TABLES");
                        while ($row = $result->fetch_row()) {
                            echo "<option value='{$row[0]}'>{$row[0]}</option>";
                        }
                        ?>
                    </select>
                    <label for="ip"></label>
                    <input type="text" placeholder="IP" name="ip" required>
                    <label for="description"></label>
                    <input type="text" placeholder="Location Description" name="description" required>
                    <button type="submit" class="btn" name="addIP">Add IP</button>
                </div>
            </form>

            <!-- Delete IP Form -->

            <form method="post">
                <div class="field input">
                    <header>Remove IP</header>
                    <label for="tableNameForIP"></label>
                    <select name="tableNameForIP" required>
                        <?php
                        $result = $conn->query("SHOW TABLES");
                        while ($row = $result->fetch_row()) {
                            echo "<option value='{$row[0]}'>{$row[0]}</option>";
                        }
                        ?>
                    </select>
                    <label for="ipToDelete"></label>
                    <input type="text" placeholder="IP" name="ipToDelete" required>
                    <button type="submit" class="btn" name="deleteIP">Delete IP</button>
                </div>
            </form>

            <!-- Delete Table Form -->
            <form method="post">
                <div class="field input">
                    <header>Remove Remote Wifi</header>
                    <label for="tableNameToDelete"></label>
                    <select name="tableNameToDelete" required>
                        <?php
                        $result = $conn->query("SHOW TABLES");
                        while ($row = $result->fetch_row()) {
                            echo "<option value='{$row[0]}'>{$row[0]}</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn" name="deleteTable">Delete Remote Wifi</button>
                </div>
            </form>
        </div>
    </div>

    <body>
    </body>

</form>


</body>
</html>
