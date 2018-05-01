<?php
/* Require The Data Insert File */
require_once( dirname(__FILE__). '/../../includes/autoload.php' );


/* Initiate the PageData Class */
$PageData = new PageData();
$Session = new Session();
$Session->checkSession();

/* Build Page */
//echo $PageData->setHeading("Invoice");
echo $PageData->buildPageHead();

?>

</head>
<body>

	<div class="container" id="invoice">
		<div class="row">
			<div class="col-md-1"><i class="fa fa-globe" aria-hidden="true"></i></div>
			<div class="col-md-6">
				<h3>My Company Name</h3>
				<p>123 Main St. Ann Arbor, MI</p>
				<p>Phone: 123-234-7890 Email: jean@mycompany.com</p>
			</div>
			<div class="col-md-5">
				<h4 id="invoice_title1">Invoice Title</h4>
				<h4 id="invoice_title2">Invoice Title</h4>
				<p id="address">3212 St. </p>
				<p id="address2">Ann Arbor, MI 12345</p>
			</div>
		</div>
	
		<div class="row">
			 
		</div>
	</div>

    <?php echo $PageData->js("Util.js"); ?>
    <?php echo $PageData->js("invoice.js"); ?>
    <?php echo $PageData->bootstrapJs(); ?>

</body>
</html>