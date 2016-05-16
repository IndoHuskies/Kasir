<?php
header('Access-Control-Allow-Origin: *');

$servername = "localhost";
$db_name = "";
$username = "";
$password = "";


try {
  $dbh = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password, 
      array(PDO::ATTR_PERSISTENT => true));
} catch (Exception $e) {
  // handle no connection
  die("Unable to connect: " . $e->getMessage());
}

$name = $_POST["name"];

$item = $dbh->quote($_POST["item"]);
$ticket = $dbh->quote($_POST["ticket"]);
$cash = $dbh->quote($_POST["cash"]);
$payment = $dbh->quote($_POST["payment"]);
$password = $dbh->quote($_POST["password"]);
$time = $dbh->quote($_POST["time"]);
$comment = $dbh->quote($_POST["comment"]);

$sql = "INSERT INTO :name
      (item, ticket, cash, payment_type, password, transaction_time, comment) 
      VALUES 
      (:item, :ticket, :cash, :payment, :password, :time, :comment)";

$stmt = $conn->prepare($sql);

$stmt->bindParam(':name', $name, PDO::PARAM_STR); 
$stmt->bindParam(':item', $item, PDO::PARAM_STR);    
$stmt->bindParam(':ticket', $ticket, PDO::PARAM_INT); 
$stmt->bindParam(':cash', $cash, PDO::PARAM_INT); 
$stmt->bindParam(':payment', $payment, PDO::PARAM_STR);    
$stmt->bindParam(':password', $password, PDO::PARAM_STR);    
$stmt->bindParam(':time', $time, PDO::PARAM_STR);    
$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);    



try {  
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $dbh->beginTransaction();
  $sql = "INSERT INTO :name
      (item, ticket, cash, payment_type, password, transaction_time, comment) 
      VALUES 
      (:item, :ticket, :cash, :payment, :password, :time, :comment)";

  $stmt = $dbh->prepare($sql);

  $stmt->bindParam(':name', $name, PDO::PARAM_STR); 
  $stmt->bindParam(':item', $item, PDO::PARAM_STR);    
  $stmt->bindParam(':ticket', $ticket, PDO::PARAM_INT); 
  $stmt->bindParam(':cash', $cash, PDO::PARAM_INT); 
  $stmt->bindParam(':payment', $payment, PDO::PARAM_STR);    
  $stmt->bindParam(':password', $password, PDO::PARAM_STR);    
  $stmt->bindParam(':time', $time, PDO::PARAM_STR);    
  $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);   

  $stmt->execute()

  $dbh->commit();
  
} catch (Exception $e) {
  $dbh->rollBack();
  // handle rollback
  echo "Failed: " . $e->getMessage();
}


// write to local file in server
$entry = $item . "-" . $ticket . "-" . $cash . "-" . $payment . "-" . $time . "-" . $comment
$ret = exec("python backup.py " . $name . " " . $entry)

if ($ret == "success") {
  echo $ret
} else {
  echo "Failed to backup"
}
?>