<?php
/* Sign Up Page */

/* Require Files */
require_once( dirname(__FILE__). '/../../includes/autoload.php' );

/* Initiate Classes */
$PageData = new PageData();
$Session = new Session();
$Session->checkSession();

/* Build Page */    
echo $PageData->setHeading("Sign Up");
echo $PageData->setTitle("Sign Up For Admin Page");
echo $PageData->buildPageHead();

?>

</head>
<body>
	<?php echo $PageData->header(); ?>
    <?php echo $PageData->mainTop('Enter your Sign Up Information and Click "Add Admin" '); ?>

    <div class="row justify-content-center">        
         <div class="col-md-8 col-sm-10 col-xs-12">   
            <p class="error"><?php echo $Session->error; ?></p>       
              <form method="post" action="">

                      <div class="row form-group">                       
                                  <div class="col-md-6 col-xs-10">
                                      <label for="email">User Email:</label>
                                      <input type="text" class="form-control" id="email" name="email" value="">
                                  </div>   
                      </div>

                      <div class="row form-group">                       
                                  <div class="col-md-6 col-xs-10">
                                      <label for="password">Password:</label>
                                      <input type="password" class="form-control" id="password" name="password" value="">
                                  </div>   
                      </div>
                   
                   <button type="button" name="addAdminBtn" class="btn btn-primary" id="addAdminBtn"> Add Admin </button>   
                   
                    
              </form>
          </div>
    </div>  
    <div id="msgbox"></div>
    <?php echo $PageData->buildPageFooter(); ?>
    <?php echo $PageData->variateJs(); ?>
</body>
</html>

