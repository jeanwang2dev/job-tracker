<?php
/* Login Page */

/* Require Files */
require_once( dirname(__FILE__). '/../includes/autoload.php' );

/* Initiate Classes */
$PageData = new PageData();
$Session = new Session();

$Session->checkLogin();

/* Build Page */
echo $PageData->setHeading("Login");
echo $PageData->setTitle("Login Page");
echo $PageData->buildPageHead();

?>

</head>
<body>
	<?php echo $PageData->header(); ?>
    <?php echo $PageData->mainTop('Enter your Login Information and Click "Login" '); ?>

    <div class="row justify-content-center">        
         <div class="col-md-8 col-sm-10 col-xs-12">   
            <p class="error"><?php echo $Session->error; ?></p>       
              <form method="post" action="">

                      <div class="row form-group">                       
                                  <div class="col-md-6 col-xs-10">
                                      <label for="name">Email:</label>
                                      <input type="text" class="form-control" id="email" name="email" value="">
                                  </div>   
                      </div>

                      <div class="row form-group">                       
                                  <div class="col-md-6 col-xs-10">
                                      <label for="password">Password:</label>
                                      <input type="password" class="form-control" id="password" name="password" value="">
                                  </div>   
                      </div>
                   
                   <button type="submit" name="submit" class="btn btn-primary"> Login </button>   
                   
                    
              </form>
          </div>
    </div>  

    <?php echo $PageData->mainEnd(); ?>
    <?php echo $PageData->bootstrapJs(); ?>
</body>
</html>

