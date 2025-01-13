

<?php
/*
try {
    $conn = new PDO("mysql:host=localhost;dbname=salespulsedb", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
*/
?>


<?php
try {
    $conn = new PDO("mysql:host=127.0.0.1;port=3306;dbname=u390688067_salespulse_db", "u390688067_un_salespulse", "Pass-salespulse123");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connection successful!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
