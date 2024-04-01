<?php  //資料庫連接
if (!function_exists('connect2db')) {
  function connect2db($dbhost, $dbuser, $dbpwd, $dbname) {
    $dsn = "mysql:host=$dbhost;dbname=$dbname";
    try {
        $db_conn = new PDO($dsn, $dbuser, $dbpwd);
    }
    catch (PDOException $e) {
        echo $e->getMessage();
        die ("錯誤: 無法連接到資料庫");
    }
    $db_conn->query("SET NAMES UTF8");
    return $db_conn;
}
}
$dbname = "shoppingmull3";
$dbhost = "localhost";
$dbuser = "root";
$dbpwd = "";
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$sqlcmd = "SELECT * FROM info ORDER BY rank";
$stmt = $db_conn->prepare($sqlcmd);
$stmt->execute([]);
$rs = $stmt->fetchAll(PDO::FETCH_ASSOC); 
if (count($rs) <= 0) die ('Unknown or invalid user!');

?>