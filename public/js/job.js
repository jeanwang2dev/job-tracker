"use strict"

/* Object For the Jobs */
var jobObj = {}

jobObj.init = function(){


	/* for the Select an account field to show account names on Add Job Page */
	if( Util.getEl('#aj_account_name').length != 0){
		Util.addLis(Util.getEl('#aj_account_name')[0], 'change', jobObj.showInfo4addJob);
	}

	/* for the Add Job Button on Add Job Page, validate first then add job*/
	if( Util.getEl('#addJobBtn').length != 0){		
		Util.addLis(Util.getEl('#addJobBtn')[0], 'click', jobObj.validateJob);
	} 

	/* for the Select an account field to show Job names on Add Job Notes Page */
	if( Util.getEl('#job_account_name').length != 0){
		Util.addLis(Util.getEl('#job_account_name')[0], 'change', jobObj.showJobList); 
	}

}

jobObj.addJobAsset = function(formdata){

	var phpFile = Util.getBasePath() + "xhr/switch.php";
	Util.sendRequest(phpFile, function(res){
         	
		if(res.responseText == 'success'){
				var msgObj = {};
				msgObj.heading = { background: 'green', text: 'Success', color: 'white '};
				msgObj.body =	{text: 'Job Asset has been added.'};
                Util.msgBox(msgObj);               
				setTimeout(function(){Util.closeMsgBox();}, 1000);
				//clear the value in the fields of Asset Name and Asset File;
				Util.getEl("#asset_name")[0].value = '';
				Util.getEl("#asset_file")[0].value = '';
		
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


jobObj.clearPreviousContent = function(){

		Util.removeJobList('ajn_job_name');
        Util.removeJobList('vcdjn_job_name');
        Util.removeJobList('aja_job_name');
        Util.removeJobList('ajh_job_name');
        Util.removeJobList('udh_job_name');
        Util.removeJobList('vdja_job_name');
        Util.removeJobList('vjc_job_name');
        Util.removeJobList('pi_job_name');
        Util.removeJobList('job_account_name+p');
		Util.getEl('#job_content')[0].innerHTML = '';
}


jobObj.delJobAsset = function(evt){

	if(evt.target.value == 'Delete'){

		var msgObj = {};
		msgObj.heading = { background: 'red', text: 'Warning', color: 'white '};
		var msg = 'You are about to delete this Job Asset. It will not be recoverable. If this is what you want to do click "Ok", Otherwise click "Cancel" ';
        msgObj.body = {text: msg};
        msgObj.leftbtn = {background: 'green', color: 'white', text:'Ok', display:'block'};
        msgObj.rightbtn = {background: 'red', color: 'white', text: 'Cancel', display:'block'};  
        Util.msgBox(msgObj);  
        //if click cancel on the right
        Util.addLis( Util.getEl('#rightbtn')[0], 'click', Util.closeMsgBox ); 
        //if click ok on the left
        Util.addLis( Util.getEl('#leftbtn')[0], 'click', function(){

            Util.closeMsgBox();
	        var asset_id = evt.target.id;
			var data = "del_jobAsset^^^" + asset_id;

			var phpFile = Util.getBasePath() + "xhr/switch.php";
			Util.sendRequest(phpFile, function(res){

				var resArr = res.responseText.split("^^^");
				
				if(resArr[0] == 'success'){
					 
					 if(resArr[1] == 'norecord'){

					 	 Util.getEl('#job_content')[0].innerHTML = "<p> There is no Asset added to this job yet </p>";

					 }else{
						 //reshow the job Asset table
						 Util.getEl('#job_content')[0].innerHTML = resArr[1];
						 //re-add listeners to the buttons
						 Util.addLis(Util.getEl('table')[0], 'click', jobObj.delJobAsset);
				    }

				}else{
					 
					 msgObj.heading = { background: 'red', text: 'Error', color: 'white '};
					 msgObj.body =	{text: resArr[1] };
					 msgObj.rightbtn = { background: 'red', color: 'white', text: 'OK', display:'block'};					
	                 Util.msgBox(msgObj);  
	                 Util.getEl('#rightbtn')[0].style.float = 'right';
	                 Util.addLis( Util.getEl('#rightbtn')[0], 'click', Util.closeMsgBox ); 
				}


			}, data);

		});

	}

}

/* Update or Delete job Hours */
jobObj.modifyJobHours =function(evt){

	var select = Util.getEl('#job_account_name')[0];
	var account_id = select.options[select.selectedIndex].value;
    select = Util.getEl('#udh_job_name')[0];
    var job_id = select.options[select.selectedIndex].value;
	var jh_id = evt.target.id;

	if(evt.target.value == 'Update'){
              
		var date = evt.target.parentNode.parentNode.firstElementChild.firstElementChild.value;
		var hours = evt.target.parentNode.parentNode.firstElementChild.nextElementSibling.firstElementChild.value;
		var rate = evt.target.parentNode.parentNode.firstElementChild.nextElementSibling.nextElementSibling.firstElementChild.value;
		var desc = evt.target.parentNode.previousElementSibling.firstElementChild.value;

		var obj = [
		    {for: 'id', value: jh_id},
			{for: 'date', value: date},
			{for: 'hours', value: hours},
			{for: 'rate', value: rate},
			{for: 'desc', value: desc}
		];
		var flag = {};
	    flag.page = 'updJobHour';
        obj.unshift(flag);

		Util.addData(obj);

	}

	if(evt.target.value == 'Delete'){
        
		var data = "del_jobHour^^^" + jh_id + "^^^" + account_id + "^^^" + job_id;

		var phpFile = Util.getBasePath() + "xhr/switch.php";
		Util.sendRequest(phpFile, function(res){

			var resArr = res.responseText.split("^^^");
			if(resArr[0] == 'success'){			 
				 //reshow the job Hour table
				 Util.getEl('#job_content')[0].innerHTML = resArr[1];
				 Util.addLis(Util.getEl('table')[0], 'click', jobObj.modifyJobHours);

			}else{
				 
				 msgObj.heading = { background: 'red', text: 'Error', color: 'white '};
				 msgObj.body =	{text: resArr[1] };
				 msgObj.rightbtn = { background: 'red', color: 'white', text: 'OK', display:'block'};					
                 Util.msgBox(msgObj);  
                 Util.getEl('#rightbtn')[0].style.float = 'right';
                 Util.addLis( Util.getEl('#rightbtn')[0], 'click', Util.closeMsgBox ); 
			}


		}, data);

	}

}

/* Update or Delete job Notes */
jobObj.modifyJobNotes = function(evt){

	var select = Util.getEl('#job_account_name')[0];
	var account_id = select.options[select.selectedIndex].value;
    select = Util.getEl('#vcdjn_job_name')[0];
    var job_id = select.options[select.selectedIndex].value;
	var jn_id = evt.target.id;

	if(evt.target.value == 'Update'){
              
		var date = evt.target.parentNode.parentNode.firstElementChild.firstElementChild.value;
		var note_name =evt.target.parentNode.parentNode.firstElementChild.nextElementSibling.firstElementChild.value;
		var note = evt.target.parentNode.previousElementSibling.firstElementChild.value;

		var obj = [
		    {for: 'id', value: jn_id},
			{for: 'date', value: date},
			{for: 'note_name', value: note_name},
			{for: 'note', value: note}
		];
		var flag = {};
	    flag.page = 'updJobNote';
        obj.unshift(flag);

		Util.addData(obj);

	}

	if(evt.target.value == 'Delete'){

		var data = "del_jobNote^^^" + jn_id + "^^^" + account_id + "^^^" + job_id;

		var phpFile = Util.getBasePath() + "xhr/switch.php";
		Util.sendRequest(phpFile, function(res){

			var resArr = res.responseText.split("^^^");
			if(resArr[0] == 'success'){
				 
				 //reshow the jobNote table
				 Util.getEl('#job_content')[0].innerHTML = resArr[1];
				 //re-add listeners to the buttons
				 Util.addLis(Util.getEl('table')[0], 'click', jobObj.modifyJobNotes);

			}else{
				 
				 msgObj.heading = { background: 'red', text: 'Error', color: 'white '};
				 msgObj.body =	{text: resArr[1] };
				 msgObj.rightbtn = { background: 'red', color: 'white', text: 'OK', display:'block'};					
                 Util.msgBox(msgObj);  
                 Util.getEl('#rightbtn')[0].style.float = 'right';
                 Util.addLis( Util.getEl('#rightbtn')[0], 'click', Util.closeMsgBox ); 
			}


		}, data);

	}

}

/* show the job list for selected account */
jobObj.showJobList = function(){
    
	var select = Util.getEl('#job_account_name')[0];
	var account_name = select.options[select.selectedIndex].text;
	var account_id = select.options[select.selectedIndex].value;
	var data = 'job_account^^^' + account_id;

	if(account_name !="Select an account"){
		
        jobObj.clearPreviousContent();

		var phpFile = Util.getBasePath() + "xhr/switch.php"; //showJobList
		Util.sendRequest(phpFile, function(res){
            
			    if(res.responseText == 'norecord'){
			    	var pEl = document.createElement('p');
			    	Util.getEl('#job_account_name')[0].parentNode.appendChild(pEl);
			    	Util.getEl('#job_account_name+p')[0].innerHTML = 'There is no job associate to this account yet.';

			    	
			    }else{			    	
			    	var select = document.createElement('select');
			    	select.className = 'custom-select';
			    	//get what the current page is then created the select list with relative id name
			    	switch(Util.getEl('main h1')[0].firstChild.nodeValue){
			    		case 'Add Job Notes': select.id = 'ajn_job_name'; break;
			    		case 'View/Change/Delete Job Notes': select.id = 'vcdjn_job_name'; break;
			    		case 'Add Job Assets': select.id = 'aja_job_name'; break;
			    		case 'Add Job Hours': select.id = 'ajh_job_name'; break;
			    		case 'Update Delete Job Hours': select.id = 'udh_job_name'; break;
			    		case 'View Delete Job Assets': select.id = 'vdja_job_name'; break;
			    		case 'View Job Contacts': select.id = 'vjc_job_name'; break;
			    		case 'Print Invoice': select.id = 'pi_job_name'; break;
			    	}
			    	
	    			Util.getEl('#job_account_name')[0].parentNode.appendChild(select);	    			
                    Util.getEl('#'+ select.id)[0].innerHTML = res.responseText;

                    //add listener to the select list              
                    Util.addLis4ListChange('ajn_job_name',  jobObj.showInfo4addJobNotes);
                    Util.addLis4ListChange('vcdjn_job_name',jobObj.showInfo4vcdJobNotes);
                    Util.addLis4ListChange('aja_job_name',  jobObj.showInfo4addJobAssets);
                    Util.addLis4ListChange('ajh_job_name',  jobObj.showInfo4addJobHours);
                    Util.addLis4ListChange('udh_job_name',  jobObj.showInfo4updDelJobHours);
                    Util.addLis4ListChange('vdja_job_name', jobObj.showInfo4vdJobAssets);
                    Util.addLis4ListChange('vjc_job_name', jobObj.showInfo4viewJobContacts);
                    Util.addLis4ListChange('pi_job_name', jobObj.showInfo4PrintInvoice);
                    
			    }
                
		}, data);

	}else{

		jobObj.clearPreviousContent();

	}

}


jobObj.showInfo4PrintInvoice = function(){

	var select = Util.getEl('#pi_job_name')[0];
	var job_name = select.options[select.selectedIndex].text;
	var job_id = select.options[select.selectedIndex].value;

	if(job_name !="Select an job"){

		//do an ajax call to see if this job has any hours on it yet, if there is then show the job Content
		// and get the beginning date and ending date of the job and populate the date fields
		//if there is not then show You haven't started working on this job yet.
        var data = "checkJobHour^^^" + job_id;
         
		var phpFile = Util.getBasePath() + "xhr/switch.php";
	    Util.sendRequest(phpFile, function(res){
          
	      var resArr = res.responseText.split("^^^");	

		  if(resArr[0] == 'norecord'){

		 	Util.getEl('#job_content')[0].innerHTML = "<p>You haven't started working on this job yet</p>";
		
		  }else{

            var beg_date = resArr[1];
            var end_date = resArr[2];
		 	var begStr = '<div class="row form-group"><div class="col-5">';
		 	var endStr = '</div></div>';
		 	var jobContent = begStr + '<label for="beg_date">Beginning Date: <i data-toggle="popover"></i></label>';
		    jobContent += '<input type="date" class="form-control" id="beg_date" name="beg_date" placeHolder="mm/dd/yyyy"  value="' + beg_date +'">';            
		    jobContent += endStr;    
		    jobContent += begStr;            
		    jobContent += '<label for="end_date">Ending Date: <i data-toggle="popover"></i></label>';
		    jobContent += '<input type="date" class="form-control" id="end_date" name="end_date" placeHolder="mm/dd/yyyy"   value="'+ end_date +'">';
		    jobContent += endStr;       
		    jobContent += '<button type="button" name="priInBtn" id="priInBtn" class="btn btn-success"> Get Invoice </button>';                   
		                     
			Util.getEl('#job_content')[0].innerHTML = jobContent;		
			Util.addLis(Util.getEl('#priInBtn')[0], 'click', jobObj.validate4Invoice);
			Util.showToolTip();

		 	}

		 }, data);

	}else{
		Util.getEl('#job_content')[0].innerHTML = '';
	}

}

jobObj.showInfo4addJobAssets = function(){

	var select = Util.getEl('#aja_job_name')[0];
	var job_name = select.options[select.selectedIndex].text;

	if(job_name !="Select an job"){

		var strBeg = '<div class="row form-group"><div class="col-7">';
		var strEnd = '</div></div>';
		var strName = strBeg +  '<label for="asset_name">Asset Name: <i data-toggle=\'popover\'></i></label><input type="text" class="form-control" id="asset_name" name="name" value="">' + strEnd;
		var strFile = strBeg + '<label for="asset_file">Asset File: <i data-toggle=\'popover\'></i></label><input type="file" class="form-control" id="asset_file" name="file">' + strEnd;
		var strBtn = '<button type="button" name="ajaBtn" id="ajaBtn" class="btn btn-success"> Add Asset To Job </button>';
		Util.getEl('#job_content')[0].innerHTML = strName + strFile + strBtn;
		Util.addLis(Util.getEl('#ajaBtn')[0], 'click', jobObj.validateJobAsset);
		Util.showToolTip();

	}else{
		Util.getEl('#job_content')[0].innerHTML = '';
	}
}



jobObj.showInfo4vdJobAssets = function(){

	/* clear Previous Content if there is any  */
    Util.getEl("#job_content")[0].innerHTML = '';

	var select = Util.getEl('#job_account_name')[0];
	var account_id = select.options[select.selectedIndex].value;
	select = Util.getEl('#vdja_job_name')[0];
	var job_name = select.options[select.selectedIndex].text;
	var job_id = select.options[select.selectedIndex].value;
	var data = "vd_JobAsset^^^" + job_id;

	if(job_name !="Select an job"){
        
        var phpFile = Util.getBasePath() + "xhr/switch.php"; // 
		Util.sendRequest(phpFile, function(res){
			 
			 if(res.responseText == 'norecord'){
			    	var p = document.createElement('p');
			    	p.innerHTML = 'There is no asset added to this job in this account yet.';
			    	Util.getEl("#job_content")[0].appendChild(p);
                     
                }
                else{                                                  	 		  
                	
                	var table = document.createElement("table");
        		    table.setAttribute('class', 'table table-striped table-bordered');	
				    table.innerHTML = res.responseText;
        			Util.getEl("#job_content")[0].appendChild(table);
        			Util.addLis(Util.getEl('table')[0], 'click', jobObj.delJobAsset);
                }
              
		}, data);

    }else{

    	Util.getEl("#job_content")[0].innerHTML = '';

    }

}


jobObj.showInfo4viewJobContacts = function(){

    var selectAccount = Util.getEl('#job_account_name')[0];
	var account_name = selectAccount.options[selectAccount.selectedIndex].text;
	var account_id = selectAccount.options[selectAccount.selectedIndex].value;

	var selectJob = Util.getEl('#vjc_job_name')[0];
	var job_name = selectJob.options[selectJob.selectedIndex].text;
	var job_id = selectJob.options[selectJob.selectedIndex].value;
	var data = 'vjc_contact^^^' + account_id + "^^^" + job_id;

		/* clear Table if there is one */
	if(Util.getEl('table').length!= 0){
    		var tableNode = Util.getEl('table')[0];
    		Util.getEl('table')[0].parentNode.removeChild(tableNode);
    }
    /* clear p node if there is one */
    Util.getEl("#job_content")[0].innerHTML = '';

	if(job_name !="Select an job"){
       
        var phpFile = Util.getBasePath() + "xhr/switch.php"; // 
		Util.sendRequest(phpFile, function(res){
			 if(res.responseText == 'norecord'){
			    	 var p = document.createElement('p');
			    	 p.innerHTML = 'There is no contact associate with this job in this account.';
			    	 Util.getEl("#job_content")[0].appendChild(p);
                     
                }
                else{                                                  	 		  
                	
                	var table = document.createElement("table");
        		    table.setAttribute('class', 'table table-striped table-bordered');	
				    table.innerHTML = res.responseText;
        			Util.getEl("#job_content")[0].appendChild(table);
                }
              
		}, data);

    }else{

    	Util.getEl("#job_content")[0].innerHTML = '';

    }
	
}

jobObj.showInfo4addJob = function(){


   	var select = Util.getEl('#aj_account_name')[0];
	var account_name = select.options[select.selectedIndex].text;

	if(account_name !="Select an account"){
	
    var jobContent = Util.heredoc( function(){/* 
			 <div class="row form-group">                       
                    <div class="col-7">
                                      <label for="job_name">Job Name: <i data-toggle='popover'></i></label>
                                      <input type="text" class="form-control" id="job_name" name="job_name" value="">
                    </div>   
             </div>


                    <div class="row form-group">                       
                                  <div class="col-7">
                                      <label for="job_asset_folder">Asset Folder: <i data-toggle='popover'></i></label>
                                      <input type="text" class="form-control" id="job_asset_folder" name="job_asset_folder" value="">
                                  </div>   
                    </div>

                    <button type="button" name="addJobBtn" id="addJobBtn" class="btn btn-primary"> Add Job </button>
		*/});

		Util.getEl('#job_content')[0].innerHTML = jobContent;
		Util.addLis(Util.getEl('#addJobBtn')[0], 'click', jobObj.validateJob);
		Util.showToolTip();

	}else{
		Util.getEl('#job_content')[0].innerHTML = '';
	}

}

jobObj.showInfo4updDelJobHours = function(){

	var select = Util.getEl('#job_account_name')[0];
	var account_id = select.options[select.selectedIndex].value;
	select = Util.getEl('#udh_job_name')[0];
	var job_name = select.options[select.selectedIndex].text;
	var job_id = select.options[select.selectedIndex].value;
	var data = "udh_account_job^^^" + account_id + "^^^" + job_id;

    if(job_name != "Select an job"){

		var phpFile = Util.getBasePath() + "xhr/switch.php"; //showJobHourTable
		Util.sendRequest(phpFile, function(res){
			if(res.responseText != 'norecord'){
				Util.getEl('#job_content')[0].innerHTML =res.responseText;
				//add listener
				Util.addLis(Util.getEl('table')[0], 'click', jobObj.modifyJobHours);

			}else{
				Util.getEl('#job_content')[0].innerHTML = '<p> There is no hour worked on this job yet. </p>';
			}


		}, data);

	}else{
		Util.getEl('#job_content')[0].innerHTML = '';
	}


}


jobObj.showInfo4vcdJobNotes = function(){

	var select = Util.getEl('#job_account_name')[0];
	var account_id = select.options[select.selectedIndex].value;
	select = Util.getEl('#vcdjn_job_name')[0];
	var job_name = select.options[select.selectedIndex].text;
	var job_id = select.options[select.selectedIndex].value;
	var data = "vcdjn_account_job^^^" + account_id + "^^^" + job_id;
    
    if(job_name != "Select an job"){

		var phpFile = Util.getBasePath() + "xhr/switch.php"; //showJobNoteTable
		Util.sendRequest(phpFile, function(res){
			if(res.responseText != 'norecord'){
				Util.getEl('#job_content')[0].innerHTML =res.responseText;
				//add listener
				Util.addLis(Util.getEl('table')[0], 'click', jobObj.modifyJobNotes);

			}else{
				Util.getEl('#job_content')[0].innerHTML = '<p> There is no note attach to this job yet. </p>';
			}


		}, data);

	}else{
		Util.getEl('#job_content')[0].innerHTML = '';
	}

}


/* show add hour area for selected job */
jobObj.showInfo4addJobHours = function(){

	var select = Util.getEl('#ajh_job_name')[0];
	var job_name = select.options[select.selectedIndex].text;

	if(job_name !="Select an job"){
	
	var strContent = Util.heredoc( function(){/* 
			<div class="row form-group"><div class="col-3">
<label for="date">Date: <i data-toggle='popover'></i></label>
<input type="date" class="form-control" id="date" name="date" value="mm/dd/yyyy"></div></div>

<div class="row form-group"><div class="col-2">
<label for="hours">Hours: <i data-toggle='popover'></i></label><input type="text" class="form-control" id="hours" name="hours" value=""></div>
<div class="col-4"><label for="hourly_rate">Hourly Rate: <i data-toggle='popover'></i></label>
<input type="text" class="form-control" id="hourly_rate" name="hourly_rate" value="75"></div></div>

<div class="row form-group"><div class="col-7">
<label for="desc">Description: <i data-toggle='popover'></i></label>
<textarea class="form-control" rows="8" id="desc" name="desc" value=""></textarea>
</div></div>
		*/});

		strContent += '<button type="button" name="ajhBtn" id="ajhBtn" class="btn btn-success"> Add Hours </button>';
		Util.getEl('#job_content')[0].innerHTML = strContent;
		Util.addLis(Util.getEl('#ajhBtn')[0], 'click', jobObj.validateJobHours);
		Util.showToolTip();

	}else{
		Util.getEl('#job_content')[0].innerHTML = '';
	}
	
}


/* show add note area for selected job */
jobObj.showInfo4addJobNotes = function(){

	var select = Util.getEl('#ajn_job_name')[0];
	var job_name = select.options[select.selectedIndex].text;

	if(job_name !="Select an job"){
	
		var strBeg = '<div class="row form-group"><div class="col-5">';
		var strEnd = '</div></div>'
		var strDate = strBeg + '<label for="date">Date: <i data-toggle=\'popover\'></i></label><input type="date" class="form-control" id="date" name="date" placeHolder="mm/dd/yyyy">' + strEnd;         
        var strTitle = strBeg +'<label for="note_title">Note Title: <i data-toggle=\'popover\'></i></label><input type="text" class="form-control" id="note_title" name="note_title" value="">' + strEnd;
        var strNote = strBeg +'<label for="note">Note: <i data-toggle=\'popover\'></i></label><textarea class="form-control" rows="5" id="note" name="note" value=""></textarea>' + strEnd;
        var strBtn = '<button type="button" name="ajnBtn" class="btn btn-success" id="ajnBtn"> Add Job Notes </button>';
        Util.getEl('#job_content')[0].innerHTML = strDate + strTitle + strNote + strBtn;
        /*add listener to the Add Job Notes button */
        Util.addLis(Util.getEl('#ajnBtn')[0], 'click', jobObj.validateJobNote);
       
        /* for some reason I have to include the JQuery code to re-activate the tool-tip code again here to make the tool tip work */
        Util.showToolTip();

	}else{
		Util.getEl('#job_content')[0].innerHTML = '';
	}

}


jobObj.validateJob = function(){

	var i = 0, j = 0, inputs = Util.getEl('input[type="text"]'), obj;

	//clear all the label error messages
    Util.clearLabels();

    obj = [
    	{for: 'job_name', regex: 'general_name', msg: "Job Name cannot be blank and can only begin with Letters, and include numbers, spaces, single quotation marks and hyphens."},
    	{for: 'job_asset_folder', regex: 'ja_folder_name', msg: "Folder Name cannot be blank and can only include Letters, with spaces, single quotation marks and hyphens"}
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
   
	var select = Util.getEl('#aj_account_name')[0];
    var acc_id = {};
    acc_id.for = 'id'; 
    acc_id.value = select.options[select.selectedIndex].value;
    obj.unshift(acc_id); 

    var flag = {};
	flag.page = 'addJob';
    obj.unshift(flag);

    var data = JSON.stringify(obj);
	var phpFile = Util.getBasePath() + "xhr/val.php";
    //console.log("***" + obj[0]['page'] + "****" + obj[1]['for']);
    Util.sendRequest(phpFile, function(res){

		if(res.responseText == 'success'){			         
			    //need to pass obj insteadof data
				Util.addData(obj);			 					

		}else{
					    
			Util.displayError(JSON.parse(res.responseText));
		}
	}, data);

}

jobObj.validateJobAsset = function(){


	//the object to be deliver for validation through ajax
    var obj; 
    obj = [
		{for: 'asset_name', regex: 'asset_name', msg: "Asset Name cannot be blank and can only begin with Letters, can include other symbols"},
		{for: 'asset_file', regex: 'file', msg: "Please upload the asset file. File Size not bigger than 800KB and has to be PDF Format."}
	];

	//asset name
	var isFieldEmpty = false;
	var assetName = Util.getEl('#asset_name')[0].value.trim();
	var fileName = Util.getEl('#asset_file')[0].value.trim();
	
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
    var select = Util.getEl('#job_account_name')[0];
    var acc_id = {};
	acc_id.for = 'acc_id';
	acc_id.value = select.options[select.selectedIndex].value;
	obj.unshift(acc_id);

	var select = Util.getEl('#aja_job_name')[0];
    var job_id = {};
	job_id.for = 'job_id';
	job_id.value = select.options[select.selectedIndex].value;
	obj.unshift(job_id);

    //add page flag
	var flag = {};
	flag.page = 'addJobAsset';
	obj.unshift(flag);

	//stringify the data object
    var data = JSON.stringify(obj);

    //add data and file to FormData object
	var formdata = new FormData();
  	formdata.append('data',data);
  	formdata.append('file',Util.getEl('#asset_file')[0].files[0]);

  	var arr;
	var phpFile = Util.getBasePath() + "xhr/val.php";
	Util.sendRequest(phpFile, function(res){
         
		if(res.responseText == 'success'){
            
			jobObj.addJobAsset(formdata);
		}
		else{
			
			Util.displayError(JSON.parse(res.responseText));
		}
		
	},formdata,true); 
   
				
}


jobObj.validateJobHours = function(){

	var i = 0, j = 0, inputs = Util.getEl('input, textarea'), obj;
	//clear all the label error messages
    Util.clearLabels();
	obj = [
		{for: 'date', regex: 'date', msg: "Date cannot be empty and needs to be valid"},
		{for: 'hours', regex: 'hours', msg: "Hours cannot be blank and has to be valid hour."},
		{for: 'hourly_rate', regex: 'rate', msg: "Hourly rate cannot be blank must be numbers"},
		{for: 'desc', regex:'desc', msg: "Description can not be longer than 600 words"}
	];

	var valid = true;
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

	//add job id to Object
	var select = Util.getEl('#ajh_job_name')[0];
    var job_id = {};
	job_id.for = 'id';
	job_id.value = select.options[select.selectedIndex].value;
	obj.unshift(job_id);

	//add page flag to Object
	var flag = {};
    flag.page = 'addJobHours';
    obj.unshift(flag);

    var data = JSON.stringify(obj);
    var phpFile = Util.getBasePath() + "xhr/val.php";
	Util.sendRequest(phpFile, function(res){ 

		if(res.responseText == 'success'){
            
			Util.addData(obj);
			Util.getEl('#job_content')[0].innerHTML = '';
			var joblist = Util.getEl('#ajh_job_name')[0];
			Util.getEl('#job_account_name')[0].parentNode.removeChild(joblist);

		}
		else{
            
			Util.displayError(JSON.parse(res.responseText));
		}

	}, data);


}

jobObj.validateJobNote = function(){

	var i = 0, j = 0, inputs = Util.getEl('input, textarea'), obj;
	//clear all the label error messages
    Util.clearLabels();
	obj = [
		{for: 'date', regex: 'date', msg: "Date needs to be valid"},
		{for: 'note_title', regex: 'general_name', msg: "Title cannot be blank."},
		{for: 'note', regex:'note', msg: "Note can not be blank or longer than 600 words"}
	];
    
    //validate in the frontend.
    var valid = true;
	while(i < inputs.length){
		j = 0;
		while(j < obj.length){
			if(inputs[i].id == obj[j].for){
				obj[j].value = inputs[i].value.trim(); //removing the blanks at the front and the end
				if(obj[j].value == ''){
					obj[j].status = 'error';
					valid = false;
				}
				switch(obj[j].regex){
					case 'note': if(obj[j].value.split(" ").length > 600){obj[j].status = 'error'; valid= false;} break; 
				}
				break;
			}
			j++;
		}
		i++;
	}

	//add job id to Object
	var select = Util.getEl('#ajn_job_name')[0];
    var job_id = {};
	job_id.for = 'id';
	job_id.value = select.options[select.selectedIndex].value;
	obj.unshift(job_id);

    //add page flag to Object
	var flag = {};
    flag.page = 'addJobNote';
    obj.unshift(flag);

    if(valid){ 
    	Util.addData(obj);
    }else { 
    	Util.displayError(obj); 
    } 

}

jobObj.validate4Invoice = function(){

    //the object to be deliver for validation through ajax
    var i = 0, j = 0, inputs = Util.getEl('input[type="date"]'), obj;
    var select = Util.getEl('#pi_job_name')[0];
    var job_id = select.options[select.selectedIndex].value;

    //clear all the label error messages
    Util.clearLabels();

    obj = [
		{for: 'beg_date', regex: 'date', msg: "Date cannot be blank and has to be valid"},
		{for: 'end_date', regex: 'end_date', msg: "Date cannot be blank and needs to be valid and later than beginning date "}
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
	flag.page = 'printInvoice';
    obj.unshift(flag);

    var data = JSON.stringify(obj);
	var phpFile = Util.getBasePath() + "xhr/val.php";
    
    Util.sendRequest(phpFile, function(res){

		if(res.responseText == 'success'){	

		        //do another ajax call to validate if there is any job hour entry during the assign time
		        // if there is then go to invoice page
		        // if there isn't then pop out a msgbox 
		        var beg_date = obj[1]['value'];
		        var end_date = obj[2]['value'];

                var data2 = "getTable_Inv^^^" + job_id + "^^^" + beg_date + "^^^" + end_date;
		        var phpFile2 = Util.getBasePath() + "xhr/switch.php";
		        Util.sendRequest(phpFile2, function(res2){

                    if(res2.responseText == 'norecord'){

                    	var msgObj = {};
	                    msgObj.heading = { background: 'red', text: 'Error', color: 'white '};
						msgObj.body =	{text: 'There is no Job Data during the time you select. Please set another time range.' };
						msgObj.rightbtn = { background: 'red', color: 'white', text: 'OK', display:'block'};					
	                    Util.msgBox(msgObj);  
	                    Util.getEl('#rightbtn')[0].style.float = 'right';
	                    Util.addLis( Util.getEl('#rightbtn')[0], 'click', Util.closeMsgBox );   
                    }
                    else{
                    	localStorage.setItem("job_id", job_id);
					    localStorage.setItem("beg_date", Util.getEl('#beg_date')[0].value);
					    localStorage.setItem("end_date", Util.getEl('#end_date')[0].value);
					    var op_link = window.open('', '_blank');
						op_link.location = "invoice.php";		
                    }
		        }, data2);	         
			    
			   	 					

		}else{
					    
			Util.displayError(JSON.parse(res.responseText));
		}
	}, data);

}

jobObj.init();
