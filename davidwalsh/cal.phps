<?php

    function draw_calendar($month,$year) {

        /* draw table */

        $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

        /* table heading */

        $heading = array("Sunday","Monday","Thuesday","Wednesday","Thursday","Friday","Saturday");                

        $calendar .= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$heading).'</td></tr>';

        $running_day = date('w',mktime(0,0,0,$month,1,$year));

        $days_in_month = date('t',mktime(0,0,0,$month,1,$year));

        $days_in_this_week = 1;

        $day_counter = 0;

        $dates_array = array();   


         /* print "blank" days until the first of the current week */

         for($x = 0; $x < $running_day; $x++) {

                $calendar.= '<td class="calendar-day-np">&nbsp;</td>';

                $days_in_this_week++;

         }//endfor

        /* keep going with days */

        for($list_day=1;$list_day<=$days_in_month;$list_day++) {

            if($list_day == date("j",mktime(0,0,0,$month)) && $month == date("n") && $year == date("Y")) {

              $calendar .= '<td class="calendar-day-current">'; 

            } else {

              $calendar .= '<td class="calendar-day">'; 

            }

            /* add in the day number */

               $calendar .= '<div class="day-number">'.$list_day.'</div>';

           /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/

               $calendar .= str_repeat('<p>&nbsp;</p>',2);

               $calendar .= '</td>';

               if($running_day == 6) {

                      $calendar .= '</tr>';               

                  if(($day_counter+1) != $days_in_month) {$calendar .= '<tr class="calendar_row">';}

                      $running_day = -1;

                      $days_in_this_week = 0; 
        
               }//endif

              $days_in_this_week++; $running_day++; $day_counter++;

        }//endfor 


        /* finish the rest of the days in the week */

        if($days_in_this_week < 8) {

            for($x=1;$x <= (8-$days_in_this_week);$x++) {

              $calendar.= '<td class="calendar-day-np">&nbsp;</td>';

            }

        }//endif

        /* final row */

           $calendar.= '</tr>';

        /* end the table */

           $calendar.= '</table>';

       /* all done, return result */

      return $calendar;  

    } 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>Draw Calendar</title>
   <style type="text/css">
		table.calendar		{ border-left: 1px solid #999; }
		tr.calendar-row	{  }
		td.calendar-day-current,td.calendar-day	{ min-height:80px; font-size:11px; position:relative; } * html div.calendar-day { height:80px; }
		td.calendar-day:hover	{ background:#eceff5; }
		td.calendar-day-np	{ background:#eee; min-height:80px; } * html div.calendar-day-np { height:80px; }
		td.calendar-day-head { background:#ccc; font-weight:bold; text-align:center; width:120px; padding:5px; border-bottom:1px solid #999; border-top:1px solid #999; border-right:1px solid #999; }
		div.day-number		{ background:#999; padding:5px; color:#fff; font-weight:bold; float:right; margin:-5px -5px 0 0; width:20px; text-align:center; }
                td.calendar-day-current,td.calendar-day, td.calendar-day-np { width:120px; padding:5px; border-bottom:1px solid #999; border-right:1px solid #999; }
                td.calendar-day-current {background: #F8FFAD}
                .control{font:12px tahoma, arial, helvetica, sans-serif; padding:5px; border:1px solid #ccc; background:#eee; }
                a{text-decoration: none;color: #535353} 
   </style>  
</head>
<body>
<?php 

$month = (int)($_GET['month'] ? $_GET['month'] : date("n"));

$year = (int)($_GET['year'] ? $_GET['year'] : date("Y"));

echo '<center><h2><a class="control" href="cal.php?month='. ( $month != 1 ? $month - 1 : 12) .'&year='. ( $month != 1 ? $year : $year - 1 ) .'">&laquo; Prev month</a> '.date('F',mktime(0,0,0,$month,1,$year)).' ' . $year . ' <a class="control" href="cal.php?month='. ( $month != 12 ? $month + 1 : 1) .'&year='. ( $month != 12 ? $year : $year + 1 ) .'">Next month &raquo;</a> <a class="control" href="cal.php?month='. date("n").'&year='. date("Y") .'">Today</a></h2></center>';

echo draw_calendar($month,$year);

?>

</body>
</html>