<html>
  <head>
    <title>Store information</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="icon" href="logo.png" />
  </head>
  <body>
  <div style="display:inline; align-items: center; justify-content: center;">
    <img src="logo.png" height="70px" width="auto" />
  </div>
  <a href="http://css1.seattleu.edu/~iparikh/PDA6/home.html"> Go to Main Page </a>
    <?php
    //debugging
    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');
    //mysql connection information (must be on SU vpn)
    //1. Show all information on all stores in the database
      //Functionality number: 1
    $dbName = "bw_db58";    //default database name (changer per user)
    $server = "cs100.seattleu.edu"; //server page hosted on
    $user = "user58";               //replace with own username 
    $password = "ANSFbOnnnnn#12";  //replace with own password

    //connect and check for failure
    $conn= mysql_connect($server, $user, $password);
    if(!$conn) {
      print "ERROR 500: Could not create connection to database </br>";
      print "Potential fixes: connect to SU VPN";
      exit;
    }
    
    //select database to use within connection, check for failure
    $dbAccess = mysql_select_db($dbName, $conn);
    if(!$dbAccess) {
      print "ERROR: Cannot access project database";
      exit;
    }
    
    //define query
    $sid = $_POST['sid']; //get sid information inputted by user and format
    if(preg_match("/[a-z]/i", (string) $sid)) { //print an error if there are any letters in sid
      print "ERROR: inputted Store ID contains letters";
      exit;
    } else if(ctype_space((string) stripslashes($sid))) {
      print "ERROR: only whitespaces inputted";
      exit;
    }

    trim($sid);
    if(strlen((string)stripslashes($sid)) == 0) {
      print "ERROR: no inputted store ID";
      exit;
    }

    $sid = (int) stripslashes($sid);
    $query = "select o.oid, pr.name, c.quantity from Places p, bw_db58.Order o, Contains c, Product pr where ".$sid." = p.sid AND p.oid = o.oid AND o.oid = c.oid AND c.pid = pr.pid";
      
    //make  query
    $result = mysql_query($query);
    if (!$result) {
      print "ERROR: failure in query execution";
      $error = mysql_error();
      print "<p>" . $error . "</p>";
      exit;
    }

    // Get the number of rows in the result
    $num_rows = mysql_num_rows($result);

    // Get the number of fields in the rows
    $fieldCount = mysql_num_fields($result);


    // Get the first row
    $row = mysql_fetch_array($result);

    //center using flexbox
    print "<div class='centerContent'>";

    //print in table format
    print "<h2> Order information for Store SID: ".$sid." </h2>";
    print "<table>";
    print "<tr align = 'center'>";

    //make column labels
    $col = array_keys($row);
    for($i = 0; $i < $fieldCount; $i++)
      print "<th>" . $col[2 * $i+ 1] . "</th>";
    print "</tr>";

    //print all values of each tuple in table format
    for($i = 0; $i < $num_rows; $i++, $row = mysql_fetch_array($result)) {
      print "<tr align = 'center'>";
      $values = array_values($row);

      //print all alues in row
      for ($j = 0; $j < $fieldCount; $j++){
        $value = htmlspecialchars($values[2 * $j + 1]);
        print "<td>".$value."</td> ";
      }

      print "</tr>";
    }

    print "</table>";
    print "</div>";
    mysql_close($conn);
    ?>

    <br /> <br />
  </body>
</html> 