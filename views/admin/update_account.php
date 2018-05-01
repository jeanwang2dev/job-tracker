<?php
/* Require The Data Insert File */
require_once( dirname(__FILE__). '/../../includes/autoload.php' );


/* Initiate the PageData Class */
$PageData = new PageData();
$Session = new Session();
$Session->checkSession();

/* Build Page */
echo $PageData->setHeading("Update Account");
echo $PageData->buildPageHead();

?>

</head>
<body>
	<?php echo $PageData->header(); ?>
    <?php echo $PageData->navBar(); ?>
    <?php echo $PageData->mainTop("Please select an account name."); ?>
    <div class="row justify-content-center">
         <div class="col-8">
              <form method="post" action="">

              	 <div class="row form-group">                       
                    <div class="col-7">
          						<select class="custom-select" id="upd_account_name">
          						    <?php echo $PageData->showAccountList(); ?>
          						</select>
        					</div>   
        				 </div>
                 
              <div id="upd_account_content">
                <div class="row form-group">                       
                                  <div class="col-7">
                                      <label for="name">Name: <i data-toggle='popover'></i></label>
                                      <input type="text" class="form-control" id="name" name="name" value="">
                                  </div>   
                      </div>

                      <div class="row form-group">                       
                                  <div class="col-7">
                                      <label for="address">Address:<i data-toggle='popover'></i></label>
                                      <input type="text" class="form-control" id="address" name="address" value="">
                                  </div>   
                      </div>

                      <div class="row form-group">
                                <div class="col-3">
                                  <label for="city">City:<i data-toggle='popover'></i></label>
                                  <input type="text" class="form-control" id="city" name="city" value="">
                                </div>
                                <div class="col-2">
                                  <label for="state">State:<i data-toggle='popover'></i></label>
                                  <input type="text" class="form-control" id="state" name="state" value="">
                                </div>
                                <div class="col-2">
                                  <label for="zip">Zip:<i data-toggle='popover'></i></label>
                                  <input type="text" class="form-control" id="zip" name="zip" value="">
                                </div>                     
                     </div>

                     <div class="row form-group">
                                <div class="col-7">
                                  <label for="account_folder">Account Folder Name:<i data-toggle='popover'></i></label>
                                  <input type="text" class="form-control" id="account_folder" name="account_folder" value="">
                                </div>
                    </div> 
                    
                   
                   <button type="button" name="updAccountBtn" id="updAccountBtn" class="btn btn-primary"> Update Account </button> 
              </div> <!-- end of div#upd_acc_content -->

              </form>
          </div>
    </div>  
     <div id="msgbox"></div>
     <?php echo $PageData->buildPageFooter(); ?>
     <?php echo $PageData->variateJs(); ?>
</body>
</html>
   
   