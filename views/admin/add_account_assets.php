<?php
/* Require File */
require_once( dirname(__FILE__). '/../../includes/autoload.php' );

/* Initiate the PageData Class */
$PageData = new PageData();
$Session = new Session();
$Session->checkSession();

/* Build Page */
echo $PageData->setHeading("Add Account Assets");
echo $PageData->buildPageHead();

?>

</head>
<body>
	<?php echo $PageData->header(); ?>
    <?php echo $PageData->navBar(); ?>
    <?php echo $PageData->mainTop("Please select an account name"); ?>
    <div class="row justify-content-center">
         <div class="col-8">
              <form method="post" action="">

              	 <div class="row form-group">                       
                    <div class="col-7">
                      <select class="custom-select" id="aaa_account_name">
          						 <?php echo $PageData->showAccountList(); ?>
                      </select>
					       </div>   
				      </div>
             
              <div id="aaa_account_content"> 
                  <div class="row form-group">                       
                        <div class="col-7">
                                  <label for="asset_name">Asset Name: <i data-toggle='popover'></i></label>
                                  <input type="text" class="form-control" id="asset_name" name="asset_name" value="">
                         </div>   
                  </div>

                  <div class="row form-group">    
                        <div class="col-7">
                                  <label for="asset_file">Asset File: <i data-toggle='popover'></i></label>
                                   <input type="file" class="form-control" id="file" name="asset_file">                                                            
                          </div>                                                      
                  </div>
                     
                  <button type="button" name="addAccAssetBtn" id="addAccAssetBtn" class="btn btn-success"> Add Asset To Account </button>  
              </div>

              </form>
          </div>
    </div>  
     <div id="msgbox"></div>
     <?php echo $PageData->buildPageFooter(); ?>
     <?php echo $PageData->variateJs(); ?>
</body>
</html>
