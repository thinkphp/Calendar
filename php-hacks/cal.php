<html>
<head>
<title>Create an Interactive Calendar</title>
<style type="text/css">
.calendar {
  font-family: arial, verdana, sans serif; 
}

.calendar td {
  border: 1px solid #eee;
}
.calendar-title {
  text-align: center;
  font-style: italic;
}
.calendar-day-title {
  text-align: center;
  font-size: small;
  background: #ccc;
  font-weight: bold;
}
.calendar-day, .calendar-outmonth-day {
  height: 60px;
  vertical-align: top;
  text-align: center;
  font-size: small;
  padding: 0px;
}

.calendar-day-number {
  text-align: right;
  background: #ddd;
}
.calendar-content { 
  padding: 2px;
  font-size: x-small;
}
.calendar-outmonth-day {
  color: #666;
  font-style: italic;
  background: #ddd;
}

a{text-decoration: none;color: #333;}


.calendar-current-day {
  height: 60px;
  vertical-align: top;
  text-align: center;
  font-size: small;
  padding: 0px;
  background: #FFFB9A;
}

.calendar-current-day .calendar-day-number {
  text-align: right;
  background: #B2B2B2;
}


</style>
</head>
<body>
<?php

class Day
{

  /* data private members */
  private $month;

  private $day;

  private $year;

  private $inmonth;

  private $number;

  private $text;

  /* constructor of class Day */
  public function __construct( $inmonth, $month, $day, $year ) {

	$this->{'month'} = $month;

	$this->{'day'} = $day;

	$this->{'year'} = $year;

	$this->{'inmonth'} = $inmonth;

	$this->{'number'} = $number;

	$this->{'text'} = "";
  }

  /* public methods members */
  public function get_day() { return $this->{'day'}; }

  public function get_month() { return $this->{'month'}; }

  public function get_year() { return $this->{'year'}; }

  public function get_inmonth() { return $this->{'inmonth'}; }

  public function get_number() { return $this->{'number'}; }

  public function get_text() { return $this->{'text'}; }

  public function set_text( $text ) { $this->{'text'} = $text; }

}//end class

function setCalendarText( $days, $m, $d, $y, $text )
{

  foreach( $days as $day )  {

	if ( $day->get_day() == $d && $day->get_month() == $m && $day->get_year() == $y ) $day->set_text( $text ); 

  }//endforeach

}//end function

function get_last_month( $month, $year ) {

  ($month != 1) ? $lastmonth = $month - 1 : $lastmonth = 12;

  ($month != 1) ? $lastyear = $year : $lastyear = $year - 1;

  return array( $lastmonth, $lastyear );

}//end function

function get_next_month( $month, $year ) {

     ($month != 12) ? $nextmonth = $month + 1 : $nextmonth = 1;

     ($month != 12) ? $nextyear = $year : $nextyear = $year + 1;

  return array( $nextmonth, $nextyear );

}//end function

  function makeCalendarDays( $month, $year ) {

       list( $nextmonth, $nextyear ) = get_next_month( $month, $year );

       list( $lastmonth, $lastyear ) = get_last_month( $month, $year );

       $dimlm = date('t',mktime(0,0,0,$lastmonth,1,$lastyear));

       $jd = cal_to_jd( CAL_GREGORIAN, $month, 1, $year );

       $day = jddayofweek( $jd );

       $dim = date('t',mktime(0,0,0,$month,1,$year));
  
       $days = array( );

        for( $d = 0; $d < $day; $d++ ) {

            $days []= new Day( 0, $lastmonth , $dimlm - ( $day - $d - 1), $lastyear );
        }

        for( $d = 1; $d <= $dim; $d++ ) {

             $days []= new Day( 1, $month + 0, $d, $year );
        }

	$left = ( ( floor( ( $day + $dim ) / 7 ) + 1 ) * 7 ) - ( $day + $dim );

	for( $d = 0; $d < $left; $d++ ) {

	  $days []= new Day( 0, $nextmonth , $d+1, $nextyear );

        }

  return $days;

}//end function

//get current date
$today = getdate();

$mday = $today['mday'];

$y = $year = $today['year'];

$m = $month = $today['mon'];

if ( $_GET['year'] ) $year = $_GET['year'];

if ( $_GET['month'] ) $month = $_GET['month'];

//get days
$days = makeCalendarDays( $month, $year );

//define months
$months = array("January", "February", "March", "April","May", "June", "July", "August","September", "October", "November", "December" );

//define days
$day_names = array( "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" );

?>

<div style="width:600px;"><!-- start div -->

<table class="calendar" width="100%" cellspacing="0" cellpadding="1"><!-- start table -->

<tr><td colspan="7" class="calendar-title" width="13%">

<?php

list( $nextmonth, $nextyear ) = get_next_month( $month, $year );

list( $lastmonth, $lastyear ) = get_last_month( $month, $year );

?>

 <a href="cal.php?year=<?php echo($lastyear); ?>&month=<?php echo( $lastmonth );?>">&laquo; Prev</a> 
 <?php echo '<strong>'.( $months[$month-1] ).' '.( $year ).'</strong>'; ?>
 <a href="cal.php?year=<?php echo($nextyear); ?>&month=<?php echo( $nextmonth );?>">Next &raquo;</a>
 <a href="cal.php?year=<?php echo($today['year']); ?>&month=<?php echo( $today['mon']);?>">Today</a>
</td></tr>

<tr>
<?php foreach( $day_names as $day ) { ?>
<td class="calendar-day-title"><?php echo( $day ); ?></td>
<?php } ?>
</tr>

<?php

setCalendarText(&$days,8,5,2009,"meet Alex");

setCalendarText(&$days,8,10,2009,"meet Ady");

setCalendarText(&$days,9,7,2009,"meet John");

setCalendarText(&$days,9,14,2009,"meet Chris");

setCalendarText(&$days,10,7,2009,"meet Emil");

setCalendarText(&$days,10,20,2009,"meet David");

$p = 0;

foreach( $days as $d ) {

if ( $p == 0 ) echo ( "<tr>" );

if($d->get_day() == $mday && $d->get_month() == $m && $d->get_year() == $y) { 

  $day_style = "calendar-current-day";
  
} else {

  $day_style = $d->get_inmonth() ? "calendar-day" : "calendar-outmonth-day";

}

?>

<td class="<?php echo( $day_style ); ?>" width="13%">

<div class="calendar-day-number"> <?php echo( $d->get_day() ); ?> </div>

<div class="calendar-content"> <?php echo( $d->get_text() ); ?> </div> 

</td>

<?php

$p += 1;

if ( $p == 7 ) { $p = 0; }

}//end foreach

?>

</tr>

</table> <!-- end table -->

</div><!-- end div -->

<body>

</html>

