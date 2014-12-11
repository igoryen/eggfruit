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


$query = "SELECT * FROM tbl_entry ORDER BY ent_applied_date DESC";
//$query = "SELECT * FROM tbl_entry ORDER BY ent_position_name ASC";
// TRUE (if INSERT succeeded) or FALSE (if failed)
$result = $dbHelper->executeQuery($query);
$applies = mysqli_num_rows($result);


$query2 = "SELECT * FROM tbl_entry WHERE ent_response_date IS NOT NULL";
$result2 = $dbHelper->executeQuery($query2);
$fails = mysqli_num_rows($result2);


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
  $entry->setCompanyName($row['ent_company_name']);
  $entry->setCompanyUrl($row['ent_company_url']);
  $entry->setAppliedDate($row['ent_applied_date']);
  $entry->setPositionName($row['ent_position_name']);
  $entry->setJobPostingUrl($row['ent_job_posting_url']);
  $entry->setInterviewDate($row['ent_interview_date']);
  $entry->setResponseDate($row['ent_response_date']);
  $entry->setResponseValue($row['ent_response_value']);
  // push the Entry object into the array
  array_push($entries, $entry);
}
// get AEN
echo count($entries) . " entries<br>";

function applications($entries) {
  print "<div class='applic_table'>";
  //$bag = "";
  // for each [AE of array] $entries [named] as [variable] $entry
  foreach ($entries as $entry) {
    
    $closing_span_tag = '';
    $bag = "";
    
    
    // if HAVE response date
    if (null !== $entry->getResponseDate()) {
      // do not cross out the row
      $class = "<div class='crossed_row'>";
      //$bag .= "response date is set!";
      // then start the row with a span to cross out the row
      //$bag .= "<span class='crossout'>";
      //$closing_span_tag = '</span> ';
    }
    else {
      $class = "<div class='row'>";
    }
    
    $bag .= $class;
    
    // date
    $bag .= '<div class="applic_table_date_cell">';
    $bag .= $entry->getAppliedDate() . " ";
    $bag .= '</div>';
    
    // company
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
    
    // position
    $bag .= '<div class="applic_table_cell">';
    if(!null == $entry->getJobPostingUrl()){
      $bag .= "<a href='" . $entry->getJobPostingUrl() . "' target='_blank'>";
      $bag .= $entry->getPositionName() . "</a> ";
    }
    else{
      $bag .= $entry->getPositionName() . " ";
    }
    $bag .= '</div>';
    
    // interview date
    $bag .= '<div class="applic_table_ivdate_cell">';
    if ($entry->getInterviewDate() !== "0000-00-00") {
      $bag .= "<b>" . $entry->getInterviewDate() . "</b>";
    }
    $bag .= '</div>';
    
    // response date
    $bag .= '<div class="applic_table_response_cell">';
    $bag .= "<i>" . $entry->getResponseDate() . "</i>";
    $bag .= '</div>';
    
    // response value
    $bag .= '<div class="applic_table_cell">';
    $bag .= "<i>" . $entry->getResponseValue() . "</i>";
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
        Applied to <?php print $applies; ?></br>
        Rejected by <?php print $fails; ?>
      </div>
      <div id="display_pane">
        <?php
        applications($entries);
        ?>
      </div>
    </div>
  </body>
</html>