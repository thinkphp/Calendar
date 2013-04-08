<?php

require_once('config.php');

sleep(2);

if(isset($_GET['title_event']) && 

         isset($_GET['startMon']) && 

            isset($_GET['startDay']) && 

                 isset($_GET['startYear']) && 

                      isset($_GET['startHourMerid']) && isset($_GET['startMin'])) {

$title = $_GET['title_event'];

$year = $_GET['startYear'];

$mon = str_pad($_GET['startMon'],2,"0",STR_PAD_LEFT);;

$day = str_pad($_GET['startDay'],2,"0",STR_PAD_LEFT);

$hour = $_GET['startHourMerid'];

$min = str_pad($_GET['startMin'],2,"0",STR_PAD_LEFT);

$date = $year.'-'.$mon.'-'.$day.' '.$hour.':'.$min;

$db = mysql_connect($host,$username,$password);

mysql_select_db($database,$db);
         
$query = "insert into events(event_title,event_date) VALUES ('$title','$date')";

$result = mysql_query($query) or die('<p style="color: #fff;font-weight: bold;background: #c00;padding:2px;margin-left:5px;width:240px;text-align: center">Cannot get the results!</p>');

if($result) {echo'<p style="color: #fff;font-weight: bold;background: #393;padding:2px;margin-left:5px;width:240px;text-align: center">Added Event successfully!</p>';}

        else { echo'<p style="color: #fff;font-weight: bold;background: #c00;padding:2px;margin-left:5px;width:240px;text-align: center">Error internal!</p>';}
}

mysql_close($db);
?>