<?php
/* Require The Data Insert File */
require_once( dirname(__FILE__). '/../../includes/autoload.php' );


/* Initiate the PageData Class */
$PageData = new PageData();
$Session = new Session();
$Session->checkSession();

/* Build Page */
echo $PageData->setHeading("Add Job Notes");
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
                   <!--<div class="row form-group"><div class="col-7">

                   </div></div>-->
                 </div>


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

                
