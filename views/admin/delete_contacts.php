<?php
/* Require The Data Insert File */
require_once( dirname(__FILE__). '/../../includes/autoload.php' );


/* Initiate the PageData Class */
$PageData = new PageData();
$Session = new Session();
$Session->checkSession();

/* Build Page */
echo $PageData->setHeading("Delete Contact");
echo $PageData->buildPageHead();

?>

</head>
<body>
	<?php echo $PageData->header(); ?>
    <?php echo $PageData->navBar(); ?>
    <?php echo $PageData->mainTop("Click on the delete button attached to the contact you want to delete."); ?>

    <div class="row justify-content-center">
         <div class="col-8">
			<?php echo $PageData->showContactTable(); ?>
     	</div>
    </div> 
	<div id="msgbox"></div>
    <?php echo $PageData->buildPageFooter(); ?>
</body>
</html>
