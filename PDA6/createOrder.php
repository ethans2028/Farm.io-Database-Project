<html>
  <head>
    <title>Create Order</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="icon" href="logo.png" />
  </head>
  <body>
  <a href="http://css1.seattleu.edu/~iparikh/PDA6/home.html"> Go to Main Page </a>
    <?php 

    error_reporting(E_ALL);
    ini_set('display_errors', '1');



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

    function containsSid($sid) {
      //test query
      $sid = (int) $sid;
      $q = "select * from Store where sid = ".$sid.";";

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

    function containsPid($pid) {
      //test query
      $pid = (int) $pid;
      $q = "select * from Product where pid = ".$pid.";";

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


    function validInt($p) {
      if(preg_match("/[a-z]/i", (string) $p)) { //print an error if there are any letters in sid
        print "ERROR: inputted quantity contains letters";
        exit;
      } else if(ctype_space((string) stripslashes($p))) {
        print "ERROR: only whitespaces inputted in quantity";
        exit;
      }
  
      trim($p);
      if(strlen((string)stripslashes($p)) == 0) {
        print "ERROR: no inputted store ID";
        exit;
      }
    }

    





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
    
    //get parameters
    $pid = $_POST['pid'];
    $sid = $_POST['sid']; //get sid information inputted by user and format
    $quantity = $_POST['quantity'];
    $deliveryDate = $_POST['date'];

    //make sure each field is valid
    validInt($pid);
    validInt($sid);
    validInt($quantity);


    
    trim($pid);
    trim($sid);
    trim($quantity);
    trim($deliveryDate);

    $deliveryDate = stripslashes($deliveryDate);
    $pid = (int) (stripslashes($pid));
    $sid = (int) (stripslashes($sid));
    $quantity = (int) (stripslashes($quantity));
    $oid = 0;

    
    if(containsPid($pid) == false || containsSid($sid) == false) {
      print "ERROR: one or more ID values does not exist in table";
      exit;
    }
    
    if($quantity <= 0) {
      print "ERROR: invalid quantity value";
      exit;
    }

    
    //keep generating oid while contains new oid
    for($oid = (int) (rand() + 1); containsOid($oid); $oid++) {}

    //create order
    $result = mysql_query("insert into bw_db58.Order values(".$oid.", '".$deliveryDate."' );");
    if(!$result) {
      print "ERROR: failure in query execution";
      $error = mysql_error();
      print "<p>" . $error . "</p>";
      exit;
    }

    //create a contains and places relationship
    $result = mysql_query("insert into Places values(".$oid.", ".$sid.");");
    if(!$result) {
      print "ERROR: failure in query execution";
      $error = mysql_error();
      print "<p>" . $error . "</p>";
      exit;
    }

    $result = mysql_query("insert into Contains values(".$oid.", ".$pid.", ".$quantity.");");
    if(!$result) {
      print "ERROR: failure in query execution";
      $error = mysql_error();
      print "<p>" . $error . "</p>";
      exit;
    }
  

    //confirm order success
    print "Order creation success!";
    
    print "</div>";
    mysql_close($conn);

    ?>

    <br /> <br />
  </body>
</html> 