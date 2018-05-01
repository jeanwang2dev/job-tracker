<?php	

require_once 'DBHandler.php';

class PageData{

  public $basePath = "http://104.236.202.204/job-tracker/";
  public $uploadFolder = "/../resources/uploads/";
  private $docType = '<!DOCTYPE html><html lang="en"><head>';
  //private $metaData = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ><meta name="Author" content="Jean Wang" >';
  private $metaData = '<meta http-equiv="Pragma" content="text/html; charset=UTF-8" CONTENT="NO-CACHE"><meta name="Author" content="Jean Wang" >';
  private $col = "col-md-8 col-sm-10 col-xs-12";
  private $title = "<title>WEB250 Project -- JOB TRACKER</title>";
  private $heading = "";
  private $css = "";
  //private $js = "";


 public function buildPageHead(){

    $this->setBootStrap();

    $top = <<<STR
    {$this->docType}
    {$this->metaData}
    {$this->title}
    {$this->css}

STR;
    return $top;
  }

  public function buildPageFooter(){

    $footer = <<<STR
          </main>
      <div><!-- /.container-fluid -->
      <script src="{$this->basePath}public/js/Util.js"></script>
      <script src="{$this->basePath}public/js/admin.js"></script>
      <!-- Bootstrap JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
      <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script

STR;
    return $footer;
  }

  public function setTitle($txt){
    $this->title =  "<title>WEB250 Project JOB TRACKER - {$txt}</title>";
  }

  public function setHeading($txt){
    $this->heading = $txt;
  }


  /**
    Use Bootstrap4 and fontawesome
  **/
  public function setBootstrap(){

    $bootstrap = <<<STR
    <!-- boostrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

STR;

    $fontawesome = <<<STR
    <!-- FontAwesome --> 
    <link rel="stylesheet" href="{$this->basePath}public/css/font-awesome-4.7.0/css/font-awesome.min.css">

STR;

    $mycss = <<<STR
    <!-- Style sheet -->
    <link href="{$this->basePath}public/css/main.css" rel="stylesheet" type="text/css">

STR;
    return $this->css = $bootstrap.$fontawesome.$mycss;
  }


  public function header(){
    $header = <<<STR
<div class="container-fluid">
      <header>
        <div class="row justify-content-center">
          <div class="{$this->col}">
            <h1>Job Tracker - {$this->heading}</h1>
          </div>
        </div>
    </header>

STR;
    return $header;
  }

  public function navBar(){
      $nav = <<<STR
      <!-- Navbar -->
      <nav>
          <div class="row justify-content-center" >
                <div class="col-8">                                      
                    <ul class="nav">
                              <li classs="nav-item">
                                <a class="nav-link" href="{$this->basePath}views/admin/home.php">Home</a>
                              </li>
                              <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Accounts</a>
                                <div class="dropdown-menu" aria-labelledby="Preview">
                                  <a class="dropdown-item" href="{$this->basePath}views/admin/add_account.php">Add Account</a>
                                  <a class="dropdown-item" href="{$this->basePath}views/admin/update_account.php">Update Account</a>
                                  <a class="dropdown-item" href="{$this->basePath}views/admin/add_account_assets.php">Add Assets to Account</a>
                                  <a class="dropdown-item" href="{$this->basePath}views/admin/view_delete_account_assets.php">View/Delete Account Assets</a>
                                </div>
                              </li>
                              <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Contacts</a>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="{$this->basePath}views/admin/add_contact.php">Add Contact</a>
                                  <a class="dropdown-item" href="{$this->basePath}views/admin/update_contact.php">Update Contact</a>
                                  <a class="dropdown-item" href="{$this->basePath}views/admin/manage_contacts.php">Manage Contacts</a>
                                  <a class="dropdown-item" href="{$this->basePath}views/admin/delete_contacts.php">Delete Contacts</a> 
                                </div>
                              </li>
                              <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Jobs</b></a>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="{$this->basePath}views/admin/add_job.php">Add Job</a>
                                  <a class="dropdown-item" href="{$this->basePath}views/admin/view_job_contacts.php">View Job Contacts</a>
                                  <a class="dropdown-item" href="{$this->basePath}views/admin/add_job_notes.php">Add Job Notes</a>
                                  <a class="dropdown-item" href="{$this->basePath}views/admin/view_delete_job_notes.php">View/Update/Delete Job Notes</a> 
                                  <a class="dropdown-item" href="{$this->basePath}views/admin/add_job_assets.php">Add Asset to Job</a>
                                  <a class="dropdown-item" href="{$this->basePath}views/admin/view_delete_job_assets.php">View/Delete Job Assets</a>
                                  <a class="dropdown-item" href="{$this->basePath}views/admin/add_job_hours.php">Add Job Hours</a>
                                  <a class="dropdown-item" href="{$this->basePath}views/admin/update_delete_hours.php">Add/Delete Job Hours</a>
                                  <a class="dropdown-item" href="{$this->basePath}views/admin/print_invoice.php">Print Invoice</a>
                                </div>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" href="{$this->basePath}views/admin/logout.php">Logout</a>
                              </li>
                    </ul>                           
                </div>
          </div>
        </nav>

STR;
      return $nav;
    }

    public function mainTop($line1,$line2=""){
      $secondLine = "";
      if(!empty($line2)) $secondLine = '<p>'.$line2.'</p>';
      $mainTop = <<<STR
      <main>
         <div class="row justify-content-center">
              <div class="{$this->col}">
                <h1>{$this->heading}</h1>
                <p>$line1</p>
                $secondLine
              </div>
         </div> 

STR;

       return $mainTop;
    }


    public function mainEnd(){
      $footer = <<<STR
    </main>
  <div><!-- /.container-fluid -->

STR;
    return $footer;
    }


    public function bootstrapJs(){
      $bsjs = <<<STR
      <!-- Bootstrap JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
      <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

STR;
        return $bsjs;
    }

    public function js($txt){
      $js = <<<STR
    <script src="{$this->basePath}public/js/{$txt}"></script>
    
STR;
      return $js;
    }

    public function variateJs(){
      $js = <<<STR
    <!-- Optional JavaScript -->
    <script> 
        $(function () {
          $('[data-toggle="popover"]').popover({
            trigger: 'hover',
            title: "Field Error"
          })

        })
    </script> 
     
STR;
    return $js;
    }

  public function showContactTable(){

       $pdo = new DBHandler();
       $sql = "SELECT id, name FROM contact ORDER BY name";
       $records = $pdo->selectNotBinded($sql);

       if($records == 'error'){
              return '<option>There was a problem getting the account list</option>';
       }
       else {
          if(count($records)==0) return '';
          else return $this->createContactTable($records);
       }

  }

  private function createContactTable($records){

  $table = <<<STR
  <table class="table table-striped table-bordered" id="contactTable">
    <thead>
      <tr>
        <th>Contact Name</th>
        <th>Delete</th>
      </tr>
    </thead>
      <tbody>
STR;

    foreach ($records as $row){
      $table .= '<tr>';
      $table .= "<td>{$row['name']}</td>";
      $table .= "<td><input type='button' class='btn btn-danger' id='{$row['id']}' value='Delete'></td>";
      $table .= '</tr>';
    }
    $table .= '</tbody></table>';
    return $table;

  }


  public function showAccountList(){

       $pdo = new DBHandler();
       $sql = "SELECT id, name FROM account ORDER BY name";
       $records = $pdo->selectNotBinded($sql);

       if($records == 'error'){
              return '<p>There was a problem getting the contact table</p>';
       }
       else {
          if(count($records)==0) return '<p>There is no contact yet</p>';
          else return $this->createSelectList($records,'account');
       }

  }

  public function showContactList(){
       $pdo = new DBHandler();
       $sql = "SELECT id, name FROM contact ORDER BY name";
       $records = $pdo->selectNotBinded($sql);

       if($records == 'error'){
              return '<option>There was a problem getting the contact list</option>';
       }
       else {
          return $this->createSelectList($records, 'contact');
       }

  }

  public function createSelectList($records,$flag){
      
      $list = "<option selected>Select an {$flag}</option>";
      foreach ($records as $row){
        $list .= "<option value={$row['id']}> {$row['name']}</option>";
      }
      return $list;
   }

   public function showInvoiceTable(){

      $table = <<<STR
 <table class="table table-striped table-bordered">
        <thead>
          <th>Date</th>
          <th>Description</th>
          <th>Hours</th>
          <th>Hourly Rate</th>
          <th>Total</th>
        </thead>
        <tbody>
          <tr>
            <td>08-15-2017</td>
            <td>did something</td>
            <td>6.00</td>
            <td>75</td>
            <td>$450.00</td>
          </tr>
          <tr>
            <td colspan="4">Grand Total</td>
            <td>$450.00</td>
          </tr>
        </tbody>
      </table>
STR;
      return $table;
   }

}
?>