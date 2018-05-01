<?php
/* Require The Data Insert File */
require_once( dirname(__FILE__). '/../../includes/autoload.php' );


/* Initiate the PageData Class */
$PageData = new PageData();
$Session = new Session();
$Session->checkSession();

/* Build Page */
echo $PageData->setHeading("Manage Contacts");
echo $PageData->buildPageHead();

?>

</head>
<body>
	<?php echo $PageData->header(); ?>
    <?php echo $PageData->navBar(); ?>
    <?php echo $PageData->mainTop("Please select an contact name. Once you have selected a name you can add or remove jobs for that contact. "); ?>

     <div class="row justify-content-center">
         <div class="col-8">
              <form method="post" action="">

              	 <div class="row form-group">                       
                    <div class="col-7">
						<select class="custom-select" id="mc_contact_name">
							<?php echo $PageData->showContactList(); ?>
						</select>
					</div>   
				 </div>

				<div id="mc_contact_content">

					<div class="row form-group">                       
	                    <div class="col-10">
								<h1></h1>
								<table></table>
	                    </div>
	                </div>

	                <div class="row form-group">                       
	                    <div class="col-7">
	                        <p></p>
	                        <p>If you want to add an association to a job. Please select an account then select a job.</p>
							<select class="custom-select" id="mc_account_name">
							  <?php echo $PageData->showAccountList(); ?>
							</select>
							<h6></h6>
	                    </div>
	                </div>

	                    

	                <div id="mc_associ_content">

			                <div class="row form-group"> 
			                    <div class="col-7">			                   
									<select class="custom-select" id="mc_job_name">
									 
									</select>
								</div>   
							 </div>

							 <button type="button" name="addAssociBtn" id="addAssociBtn" class="btn btn-success"> Add Association </button>
					</div> 

			    </div> 

				
 			</form>

          </div>
    </div>  
    <div id="msgbox"></div>
    <?php echo $PageData->buildPageFooter(); ?>
</body>
</html>




