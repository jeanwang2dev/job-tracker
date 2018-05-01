<?php
/* Require File */
require_once( dirname(__FILE__). '/../../includes/autoload.php' );


/* Initiate the PageData Class */
$PageData = new PageData();
$Session = new Session();
$Session->checkSession();

/* Build Page */
echo $PageData->setHeading("Admin Home Page");
echo $PageData->buildPageHead();

?>

</head>
<body>
	<?php echo $PageData->header(""); ?>
    <?php echo $PageData->navBar(); ?>
      <main>
         <div class="row justify-content-center">
              <div class="col-md-8 col-sm-10 col-xs-12">
                <h1>Welcome to the home page</h1>
              </div>
         </div> 
    <?php echo $PageData->mainEnd(); ?>
    <?php echo $PageData->bootstrapJs(); ?>
</body>
</html>

