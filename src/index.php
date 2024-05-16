<?php
 ob_start();
// Jika Pass atau username salah
session_start();
if (!isset($_SESSION["authenticated"]) ) {
    header("Location: login.php");
    exit();
ob_end_flush();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style\style.css">
    <title>Monitor Page</title>
</head>
<body>
   <?php
    $server_ip = $_SERVER['SERVER_ADDR'];
    ?>
    <div class="nav">
            <div class="logo">
                <p><a href="index.php">Remote Wifi Monitor</a> </p>
            </div>

            <div class="right-links">
                <a href="admin.php" ><button class="btn" >Admin Page</button></a>
                <a href="logout.php"> <button class="btn">Log Out</button> </a>
            </div>
    </div>

    <?php
        $conn = new mysqli("mysql_db", "root", "", "ping");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        function getAllTables($conn) {
            $tables = array();
            $result = $conn->query("SHOW TABLES");
            while ($row = $result->fetch_assoc()) {
                $tables[] = $row['Tables_in_ping'];
            }
            return $tables;
        }

        function updateIPStatus($conn, $tableName) {
            $result = $conn->query("SELECT * FROM $tableName");
            while ($row = $result->fetch_assoc()) {
                $ip = $row['ip'];
                $ping = exec("/bin/ping -c 1 -W 1 $ip", $output, $status);
                updateDatabase($conn, $ip, $status, $tableName);
            }
        }

        function updateDatabase($conn, $ip, $status, $tableName) {
            $sql = "UPDATE $tableName SET status='$status' WHERE ip='$ip'";
            $conn->query($sql);
        }

        function displayAllTables($conn) {
            $allTables = getAllTables($conn);

            foreach ($allTables as $table) {
                // echo "<h2 >$table</h2>";

                $result = $conn->query("SELECT * FROM $table");
                $ipList = array();
                while ($row = $result->fetch_assoc()) {
                    $ipList[] = array($row['ip'], $row['description']);
                }

                $results = array();
                foreach ($ipList as $j => $ipItem) {
                    $ip = $ipItem[0];
                    $ping = exec("/bin/ping -c 1 -W 1 $ip", $output, $status);
                    $results[] = $status;
                    updateDatabase($conn, $ip, $status, $table);
                }

                displayTable("Monitoring $table", $results, $ipList);
            }
        }

        function displayTable($title, $results, $ipList) {
            echo '<font face=Courier New>';
                // echo '<section class="table__body">';
                    echo "<table border=1 style=border-collapse:collapse>
                        <th colspan=4> $title </th>
                        <tr>
                        <td align=right width=20>#</td>
                        <td width=100>IP/URL</td>
                        <td width=100>Status</td>
                        <td width=250>Description</td>
                    </tr>";
                    foreach($results as $item => $k){
                        echo '<tr>';
                        echo '<td>'.$item.'</td>';
                        echo '<td>'.$ipList[$item][0].'</td>';
                        if($results[$item]==0){
                            echo '<td style=color:green>Online</td>';
                        }
                        else{
                            echo '<td style=color:red>Offline</td>';
                        }
                        echo '<td>'.$ipList[$item][1].'</td>';
                        echo '</tr>';
                    }
                    echo "</table>";
                    echo '</font>';
            header("refresh: 5");

        }

        // Display all tables
        displayAllTables($conn);

        $conn->close();
    ?>



    <script>
        function updateTable() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "updateTable.php", true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var updatedResults = JSON.parse(xhr.responseText);
                    updateTableContent(updatedResults);
                }
            };

            xhr.send();
        }

        function updateTableContent(updatedResults) {
            // Logika untuk memperbarui tabel dengan data terkini
            // ...
        }

        setInterval(updateTable, 10000);
    </script>

</body>
</html>