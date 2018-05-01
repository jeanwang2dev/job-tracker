<?php
/* Require The Data Insert File */
require_once( dirname(__FILE__). '/../../includes/autoload.php' );

/* Initiate the PageData Class */
$PageData = new PageData();
$Session = new Session();
$Session->checkSession();

/* Build Page */
echo $PageData->setHeading("Add Job Assets");
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
          						<select class="custom-select" id="job_account_name">
          						  <?php echo $PageData->showAccountList(); ?>
          						</select>
        					</div>   
        		     </div>

                  <div id="job_content">
                  
                 </div>

          
          <!--          				 

                <div class="row form-group">                       
                                  <div class="col-7">
                                      <label for="asset_name">Asset Name: </label>
                                      <input type="text" class="form-control" id="name" name="name" value="">
                                  </div>   
                  </div>

                 <div class="row form-group">                       
                                  <div class="col-7">
                                      <label for="asset_file">Asset File:</label>
                                      <input type="file" class="form-control" id="file" name="file">  
                                </div>
                  </div>  	


                  <button type="submit" name="submit" class="btn btn-success"> Add Asset To Job </button>  -->


            </form>
          </div>
    </div>  
    <div id="msgbox"></div> 
    <?php echo $PageData->mainEnd(); ?>
    <?php echo $PageData->js("Util.js"); ?>
    <?php echo $PageData->js("job.js"); ?>
    <?php echo $PageData->bootstrapJs(); ?>
    <?php echo $PageData->variateJs();?>
</body>
</html>

  