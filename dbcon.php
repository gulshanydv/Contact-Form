<?php

$server = 'localhost';
$user = 'root';
$password = '';
$db = 'emailphp';
$con = mysqli_connect($server, $user, $password, $db);

if (!$con) {
?>
    <script>
        alert("Connection failed");
    </script>

<?php
}


?>