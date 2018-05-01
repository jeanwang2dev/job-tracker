"use strict"

var adminObj = {}

adminObj.init = function(){
     
    /* for the Add Account Button on Add Account Page, validate first then add account*/  
	if( Util.getEl('#addAccountBtn').length != 0){		
		Util.addLis(Util.getEl('#addAccountBtn')[0], 'click', adminObj.validateAcc);
	} 
	
    /* for the Add Contact Button on Add Contact Page, validate first then add contact*/
	if( Util.getEl('#addContactBtn').length != 0){		
		Util.addLis(Util.getEl('#addContactBtn')[0], 'click', adminObj.validateCon);
	} 

	/* for the account info field to show up on Update Account Page */
	if( Util.getEl('#upd_account_name').length != 0){
		Util.addLis(Util.getEl('#upd_account_name')[0], 'change', adminObj.showInfo4updAcc); 
	}

    /* for the contact info fields to show up on Update Contact Page */
	if( Util.getEl('#upd_contact_name').length != 0){
		Util.addLis(Util.getEl('#upd_contact_name')[0], 'change', adminObj.showInfo4updCon); 
	}

	/* for the Select an account field to show account names on Add Account Asset Page */
	if( Util.getEl('#aaa_account_name').length != 0){
		Util.addLis(Util.getEl('#aaa_account_name')[0], 'change', adminObj.showInfo4Account);//addAccAsset); 
	}


	/* for the Select an account field to show account names on View Delete Account Asset Page */
	if( Util.getEl('#vdaa_account_name').length != 0){
		Util.addLis(Util.getEl('#vdaa_account_name')[0], 'change', adminObj.showInfo4vdAccAsset); 
	}

	/* for the Select an contact field to show contact names on Manage Contacts Page */
	if( Util.getEl('#mc_contact_name').length != 0){
		Util.addLis(Util.getEl('#mc_contact_name')[0], 'change', adminObj.showInfo4ManageContact); 
	}

	/* for the Select an account field to show account names on Manage Contacts Page */
	if( Util.getEl('#mc_account_name').length != 0){
		Util.addLis(Util.getEl('#mc_account_name')[0], 'change', adminObj.showInfo4ManageContact2); 
	}


    /* for the Update Account Button on Update Account Page, validate first then update account */
	if( Util.getEl('#updAccountBtn').length != 0){
		Util.addLis(Util.getEl('#updAccountBtn')[0], 'click', adminObj.validateAcc);

	}

	/* for the Update Contact Button o Update Contact Page, validate first then update contact */
	if( Util.getEl('#updContactBtn').length != 0){
		Util.addLis(Util.getEl('#updContactBtn')[0], 'click', adminObj.validateCon); 
	}

	/* for the Add Account Assets Button on Add Account Assets Page */
	if( Util.getEl('#addAccAssetBtn').length != 0){
		Util.addLis(Util.getEl('#addAccAssetBtn')[0], 'click', adminObj.validateAccAsset);

	}

	/* for the Add Admin Button on Sign Up Page */
	if( Util.getEl('#addAdminBtn').length != 0){
		Util.addLis(Util.getEl('#addAdminBtn')[0], 'click', adminObj.addAdmin);
	}

	/* for the Add Association Button on Manage Contact Page */
	if( Util.getEl('#addAssociBtn').length != 0){
		Util.addLis(Util.getEl('#addAssociBtn')[0], 'click', adminObj.addAssoci);
	}

	/* for the Delete Button on View Delete Account Assets Page */
	if( Util.getEl('#vdaa_account_content').length != 0){
		Util.addLis(Util.getEl('#vdaa_account_content')[0], 'click', adminObj.delAsset);

	}

	/* for the Delete Button on Delete Contact Page */
	if( Util.getEl('#contactTable').length != 0){
		Util.addLis(Util.getEl('#contactTable')[0], 'click', adminObj.delContact);

	}

	/* for adding Listener to the contactTable on Manage Contact Page */
	if( Util.getEl('#mc_contact_content table').length != 0){
		Util.addLis( Util.getEl('#mc_contact_content table')[0], 'click', adminObj.delAssoci);   
	}

}

adminObj.addAdmin = function(){

	var obj = [];
	var flag = {};
	flag.page = "addAdmin";

    var data = {};
	data.email = document.getElementById('email').value;
	data.password = document.getElementById('password').value;

    obj.unshift(data);
	obj.unshift(flag);

	var data = JSON.stringify(obj);
	var phpFile = Util.getBasePath() + "xhr/switch.php";
	Util.sendRequest(phpFile, function(res){
         
			var msg = '';
			var msgObj = {};
			msgObj.heading = { background: 'red', text: 'Error', color: 'white '};
			 
			switch (res.responseText) {
				case 'error': msg = "There was an error processing your request"; break;
				case 'not found': msg = "There are no records found with that email and/or password"; break;
				case 'duplicate': msg = "That email and or password is taken"; break;
				case 'added': msgObj.heading = { background: 'green', text: 'Success', color: 'white '}; msg = "Admin has been added";Util.clearLabels(); break;
				default: msg = 'Something else went wrong'; break;
			}
	
			msgObj.body = {text: msg};
            Util.msgBox(msgObj);               
		    setTimeout(function(){Util.closeMsgBox();}, 3000);
		
	},data); 
}


adminObj.addAssoci = function(){

	var select = Util.getEl('#mc_contact_name')[0];
	var contact_name = select.options[select.selectedIndex].text;
	var contact_id = select.options[select.selectedIndex].value;

	var select = Util.getEl('#mc_account_name')[0];
	var account_name = select.options[select.selectedIndex].text;
	var account_id = select.options[select.selectedIndex].value;
	
	var select = Util.getEl('#mc_job_name')[0];
	var job_name = select.options[select.selectedIndex].text;
	var job_id = select.options[select.selectedIndex].value;

	if(job_name == "Select an job"){

		var msgObj = {};
		msgObj.heading = { background: '#0056B3', text: 'Reminder', color: 'white '};
		msgObj.body =	{text: 'Please select an job' };
		msgObj.rightbtn = {background: '#0056B3', color: 'white', text: 'OK', display:'block'};		
        Util.msgBox(msgObj);  
        Util.addLis( Util.getEl('#rightbtn')[0], 'click', Util.closeMsgBox ); 

	}else{

		var data = 'mc_addAssoci^^^' + account_id + '^^^' + job_id + '^^^' + contact_id ;
	    var phpFile = Util.getBasePath() + "xhr/switch.php"; //
	    //console.log("here" + data);
		Util.sendRequest(phpFile, function(res){
            
            var resArr = res.responseText.split("^^^")
			if(resArr[0] == 'success'){
				//console.log("***" + resArr[1]);
				Util.getEl('#mc_contact_content table')[0].setAttribute("class", "table table-striped table-bordered");
				Util.getEl('#mc_contact_content table')[0].innerHTML = resArr[1];

			}else{
				//alert(res.responseText);
				var msgObj = {};
				msgObj.heading = { background: 'red', text: 'Error', color: 'white '};
				msgObj.body =	{text: resArr[1] };
				msgObj.rightbtn = {background: 'red', color: 'white', text: 'OK', display:'block'};
                Util.msgBox(msgObj);  
                Util.addLis( Util.getEl('#rightbtn')[0], 'click', Util.closeMsgBox ); 
			}
	                
		}, data);

	}

}

adminObj.addAccAsset = function(formdata){


	var phpFile = Util.getBasePath() + "xhr/switch.php";
	Util.sendRequest(phpFile, function(res){
         	
		if(res.responseText == 'success'){
				var msgObj = {};
				msgObj.heading = { background: 'green', text: 'Success', color: 'white '};
				msgObj.body =	{text: 'Asset has been added.'};
                Util.msgBox(msgObj);               
				setTimeout(function(){Util.closeMsgBox();}, 1000);
				//clear the value in the fields of Asset Name and Asset File;
				Util.getEl("#asset_name")[0].value = '';
				Util.getEl("#file")[0].value = '';
		
		}
		else{
			 	var msgObj = {};
				msgObj.heading = { background: 'red', text: 'Error', color: 'white '};
				msgObj.body =	{text: res.responseText };
				msgObj.rightbtn = {background: 'red', color: 'white', text: 'OK', display:'block'};
                Util.msgBox(msgObj);  
                Util.addLis( Util.getEl('#rightbtn')[0], 'click', Util.closeMsgBox );  
		}
		
	},formdata,true); 	
	
}


adminObj.delAssoci = function(evt){

	if(evt.target.value == 'Delete'){

		var msgObj = {};
		msgObj.heading = { background: 'red', text: 'Warning', color: 'white '};
		var msg = 'You are about to delete this contact\'s association to it\'s related job and account. It will not be recoverable. If this is what you want to do click "Ok", Otherwise click "Cancel" ';
        msgObj.body = {text: msg};
        msgObj.leftbtn = {background: 'green', color: 'white', text:'Ok', display:'block'};
        msgObj.rightbtn = {background: 'red', color: 'white', text: 'Cancel', display:'block'};  
        Util.msgBox(msgObj);  
        //if click cancel on the right
        Util.addLis( Util.getEl('#rightbtn')[0], 'click', Util.closeMsgBox ); 
        //if click ok on the left
        Util.addLis( Util.getEl('#leftbtn')[0], 'click', function(){

            Util.closeMsgBox();

        	var associ_id = evt.target.id;
        	var select = Util.getEl("#mc_contact_name")[0];
        	var contact_id = select.options[select.selectedIndex].value;
        	 
            var data = "del_associ^^^" + associ_id + "^^^" + contact_id;

	        var phpFile = Util.getBasePath() + "xhr/switch.php"; //deleteContact
	        Util.sendRequest(phpFile, function(res){

                var msgObj = {};
	        	console.log(res.responseText);
                var resArr = res.responseText.split("^^^");
 				if(resArr[0] == 'success'){
					
					//alert('need to redisplay the table');
					Util.getEl('.row:nth-child(2) table')[0].innerHTML = resArr[1];
				}
				else{
					
					msgObj.heading = { background: 'red', text: 'Error', color: 'white '};
					msgObj.body =	{text: resArr[1] };
					msgObj.rightbtn = { background: 'red', color: 'white', text: 'OK', display:'block'};					
                    Util.msgBox(msgObj);  
                    Util.getEl('#rightbtn')[0].style.float = 'right';
                    Util.addLis( Util.getEl('#rightbtn')[0], 'click', Util.closeMsgBox );   
		
                }
	            
	        }, data);

        } ); 

	}//end if
}


adminObj.delContact = function(evt){

	if(evt.target.value == 'Delete'){

		var msgObj = {};
		msgObj.heading = { background: 'red', text: 'Warning', color: 'white '};
		var msg = 'You are about to delete this contact and its association to any job. It will not be recoverable. If this is what you want to do click "Ok", Otherwise click "Cancel" ';
        msgObj.body = {text: msg};
        msgObj.leftbtn = {background: 'green', color: 'white', text:'Ok', display:'block'};
        msgObj.rightbtn = {background: 'red', color: 'white', text: 'Cancel', display:'block'};  
        Util.msgBox(msgObj);  
        //if click cancel on the right
        Util.addLis( Util.getEl('#rightbtn')[0], 'click', Util.closeMsgBox ); 
        //if click ok on the left
        Util.addLis( Util.getEl('#leftbtn')[0], 'click', function(){

            Util.closeMsgBox();

        	var contact_id = evt.target.id;
        	
            var data = "del_contact^^^" + contact_id;

	        var phpFile = Util.getBasePath() + "xhr/switch.php"; //deleteContact
	        Util.sendRequest(phpFile, function(res){

                var msgObj = {};
	        	//console.log(res.responseText);
                var resArr = res.responseText.split("^^^");
 				if(resArr[0] == 'success'){
					
					//alert('need to redisplay the table');
					Util.getEl('.row:nth-child(2) table')[0].innerHTML = resArr[1];
				}
				else{
					
					msgObj.heading = { background: 'red', text: 'Error', color: 'white '};
					msgObj.body =	{text: resArr[1] };
					msgObj.rightbtn = { background: 'red', color: 'white', text: 'OK', display:'block'};					
                    Util.msgBox(msgObj);  
                    Util.getEl('#rightbtn')[0].style.float = 'right';
                    Util.addLis( Util.getEl('#rightbtn')[0], 'click', Util.closeMsgBox );   
		
                }
	            
	        }, data);

        } ); 

	}//end if
}

adminObj.delAsset = function(evt){

    var objArr = [], flag = {}, assetInfo = {};
    flag.page = "delAssset";
    var assetContainer = Util.getEl('#vdaa_account_content .col-6')[0];
    var select = Util.getEl('#vdaa_account_name')[0];
	var account_id = select.options[select.selectedIndex].value;

	if(evt.target.value == 'Delete'){

		var msgObj = {};
		msgObj.heading = { background: 'red', text: 'Warning', color: 'white '};
		var msg = 'You are about to delete this asset. It will not be recoverable. If this is what you want to do click "Ok", Otherwise click "Cancel" ';
        msgObj.body = {text: msg};
        msgObj.leftbtn = {background: 'green', color: 'white', text:'Ok', display:'block'};
        msgObj.rightbtn = {background: 'red', color: 'white', text: 'Cancel', display:'block'};  
        Util.msgBox(msgObj);  
        Util.addLis( Util.getEl('#rightbtn')[0], 'click', Util.closeMsgBox ); 

        Util.addLis( Util.getEl('#leftbtn')[0], 'click', function(){

            Util.closeMsgBox();
            //get the asset id, account id and the file path
        	assetInfo.id = evt.target.id.substr(5);
        	assetInfo.acc_id = account_id; 
        	assetInfo.file = evt.target.parentNode.previousSibling.firstChild.getAttribute('href');
	        objArr.unshift(assetInfo);
	        objArr.unshift(flag);
            var data = JSON.stringify(objArr);

	        var phpFile = Util.getBasePath() + "xhr/switch.php";
	        Util.sendRequest(phpFile, function(res){

                var msgObj = {};
	        	//console.log(res.responseText);
                var resArr = res.responseText.split("^^^");
 				if(resArr[0] == 'success'){
					
					msgObj.heading = { background: 'green', text: 'Success', color: 'white '};
					msgObj.body =	{text: 'Asset has been deleted.'};
                    Util.msgBox(msgObj);               
					setTimeout(function(){Util.closeMsgBox();}, 1500);
					assetContainer.innerHTML = resArr[1];
					
				}
				else{
					
					msgObj.heading = { background: 'red', text: 'Error', color: 'white '};
					msgObj.body =	{text: res.responseText };
					msgObj.rightbtn = { background: 'red', color: 'white', text: 'OK', display:'block'};					
                    Util.msgBox(msgObj);  
                    Util.getEl('#rightbtn')[0].style.float = 'right';
                    Util.addLis( Util.getEl('#rightbtn')[0], 'click', Util.closeMsgBox );   
		
                }
	            
	        }, data);

        } ); 
        
	}

}


adminObj.showInfo4Account = function(evt){

	switch(evt.target.id){
		case 'aaa_account_name': showList('aaa_account_name','aaa_account_content'); break;
        //case 'aj_account_name': showList('aj_account_name','aj_job_content'); break;
	}

	function showList(name, content){

			var select = Util.getEl('#'+ name)[0];
			var account_name = select.options[select.selectedIndex].text;

			if(account_name !="Select an account"){	

				Util.getEl('#' + content )[0].style.display = 'block';
			}else{
				Util.getEl('#' + content )[0].style.display = 'none';
			}	

	}

}



adminObj.showInfo4vdAccAsset = function(){

	var arr = [];
	var select = Util.getEl('#vdaa_account_name')[0];
    var account_name = select.options[select.selectedIndex].text;
    var assetContainer = Util.getEl('#vdaa_account_content .col-6')[0];

	if(account_name !="Select an account"){

		//add selected account id to data
		var obj = {};
		
		var account_id = select.options[select.selectedIndex].value;
		obj.id = account_id;
		arr.unshift(obj);

		//add page flag
		var flag = {};
		flag.page = 'showInfo4vdAccAsset';
		arr.unshift(flag);

		var data = JSON.stringify(arr);

		var phpFile = Util.getBasePath() + "xhr/switch.php";
		Util.sendRequest(phpFile, function(res){
                
			var table = res.responseText;
            assetContainer.innerHTML =   table  ;
                
		}, data);
	}else{

		assetContainer.innerHTML = '' ;
	}
	
	
}

/** for Manage Contact Page **/

adminObj.showInfo4ManageContact = function(){

	var select = Util.getEl('#mc_contact_name')[0];
	var contact_name = select.options[select.selectedIndex].text;
	var contact_id = select.options[select.selectedIndex].value;
	var data = 'mc_contact^^^' + contact_id;

	if(contact_name !="Select an contact"){

        Util.getEl('#mc_contact_content')[0].style.display = 'block';
        Util.getEl('#mc_contact_content h1')[0].innerHTML = contact_name;
        var pElement = Util.getEl("#mc_contact_content .row:nth-child(2) p")[0]; 

        var phpFile = Util.getBasePath() + "xhr/switch.php"; //checkAssociationInfo
		Util.sendRequest(phpFile, function(res){
			    
			    if(res.responseText.indexOf("There is not any association for this contact") != -1){
			    	Util.getEl('#mc_contact_content table')[0].innerHTML = '';                           
	                pElement.innerHTML = res.responseText ;
                }
                else{                                  
                	var tableElement = Util.getEl('#mc_contact_content table')[0];
                	tableElement.setAttribute("class", "table table-striped table-bordered");
				    tableElement.innerHTML = res.responseText;				    
				    pElement.innerHTML = ''	;			   
                	
                }
              
		}, data);

    }else{
    	document.forms[0].reset();
    	Util.getEl('#mc_contact_content')[0].style.display = 'none';
    }


}

adminObj.showInfo4ManageContact2 = function(){

	var select = Util.getEl('#mc_account_name')[0];
	var account_name = select.options[select.selectedIndex].text;
	var account_id = select.options[select.selectedIndex].value;
	var data = 'mc_account^^^' + account_id;

	if(account_name != "Select an account"){

        var phpFile = Util.getBasePath() + "xhr/switch.php";  
		Util.sendRequest(phpFile, function(res){

			    if(res.responseText == 'norecord'){
			    	Util.getEl('#mc_associ_content')[0].style.display = 'none';
			    	Util.getEl('#mc_contact_content #mc_account_name+h6')[0].innerHTML = 'There is no job associate to this account yet.';
			    }else{
			    	Util.getEl('#mc_associ_content')[0].style.display = 'block';
			    	Util.getEl('#mc_contact_content #mc_account_name+h6')[0].innerHTML = '';
			    	Util.getEl('#mc_job_name').innerHTML = res.responseText;
			    }

                var selectElement = Util.getEl("#mc_job_name")[0];   
                selectElement.innerHTML = res.responseText ;

                
		}, data);
        
	}else{
        Util.getEl('#mc_contact_content #mc_account_name+h6')[0].innerHTML = '';
    	Util.getEl('#mc_associ_content')[0].style.display = 'none';
    }


}


/* Get the data info for database for the chosen contact for update */
adminObj.showInfo4updCon = function(){

    //clear the errors if there is any
	Util.clearLabels();

	var select = Util.getEl('#upd_contact_name')[0];
	var contact_name = select.options[select.selectedIndex].text;
	var contact_id = select.options[select.selectedIndex].value;
	var data = 'contact^^^' + contact_id;

	if(contact_name !="Select an contact"){

        Util.getEl('#upd_contact_content')[0].style.display = 'block';

		var phpFile = Util.getBasePath() + "xhr/switch.php";
		Util.sendRequest(phpFile, function(res){
			        if(res.responseText != 'error'){
			        	 var arr = res.responseText.split("^^^");
						 Util.getEl('#name')[0].value = arr[0];
						 Util.getEl('#work_phone')[0].value= arr[1];
						 Util.getEl('#mobile_phone')[0].value= arr[2];
						 Util.getEl('#email')[0].value= arr[3];
					}
					else{
						console.log(res.responseText);
					}
		}, data);
	}
	else{
		document.forms[0].reset();
		Util.getEl('#upd_contact_content')[0].style.display = 'none';
	}
}

/* Get the data info for database for the chosen account for update */
adminObj.showInfo4updAcc = function(){

	Util.clearLabels();

	var select = Util.getEl('#upd_account_name')[0];
	var account_name = select.options[select.selectedIndex].text;
	var account_id = select.options[select.selectedIndex].value;
	var data = 'account^^^' + account_id;
	//console.log(data);

	if(account_name !="Select an account"){

        Util.getEl('#upd_account_content')[0].style.display = 'block';

		var phpFile = Util.getBasePath() + "xhr/switch.php";
		Util.sendRequest(phpFile, function(res){
			        if(res.responseText != 'error'){
			        	 var arr = res.responseText.split("^^^");
						 Util.getEl('#name')[0].value = arr[0];
						 Util.getEl('#address')[0].value= arr[1];
						 Util.getEl('#city')[0].value= arr[3];
						 Util.getEl('#state')[0].value= arr[2];
						 Util.getEl('#zip')[0].value= arr[4];
						 Util.getEl('#account_folder')[0].value= arr[5];
					}
					else{
						console.log(res.responseText);
					}
		}, data);
	}
	else{
		document.forms[0].reset();
		Util.getEl('#upd_account_content')[0].style.display = 'none';
	}

}



adminObj.updContact = function(data){

	 var phpFile = Util.getBasePath() + "xhr/switch.php";

     Util.sendRequest(phpFile, function(res){
		if(res.responseText == 'success'){
					
					var msgObj = {};
					msgObj.heading = { background: 'green', text: 'Contact Updated', color: 'white '};
					msgObj.body =	{text: 'Contact has been updated.'};
                    Util.msgBox(msgObj);               
					setTimeout(function(){Util.closeMsgBox();}, 1500);
					//clear all the value in the fields
					document.forms[0].reset();
					Util.getEl('#upd_contact_content')[0].style.display = 'none';
					//reload the page to recreate the account list
					setTimeout(function(){window.location.reload();}, 1500);
					
				}
				else{
					var msgObj = {};
					console.log("here: " + res.responseText);
					msgObj.heading = { background: 'red', text: 'Error', color: 'white '};
					msgObj.body =	{text: res.responseText };
					msgObj.rightbtn = {background: 'red', color: 'white', text: 'OK', display:'block'};
                    Util.msgBox(msgObj);  
                    Util.addLis( Util.getEl('#rightbtn')[0], 'click', Util.closeMsgBox );   
					
				}
	}, data);
}

adminObj.updateAccount = function(data){

     var phpFile = Util.getBasePath() + "xhr/switch.php";

     Util.sendRequest(phpFile, function(res){
		if(res.responseText == 'success'){
					
					var msgObj = {};
					msgObj.heading = { background: 'green', text: 'Account Updated', color: 'white '};
					msgObj.body =	{text: 'Account has been updated.'};
                    Util.msgBox(msgObj);               
					setTimeout(function(){Util.closeMsgBox();}, 1500);
					//clear all the value in the fields
					document.forms[0].reset();
					Util.getEl('#upd_account_content')[0].style.display = 'none';
					//reload the page to recreate the account list
					setTimeout(function(){window.location.reload();}, 1500);
					
				}
				else{
					var msgObj = {};
					//console.log("here: " + res.responseText);
					msgObj.heading = { background: 'red', text: 'Error', color: 'white '};
					msgObj.body =	{text: res.responseText };
					msgObj.rightbtn = {background: 'red', color: 'white', text: 'OK', display:'block'};
                    Util.msgBox(msgObj);  
                    Util.addLis( Util.getEl('#rightbtn')[0], 'click', Util.closeMsgBox );   
					
				}
	}, data);

}


/* This validate function is used for validate contact info:: both add contact page and update contact page. */
adminObj.validateCon = function(evt){

	var i = 0, j = 0, inputs = Util.getEl('input[type="text"]'), obj;

	//clear all the label error messages
    Util.clearLabels();
	obj = [

		{for: 'name', regex: 'contact_name', msg: "Contact Name cannot be blank and can only begin with Letters, and include numbers, spaces, single quotation marks and hyphens."},
		{for: 'work_phone', regex: 'phone', msg: "Work Phone numbers can not be blank and has to be valid(9 digits)"},
		{for: 'mobile_phone', regex: 'phone', msg: "Phone numbers is not valid (9 digits)"},
		{for: 'email', regex:'email', msg: "Email can not be blank and has to be valid"}
		
	]
    
	while(i < inputs.length){
		j = 0;
		while(j < obj.length){
			if(inputs[i].id == obj[j].for){
				obj[j].value = inputs[i].value.trim(); //removing the blanks at the front and the end
				break;
			}
			j++;
		}
		i++;
	}
  
	var flag= {};
	if(evt.target.id == 'addContactBtn'){
		flag.page = 'addCon';
	}else{

		var select = Util.getEl('#upd_contact_name')[0];
     	var con_id = {};
        con_id.for = 'id'; 
        con_id.value = select.options[select.selectedIndex].value;
      	obj.unshift(con_id); 
		flag.page = 'updCon';
	}
		
	obj.unshift(flag);
	var data = JSON.stringify(obj);
	var phpFile = Util.getBasePath() + "xhr/val.php";

	Util.sendRequest(phpFile, function(res){
				if(res.responseText == 'success'){	
				            		  
				            if(evt.target.id == 'addContactBtn'){       
								Util.addData(obj);
							}else{
								adminObj.updContact(data);
							}				 
						}
						else{											
							Util.displayError(JSON.parse(res.responseText));
						}
	}, data);
	
}

 
/* This validate function is used for validate account info: both add account page and update account page. */
adminObj.validateAcc = function(evt){

	var i = 0, j = 0, inputs = Util.getEl('input[type="text"]'), obj;

	//clear all the label error messages
    Util.clearLabels();
	obj = [
		{for: 'name', regex: 'general_name', msg: "Account Name cannot be blank and can only begin with Letters, and include numbers, spaces, single quotation marks and hyphens."},
		{for: 'address', regex: 'address', msg: "Address cannot be blank and can only include Letters, with spaces, hyphens, numbers"},
		{for: 'city', regex:'city', msg: "City cannot be blank and can only include Letters, with spaces or hyphens"},
		{for: 'state', regex:'state', msg: "State cannot be blank and must be a valid US state"},
		{for: 'zip', regex: 'zip', msg: "Zipcode cannot be blank and need to be five digits"},
		{for: 'account_folder', regex: 'folder_name', msg: "Folder Name cannot be blank and can only include Letters, with spaces, single quotation marks and hyphens"}
	];

	while(i < inputs.length){
		j = 0;
		while(j < obj.length){
			if(inputs[i].id == obj[j].for){
				obj[j].value = inputs[i].value.trim(); //removing the blanks at the front and the end
				break;
			}
			j++;
		}
		i++;
	}

	var flag = {};
	if(evt.target.id == 'addAccountBtn'){
		flag.page = 'addAcc';
	}else{

		var select = Util.getEl('#upd_account_name')[0];
     	var acc_id = {};
        acc_id.for = 'id'; 
        acc_id.value = select.options[select.selectedIndex].value;
      	obj.unshift(acc_id); 
		flag.page = 'updAcc';
	}
    obj.unshift(flag);
    var data = JSON.stringify(obj);
	var phpFile = Util.getBasePath() + "xhr/val.php";
	

	Util.sendRequest(phpFile, function(res){

		if(res.responseText == 'success'){			         
			
			if(evt.target.id == 'addAccountBtn'){			
				Util.addData(obj);
			}else{
				adminObj.updateAccount(data);
			}				 
					

		}else{
		        
			Util.displayError(JSON.parse(res.responseText));
		}
	}, data);
	

}


adminObj.validateAccAsset = function(){

	//the object to be deliver for validation through ajax
    var obj; 
    obj = [
		{for: 'asset_name', regex: 'asset_name', msg: "Asset Name cannot be blank and can only begin with Letters, can include other symbols"},
		{for: 'asset_file', regex: 'file', msg: "Please upload the asset file. File Size not bigger than 800KB and has to be PDF Format."}
	];

	//asset name
	var isFieldEmpty = false;
	var assetName = Util.getEl('#asset_name')[0].value.trim();
	var fileName = Util.getEl('#file')[0].value.trim();
	
	//clear all the label error messages
    Util.clearLabels();
    
    if( assetName == ''){
    	obj[0].status = 'error';
    	isFieldEmpty = true;
    }
    else{
    	obj[0].value = assetName;
    }

    if( fileName == ''){
    	obj[1].status = 'error';
    	isFieldEmpty = true;
    }


    if(isFieldEmpty){ 
    	Util.displayError(obj);
    	return;
    }

    //add account id
    var select = Util.getEl('#aaa_account_name')[0];
    var acc_id = {};
	acc_id.for = 'id';
	acc_id.value = select.options[select.selectedIndex].value;
	obj.unshift(acc_id);

    //add page flag
	var flag = {};
	flag.page = 'addAccAsset';
	obj.unshift(flag);

	//stringify the data object
    var data = JSON.stringify(obj);

    //add data and file to FormData object
	var formdata = new FormData();
  	formdata.append('data',data);
  	formdata.append('file',file.files[0]);

  	var arr;
	var phpFile = Util.getBasePath() + "xhr/val.php";
	Util.sendRequest(phpFile, function(res){
         
		if(res.responseText == 'success'){
            
			adminObj.addAccAsset(formdata);
		}
		else{
			
			Util.displayError(JSON.parse(res.responseText));
		}
		
	},formdata,true); 
   
				
}



adminObj.init();

