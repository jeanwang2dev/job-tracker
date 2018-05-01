"use strict"

/* Object For the Print Invoice Page */
var invObj = {}

invObj.init = function(){

	var job_id = localStorage.getItem('job_id');
	var beg_date = localStorage.getItem('beg_date');
	var end_date = localStorage.getItem('end_date');
	invObj.setInvoiceName(job_id);
	invObj.createInvoiceTable(job_id, beg_date, end_date);
	
}

invObj.setInvoiceName = function(job_id){
    
    var data = "getName_Inv^^^" + job_id
    var phpFile = Util.getBasePath() + "xhr/switch.php";
	Util.sendRequest(phpFile, function(res){
		
		if(res.responseText != 'error'){
			var arrRes = res.responseText.split("^^^");
			Util.getEl('#invoice_title1')[0].firstChild.nodeValue = arrRes[0];
			Util.getEl('#invoice_title2')[0].firstChild.nodeValue = arrRes[1];
			Util.getEl('#address')[0].innerHTML = arrRes[2];
			Util.getEl('#address2')[0].innerHTML = arrRes[3] + ", " + arrRes[4] + " " + arrRes[5];

		}else{
			Util.getEl('#invoice_title')[0].firstChild.nodeValue = 'Invoice Title';
		}

	},data); 

}

invObj.createInvoiceTable = function(job_id, beg_date, end_date){

	var data = "getTable_Inv^^^" + job_id + "^^^" + beg_date + "^^^" + end_date;
    var phpFile = Util.getBasePath() + "xhr/switch.php";
	Util.sendRequest(phpFile, function(res){
		//console.log("***" + res.responseText + "***");
		if(res.responseText != 'error'){
			
			Util.getEl('.row:nth-of-type(2)')[0].innerHTML = res.responseText;
		}else{
			Util.getEl('.row:nth-of-type(2)')[0].innerHTML = 'Table';
		}

	},data); 

}

invObj.init();