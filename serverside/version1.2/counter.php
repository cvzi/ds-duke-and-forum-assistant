<?php
$password = "asdfghjkl";

if(!isset($maske))
  {
  $maske = "Tag: %today%<br />Gestern: %yesterday%<br />Gesamt: %all%";
  }

$db_host = "localhost";
$db_username = "cuzi";
$db_password = "asdfghjkl";
$db_name = "cuzi_01";
$db_table = "WebsiteCounter";

// Connect to MySQL
$db_link =  @mysql_connect($db_host,$db_username,$db_password);
if(!$db_link)
  {
  echo "MySQL Connecting failed!";
  return;
  }

// Select Database
if(!@mysql_select_db($db_name, $db_link))
  {
  echo "MySQL Database Selecting failed!";
  return;
  }
  
// Setup

if($_GET['setup'] == $password)
  {
  $command = "CREATE TABLE IF NOT EXISTS `".$db_table."` (
  `day` VARCHAR( 10 ) NOT NULL ,
  `time` INT( 255 ) NOT NULL ,
  `ip` VARCHAR( 16 ) NOT NULL )";
  $query[0] = mysql_query($command);

  $command = "TRUNCATE `".$db_table."`";
  $query[1] = mysql_query($command);

  if($query[0] and $query[1])
    exit("Table created, data reseted!");
  echo "<pre>";
  mysql_error();
  echo "<hr>";
  var_dump($query);
  echo "</pre>";
  exit("Erro occured!");
  }

// Output

$today = date("j-m-y");
$now = time();
$userip = getenv("REMOTE_ADDR");
$daycount = 0;
$yesterdaycount = 0;
$yesterday = time() - (60*60*24);
$yesterday = date("j-m-y",$yesterday);

// Today
$command = "SELECT `ip` FROM `".$db_table."` WHERE `day` LIKE '".$today."'";
$query = mysql_query($command);
while($entity = mysql_fetch_object($query))
  {
  if($entity->ip == $userip)
    $known = true;
  $daycount = $daycount + 1;
  }

//Yesterday

$command = "SELECT `ip` FROM `".$db_table."` WHERE `day` LIKE '".$yesterday."'";
$query = mysql_query($command);
if($query)
  {
  while($entity = mysql_fetch_object($query))
    {
    if($entity->ip == $userip)
      $known = true;
    $yesterdaycount = $yesterdaycount + 1;
    }
  }

// All
$command = "SELECT `ip` FROM `".$db_table."`";
$query = mysql_query($command);
$allcount = mysql_num_rows($query);


$output = str_replace("%today%",$daycount,$maske);
$output = str_replace("%all%",$allcount,$output);
$output = str_replace("%yesterday%",$yesterdaycount,$output);

echo $output;


// Save new IP
if(!$known)
  {
  if(!mysql_query("INSERT INTO `".$db_table."` SET day='".$today."', time='".$now."', ip='".$userip."'"))
    exit("Could not insert new entity!");
  }

?>