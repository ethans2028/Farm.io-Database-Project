<!-- db1.php
     Execute equal join queries
     through MySQL
     -->
<html>
<head>
<title> Access the cars database with MySQL </title>
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
$selectVal = $_POST['selectVal'];
$table1 = $_POST['table1'];
$table2	= $_POST['table2'];
$pk1 = $_POST['pk1'];
$pk2 = $_POST['pk2'];
$val = $_POST['val'];

// testing purpose (remove it after you complete testing!!!)
print "selectVal: ".$selectVal."<br />";
print "Table1: ".$table1."<br />";
print "Table2: ".$table2."<br />";
print "PK1 attr: ".$pk1."<br />";
print "PK2 attribute: ".$pk2."<br />";
print "value for PK2:" .$val."<br />";

// Clean up the given query (delete leading and trailing whitespace)
trim($selectVal);
trim($table1);
trim($table2);
trim($pk1);
trim($pk2);
trim($val);

// remove the extra slashes
$selectVal = stripslashes($selectVal);
$table1 = stripslashes($table1);
$table2 = stripslashes($table2);
$pk1 = stripslashes($pk1);
$pk2 = stripslashes($pk2);
$val = stripslashes($val);

$query = 
'select t1.' .$selectVal. 
' from '.$table1.' t1, ' .$table2. ' t2 
where t1.' .$pk1.' = t2.'.$pk1. ' and t2.'.$pk2.' = '.$val.';';

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

// Get the number of rows in the result
$num_rows = mysql_num_rows($result);

print "Number of rows = $num_rows <br />";

// Get the number of fields in the rows
$num_fields = mysql_num_fields($result);
print "Number of fields = $num_fields <br />";

// Display the results in a table
print "<table border='border'><caption> <h2> Query Results </h2> </caption>";
print "<tr align = 'center'>";

// Produce the column labels
$keys = array_keys($row);
for ($index = 0; $index < $num_fields; $index++) 
    print "<th>" . $keys[2 * $index + 1] . "</th>";

print "</tr>";


// Output the values of the fields in the rows
for ($row_num = 0; $row_num < $num_rows; $row_num++) {
	
	// Get the tuples
	$row = mysql_fetch_array($result);
	
    print "<tr align = 'center'>";
    $values = array_values($row);
	
    for ($index = 0; $index < $num_fields; $index++){
        $value = htmlspecialchars($values[2 * $index + 1]);
        print "<td>" . $value . "</td> ";
    }

    print "</tr>";
    $row = mysql_fetch_array($result);
}

print "</table>";

mysql_close($conn);
?>

<br /><br />
<a href="http://css1.seattleu.edu/~iparikh/dbtest/db.html"> Go to Main Page </a>

</body>
</html>
