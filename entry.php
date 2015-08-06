<?php
class Entry{
  private $id; // 10
  private $company_name; // 15
  private $company_url; // 20
  private $applied_date; // 23
  private $position_name; // 50
  private $job_posting_url;
  private $interview_date;
  private $response_date;
  private $response_value; // 65
  private $accepted;
  /* ----------------------------------
    functions for class Entry
    --------------------------------- */

  /* getter & setter $id */

  public function getEntryId() {
    return $this->id;
  }

  public function setEntryId($x) {
    $this->id = $x;
  }
  //-----------------------
  public function getCompanyName(){
    return $this->company_name;
  }
  public function setCompanyName($x){
    $this->company_name = $x;
  }
  //-----------------------
  public function getCompanyUrl(){
    return $this->company_url;
  }
  public function setCompanyUrl($x){
    $this->company_url = $x;
  }
  //-----------------------
  public function getAppliedDate(){
    return $this->applied_date;
  }
  public function setAppliedDate($x){
    $this->applied_date = $x;
  }
  //-----------------------
  public function getPositionName(){
    return $this->position_name;
  }
  public function setPositionName($x){
    $this->position_name = $x;
  }
  //-----------------------
  public function getJobPostingUrl(){
    return $this->job_posting_url;
  }
  public function setJobPostingUrl($x){
    $this->job_posting_url = $x;
  }

  //-----------------------
  public function getInterviewDate() {
    return $this->interview_date;
  }

  public function setInterviewDate($x) {
    $this->interview_date = $x;
  }

  //-----------------------
  public function getResponseDate(){
    return $this->response_date;
  }
  public function setResponseDate($x){
    $this->response_date = $x;
  }
  //-----------------------
  public function getResponseValue(){
    return $this->response_value;
  }
  public function setResponseValue($x){
    $this->response_value = $x;
  }
  //-----------------------
  public function getAccepted(){
    return $this->accepted;
  }
  public function setAccepted($x){
    $this->accepted = $x;
  }

  public function isAccepted($id){
    $dbHelper = new DBHelper();
    date_default_timezone_set('America/Toronto');
    $sql = "SELECT accepted FROM eggfruit.entry WHERE id = " . $id . ";";
    $result = $dbHelper->executeQuery($sql);
    while ($row = mysqli_fetch_assoc($result)) {
      $status = $row["accepted"];
    }
    // var_dump($status);
    return $status;
  }
  
} // class ENtry
