<!-- db1.php
     A PHP script to delete a tuple from a specific database
     through MySQL
     -->
<html>
<head>
<title> Delete a tuple from the farm database with MySQL </title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<a href="http://css1.seattleu.edu/~iparikh/PDA6/home.html"> Go to Main Page </a>
<?php

function containsOid($oid) {
    //test query
    $oid = (int) $oid;
    $q = "select * from bw_db58.Order where oid = ".$oid.";";

    //if contains a tuple return true, else false
    $result = mysql_query($q);
    if (!$result) {
      print "ERROR: failure in query execution";
      $error = mysql_error();
      print "<p>" . $error . "</p>";
      exit;
    }


    if(mysql_num_rows($result) >= 1) {
      return true;
    }
    return false;
}

$servername = "cs100.seattleu.edu";
$username = "user58";
$password = "ANSFbOnnnnn#12";

$conn = mysql_connect($servername, $username, $password);

if (!$conn) {
     print "Error - Could not connect to MySQL ".$conn;
     exit;
}

// change to your default db for PDA6!!!
$dbname = "bw_db58";

$db = mysql_select_db($dbname, $conn);
if (!$db) {
    print "Error - Could not select the sailor database ".$dbname;
    exit;
}

$oid = $_POST['oid'];

if(preg_match("/[a-z]/i", (string) $oid)) { //print an error if there are any letters in sid
    print "ERROR: inputted order ID contains letters";
    exit;
} else if(ctype_space((string) stripslashes($oid))) {
    print "ERROR: only whitespaces inputted";
    exit;
}



// Clean up the given query (delete leading and trailing whitespace)
trim($oid);

// remove the extra slashes
$oid = (int) stripslashes($oid);


if(!containsOid($oid)) {
    print "ERROR: invalid order ID value";
    exit;
}



// Delete query for all instances of oid
$query = 'delete from bw_db58.Order where oid='.$oid.';';

// Execute the query
$result = mysql_query($query);
if (!$result) {
    print "Error - the query could not be executed";
    $error = mysql_error();
    print "<p>" . $error . "</p>";
    exit;
}

$query = 'delete from bw_db58.Fulfills where oid='.$oid.';';

// Execute the query
$result = mysql_query($query);
if (!$result) {
    print "Error - the query could not be executed";
    $error = mysql_error();
    print "<p>" . $error . "</p>";
    exit;
}

$query = 'delete from bw_db58.Contains where oid='.$oid.';';

// Execute the query
$result = mysql_query($query);
if (!$result) {
    print "Error - the query could not be executed";
    $error = mysql_error();
    print "<p>" . $error . "</p>";
    exit;
}

$query = 'delete from bw_db58.Places where oid='.$oid.';';

// Execute the query
$result = mysql_query($query);
if (!$result) {
    print "Error - the query could not be executed";
    $error = mysql_error();
    print "<p>" . $error . "</p>";
    exit;
}

// successful deletion statement
print "Order ".$oid." removed!";
mysql_close($conn);

?>

<br /><br />

</body>
</html>
