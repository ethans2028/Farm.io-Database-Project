<html>
  <head>
    <title>Store information</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="icon" href="logo.png" />
  </head>
  <body>
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
    $query = "select * from Store LIMIT 100;";
      
    //make  query
    $result = mysql_query($query);
    if (!$result) {
      print "ERROR: the query could not be executed";
      $error = mysql_error();
      print "<p>" . $error . "</p>";
      exit;
    }

    // Get the number of rows in the result
    $num_rows = mysql_num_rows($result);

    // Get the number of fields in the rows
    $num_fields = mysql_num_fields($result);


    // Get the first row
    $row = mysql_fetch_array($result);

    //center using flexbox
    print "<div class='centerContent'>";

    //print in table format
    print "<h> Store Information </h1>";
    print "<table border='border'>";
    print "<tr align = 'center'>";

    //make column labels
    $keys = array_keys($row);
    for($i = 0; $i < $num_fields; $i++)
      print "<th>" . $keys[2 * $i+ 1] . "</th>";
    print "</tr>";

    //print all values of each tuple in table format
    for($i = 0; $i < $num_rows; $i++) {
      print "<tr align = 'center'>";
      $values = array_values($row);

      for ($index = 0; $index < $num_fields; $index++){
        $value = htmlspecialchars($values[2 * $index + 1]);
        print "<td>".$value."</td> ";
      }

      print "</tr>";
      $row = mysql_fetch_array($result);
    }



    //print table name, fields and datatypes for each field

    print "</table>";
    print "</div>";
    mysql_close($conn);
    ?>

    <br /> <br />
  </body>
</html> 