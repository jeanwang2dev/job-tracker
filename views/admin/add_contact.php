<?php
/* Require The Data Insert File */
require_once( dirname(__FILE__). '/../../includes/autoload.php' );


/* Initiate the PageData Class */
$PageData = new PageData();
$Session = new Session();
$Session->checkSession();

/* Build Page */
echo $PageData->setHeading("Add Account Contact");
echo $PageData->buildPageHead();

?>

</head>
<body>
	<?php echo $PageData->header(); ?>
    <?php echo $PageData->navBar(); ?>
    <?php echo $PageData->mainTop('Enter a contact then go into "manage contacts" and assign what accounts and/or jobs they belong to. '); ?>
	 <div class="row justify-content-center">
         <div class="col-8">
              <form method="post" action="">
					<div class="row form-group">                       
                                  <div class="col-7">
                                      <label for="name">Name:<i data-toggle='popover'></i></label>
                                      <input type="text" class="form-control" id="name" name="name" value="">
                                  </div>   
                      </div>

					<div class="row form-group">                       
                                  <div class="col-7">
                                 	  <label for="work_phone">Work Phone:<i data-toggle='popover'></i></label>
                                      <input type="text" class="form-control" id="work_phone" name="work_phone" value="">
                                  </div>   
                      </div>                    


					<div class="row form-group">                       
                                  <div class="col-7">
                                   	  <label for="mobile_phone">Mobile Phone:<i data-toggle='popover'></i></label>
                                      <input type="text" class="form-control" id="mobile_phone" name="mobile_phone" value="">
                                  </div>   
                      </div>  	


					<div class="row form-group">                       
                                  <div class="col-7">
                                      <label for="email">Email:<i data-toggle='popover'></i></label>
                                      <input type="text" class="form-control" id="email" name="email" value="">
                                  </div>   
                      </div>  

                      <button type="button" name="addContactBtn" id="addContactBtn" class="btn btn-primary"> Add Contact </button> 

              </form>
          </div>
    </div>  
    <div id="msgbox"></div>
    <?php echo $PageData->buildPageFooter(); ?>
    <?php echo $PageData->variateJs(); ?>
</body>
</html>

