<?php
include("DBHelper.php");
include("entry.php");



// the script to see what databases I have
// $res = mysql_query("SHOW DATABASES");
// while ($row = mysql_fetch_row($res)){
//   echo $row[0], '<br/>';
// } 
//==================
$dbHelper = new DBHelper();
//===========================
//$query = "SELECT COUNT(ent_entry_id) FROM entry ORDER BY name DESC";
//
//// TRUE (if INSERT succeeded) or FALSE (if failed)
//$result = $dbHelper->executeQuery($query);
//$num_rows = mysql_num_rows($result);
//echo "$num_rows Rows\n";
//=============================
date_default_timezone_set('America/Toronto');

$query = "SELECT * FROM entry ORDER BY company_name ASC";
//$query = "SELECT * FROM tbl_entry ORDER BY ent_position_name ASC";
// TRUE (if INSERT succeeded) or FALSE (if failed)
$result = $dbHelper->executeQuery($query);
$applies = mysqli_num_rows($result);

/*--------------------------------------------------------
| SUCCESS RATE
| Calculate success rate based on no-reply from a company 
| in more than 60 days or rejected.
| In other words, if there was no reply from a company in 
| 60 days or the reply was a NO classify that application as a fail.
*/
$query2 = "SELECT * FROM `entry` "
        //. "WHERE DATEDIFF(NOW(), `applied_date`) > 60 "
        . "WHERE (accepted = '0') OR (DATEDIFF(NOW(), `applied_date`) > 60 ) "
        . "ORDER BY applied_date DESC";
//echo $query2;
$result2 = $dbHelper->executeQuery($query2);
$fails = mysqli_num_rows($result2);

$percent_success = round(100 - (($fails/$applies)*100), 1);
//$num_rows2 = mysqli_num_rows($result2);
//$fails = $num_rows2[0];
//$fails = $row[0];
//$last_inserted_id = mysql_insert_id();


//create an array of Entry objects
$entries[] = new Entry();
// while there is a remaining row
while ($row = mysqli_fetch_assoc($result)) {
  // create an Entry object
  $entry = new Entry();
  // populate it 
  $entry->setEntryId($row['id']);
  $entry->setCompanyName($row['company_name']);
  $entry->setCompanyUrl($row['company_url']);
  $entry->setAppliedDate($row['applied_date']);
  $entry->setPositionName($row['position_name']);
  $entry->setJobPostingUrl($row['job_posting_url']);
  $entry->setInterviewDate($row['interview_date']);
  $entry->setResponseDate($row['response_date']);
  $entry->setResponseValue($row['response_value']);
  $entry->setAccepted($row['accepted']);
  // push the Entry object into the array
  array_push($entries, $entry);
}
// get AEN
echo count($entries) . " entries<br>";


// $status = Entry::isAccepted(3);
// echo $status;




function applications($entries) {
  print "<div class='applic_table'>";
  //$bag = "";
  // for each [AE of array] $entries [named] as [variable] $entry
  foreach ($entries as $entry) {
    
    $closing_span_tag = '';
    $bag = "";

    $date_today = date_create(date("Y-m-d"));
    // 2    
    $date_apply = date_create($entry->getAppliedDate());
    // 3
    
    $time_since = date_diff($date_today, $date_apply);
    // 4
    /*-----------------------------------------------------------
    | CONDITIONS
    | Condition 1: status is null (neither accepted nor rejected)
    | Condition 2: status is 1 (accepted)
    | Condition 3: status is 0 (rejected) or 60 days have passed
    */
    // condition 3
    if ($entry->getAccepted() == '0' || $time_since->days > 60) { // 1
      // do not cross out the row
      $class = "<div class='crossed_row'>";
      //$bag .= "response date is set!";
      // then start the row with a span to cross out the row
      //$bag .= "<span class='crossout'>";
      //$closing_span_tag = '</span> ';
    }
    // condition 1
    elseif ($entry->getAccepted() == null) {
      $class = "<div class='row'>";
    }

    
    $bag .= $class;
    
    // date
    $bag .= '<div class="applic_table_date_cell">';
    $bag .= $entry->getAppliedDate() . " ";
    $bag .= '</div>';
    
    /*-----------------------------------------------------------
    | COMPANY
    | If the DB has company URL then use it, otherwise just print
    | the name of the company
    */
    $bag .= '<div class="applic_table_cell">';
    if(!null == $entry->getCompanyUrl()){
      $bag .= "<a href='" . $entry->getCompanyUrl() . "' target='_blank'>";
      $bag .= "<b>" . $entry->getCompanyName() . "</b>";
      $bag .= "</a>";
    }
    else{
      $bag .= "<b>" . $entry->getCompanyName() . "</b>";
    }
    $bag .= '</div>';
    
    /*-----------------------------------------------------------
    | POSITION
    | If the DB has posting URL for the position then use it, 
    | otherwise just print the name of the position
    */
    $bag .= '<div class="applic_table_cell">';
    if(!null == $entry->getJobPostingUrl()){
      $bag .= "<a href='" . $entry->getJobPostingUrl() . "' target='_blank'>";
      $bag .= $entry->getPositionName() . "</a> ";
    }
    else{
      $bag .= $entry->getPositionName() . " ";
    }
    $bag .= '</div>';
    
    /*-----------------------------------------------------------
    | INTERVIEW
    | If the DB has interview date for the position then use it, 
    | otherwise don't print anything
    */
    $bag .= '<div class="applic_table_cell">';
    if ($entry->getInterviewDate() != null) {
      $bag .= '<span title="'.$entry->getInterviewDate(). '">- Int - </span>';
    }
    $bag .= '</div>';
    
    /*-----------------------------------------------------------
    | RESPONSE DATE
    | If the DB has response date for the application then use it, 
    | otherwise don't print anything
    */
    $bag .= '<div class="applic_table_cell">';
    if(!null == $entry->getResponseDate()){
      $bag .= '<span title="' . $entry->getResponseDate() .'"> - R - </span>';
    }    
    $bag .= '</div>';
    
    /*-----------------------------------------------------------
    | RESPONSE VALUE
    | If the DB has response value for the application then use it, 
    | otherwise don't print anything
    */
    $bag .= '<div class="applic_table_cell">';
    if(!null == $entry->getResponseValue()){
      $bag .= '<span title="' . $entry->getResponseValue() .'"> - A - </span>';
    }
    $bag .= '</div><!-- end of what? -->';

    $bag .= $closing_span_tag;
    $bag .= "</div><!-- end of row-->";
    
    print $bag;
    
  } // foreach()
  
  print "</table>";
}

// terms()
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Eggfruit</title>
    <link rel="stylesheet" type="text/css" href="eggfruit.css">
    <link rel="shortcut icon" href="Egg-fruit.jpg"/>
  </head>
  <body>
    <div class="desktop">
      <h2><img src="Egg-fruit.jpg" height="60"> Eggfruit</h2>

      <div id="stat">
        Applied to <?php print $applies; ?>. 
        Rejected by <?php print $fails; ?> (Success rate: <?php 
          print $percent_success; ?>%)
      </div>
      <div id="display_pane">
        <?php
        applications($entries);
        ?>
      </div>
    </div>
  </body>
</html>