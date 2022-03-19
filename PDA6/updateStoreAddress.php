<!-- db1.php
     A PHP script to update the value of a tuple's field in a designated database
     through MySQL
     -->
<html>
<head>
<title> Update a tuple from the database with MySQL </title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<a href="http://css1.seattleu.edu/~iparikh/PDA6/home.html"> Go to Main Page </a>
<?php
function containsSid($sid) {
    //test query
    $sid = (int) $sid;
    $q = "select * from bw_db58.Store where sid = ".$sid.";";

    $result = mysql_query($q);
    if (!$result) {
      print "ERROR: failure in query execution";
      $error = mysql_error();
      print "<p>" . $error . "</p>";
      exit;
    }


    //if contains a tuple return true, else false
    if(mysql_num_rows($result) >= 1) {
      return true;
    }
    return false;
}

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
    print "Error - Could not select database";
    exit;
}

$address = $_POST['address'];
$sid = $_POST['sid'];

//check if letters or whitespace
if(preg_match("/[a-z]/i", (string) $sid)) { //print an error if there are any letters in sid
    print "ERROR: inputted store ID contains letters";
    exit;
} else if(ctype_space((string) stripslashes($sid))) {
    print "ERROR: only whitespaces inputted in store ID";
    exit;
}


//Clean up the given query (delete leading and trailing whitespace)
trim($address);
trim($sid);

//remove the extra slashes
$address = stripslashes($address);
$sid = (int) stripslashes($sid);

//check valid sid
if(containsSid($sid) == false){
    print "ERROR: invalid SID";
    exit;
}

//udpate query
$query = "update Store set address = '".$address."' where sid = ".$sid.";";

// Execute the query
$result = mysql_query($query);
if (!$result) {
    print "Error: the query could not be executed";
    $error = mysql_error();
    print "<p>".$error."</p>";
    exit;
}

// successful deletion statement
print "Address updated";

mysql_close($conn);
?>

<br /><br />

</body>
</html>
