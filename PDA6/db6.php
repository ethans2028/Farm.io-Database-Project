<!-- db1.php
     A PHP script to update the value of a tuple's field in a designated database
     through MySQL
     -->
<html>
<head>
<title> Updatee a tuple from the database with MySQL </title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<?php

// Connect to MySQL

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

$table = $_POST['table'];
$aName = $_POST['aName'];
$aVal = $_POST['aVal'];
$pk = $_POST['pk'];
$val = $_POST['val'];

// testing purpose (remove it after you complete testing!!!)
print "Table: ".$table."<br />";
print "aName: ".$aName."<br />";
print "aVal: ".$aVal."<br />";
print "PK attr: ".$pk."<br />";
print "PK value: ".$val."<br />";

// Clean up the given query (delete leading and trailing whitespace)
trim($table);
trim($aName);
trim($aVal);
trim($pk);
trim($val);

// remove the extra slashes
$table = stripslashes($table);
$aName = stripslashes($aName);
$aVal = stripslashes($aVal);
$pk = stripslashes($pk);
$val = stripslashes($val);


// Delete query
$query = 
'update '.$table.
' set ' .$aName. ' = ' .$aVal.
' where '.$pk.'='.$val.';';

// Testing (remove it when testing is done!!!)
print "<p>Query: ".$query."</p>";

// Execute the query
$result = mysql_query($query);
if (!$result) {
    print "Error - the query could not be executed";
    $error = mysql_error();
    print "<p>" . $error . "</p>";
    exit;
}

// successful deletion statement
print "$aName field updated with value $aVal for tuple with $val for $pk attribute in $table table";

mysql_close($conn);
?>

<br /><br />
<a href="http://css1.seattleu.edu/~iparikh/dbtest/db.html"> Go to Main Page </a>

</body>
</html>
