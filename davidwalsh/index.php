<?php
require_once('config.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="calendar.css"/>
</head>
<body>
<?php
function draw_calendar($month,$year,$events) {

        $running_day = date('w',mktime(0,0,0,$month,1,$year));

        $days_in_month = date('t',mktime(0,0,0,$month,1,$year));

        $days_in_this_week = 1;

        $day_counter = 0;

        $calendar .= '<ol class="calendar">';

        $calendar .= '<li id="lastmonth">';

        $calendar .= '<ul>';

         /* print "blank" days until the first of the current week */
         for($x = 0; $x < $running_day; $x++) {

                $calendar .= '<li>&nbsp;</li>';

                $days_in_this_week++;

         }//endfor

        $calendar .= '</ul>';

        $calendar .= '<li id="thismonth">';

        $calendar .= '<ul>';

        for($list_day=1;$list_day<=$days_in_month;$list_day++) {

                $calendar .= '<li>';
 
                if($list_day == date("j",mktime(0,0,0,$month)) && $month == date("n") && $year == date("Y")) {

                   /* add in the day number */
                   $calendar .= '<span class="current-day">'.str_pad($list_day,2,"0",STR_PAD_LEFT).'</span>';

                } else {

                   /* add in the day number */
                   $calendar .= ''.str_pad($list_day,2,"0",STR_PAD_LEFT).'';
                }

               /********** QUERY THE DATABASE  ********/

               $event_day = $year.'-'.str_pad($month,2,"0",STR_PAD_LEFT).'-'.str_pad($list_day,2,"0",STR_PAD_LEFT);
 
               if(isset($events[$event_day])) {

                        foreach($events[$event_day] as $event) {

                                $calendar .= '<p>'.$event['event_title'].'</p>'; 
                        } 
               } else {


                      $calendar .= str_repeat('<p>&nbsp;</p>',2);
               }

              /********** QUERY THE DATABASE ********/

                $calendar .= '</li>';


               if($running_day == 6) {

                  if(($day_counter+1) != $days_in_month) 

                      $running_day = -1;

                      $days_in_this_week = 0; 
        
               }//endif

 

              $days_in_this_week++; $running_day++; $day_counter++;

        }//end foreach

        $calendar .= '</ul>';

        $calendar .= '</li>';


        $calendar .= '<li id="nextmonth">';

          $calendar .= '<ul>';

          if($days_in_this_week < 8) {

            for($x=1;$x <= (8-$days_in_this_week);$x++) {

              $calendar .= '<li>&nbsp;</li>';

            }

          }//endif

          $calendar .= '</ul>';

        $calendar .= '</li>';


        $calendar .= '</ol>';

return $calendar;
}


$month = str_pad(($_GET['month'] ? $_GET['month'] : date('m')),2,"0", STR_PAD_LEFT);

$year = (int)($_GET['year'] ? $_GET['year'] : date("Y"));

$currurl = $_SERVER['PHP_SELF'];

echo "<div id='header'><a class='control' href='$currurl?month=". ( $month != 1 ? $month - 1 : 12) ."&year=". ( $month != 1 ? $year : $year - 1 ) ."'>&laquo; Prev month</a> ".date('F',mktime(0,0,0,$month,1,$year))." " . $year . " <a class='control' href='$currurl?month=". ( $month != 12 ? $month + 1 : 1) ."&year=". ( $month != 12 ? $year : $year + 1 ) ."'>Next month &raquo;</a> <a class='control' href='$currurl?month=". date('n')."&year=". date('Y') ."'>Today</a></div>";

$events = array();

//connect to database
$db = mysql_connect($host,$username,$password);

//select the database
mysql_select_db($database,$db);
         
//create the query
$query = "SELECT event_title, DATE_FORMAT(event_date,'%Y-%m-%d') as event_date FROM events  WHERE event_date LIKE '$year-$month%'";

//make query
$result = mysql_query($query) or die('Cannot get the results!');

//hold results in vector
while($row = mysql_fetch_assoc($result)) {

      $events[$row['event_date']][] = $row;   
}

//close connection to the database
mysql_close($db);
echo'<!-- start calendar -->';
echo draw_calendar($month,$year,$events);
echo'<!-- end calendar -->';
$form = file_get_contents("form.html");
echo'<!-- start form add events for calendar -->';
echo$form;
echo'<!-- end form add events for calendar -->';
?>
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript" src="form.js"></script>
</body>
</html>