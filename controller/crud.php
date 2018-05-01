<?php

require_once( dirname(__FILE__). '/../includes/autoload.php' );

function addAssoci($dataStr){

	$idArr = explode("^^^", $dataStr);
	
    $account_id = $idArr[1];
    $job_id = $idArr[2];
    $contact_id = $idArr[3];
    
    //check if the association already exists
    $pdo = new DBHandler();
    $sql_select = "SELECT * FROM account_job_contact WHERE account_id = :account_id AND job_id = :job_id AND contact_id = :contact_id"; 
	$bindings = array(
		array(':account_id',$account_id,'int'),
		array(':job_id',$job_id,'int'),
		array(':contact_id',$contact_id,'int')
	);
	$result_select = $pdo->selectedBinded($sql_select, $bindings);

	if(count($result_select) == 0 ){
	    //add data into the database
		$pdo = new DBHandler();	    
		$sql_insert = "INSERT INTO account_job_contact (account_id, job_id, contact_id) VALUES (:account_id, :job_id, :contact_id)"; 		
		$result = $pdo->otherBinded($sql_insert, $bindings);

		if($result == 'noerror'){
			return 'success^^^'.checkAssociationInfo($contact_id);
		}
		else{
			return 'error^^^There was a problem adding the association';
		}
	}else{
		return 'error^^^This accociation already exists';
	} 
 
}


function addJobNote($dataObj){

	$data = [];
    $len = count($dataObj);
    
	for($i = 0; $i<$len; $i++){

			$data = array_merge($data, array( $dataObj[$i]['for']=>$dataObj[$i]['value']));

	}
	//print_r($data);

	$pdo = new DBHandler();
	    
	$sql = "INSERT INTO job_note (job_id, note_date, note_name, note) VALUES (:job_id, :note_date, :note_name, :note)";
    
	$bindings = array(
			array(':job_id',$data['id'],'int'),
			array(':note_date',$data['date'],'str'), //strtotime($data['date'])
			array(':note_name', $data['note_title'],'str'),
			array(':note',$data['note'],'str')
	);
		
	$result = $pdo->otherBinded($sql, $bindings);

	if($result == 'noerror'){
		return 'success';
	}
	else {
		return 'There was a problem adding the job';
	}
  
}

function addJobHours($dataObj){
	$data = [];
    $len = count($dataObj);
    
	for($i = 0; $i<$len; $i++){

			$data = array_merge($data, array( $dataObj[$i]['for']=>$dataObj[$i]['value']));

	}
    // print_r($data);
    // return 'success';

	$pdo = new DBHandler();
	    
	$sql = "INSERT INTO job_hour (job_id, job_date, hours,  hourly_rate, description) VALUES (:job_id, :job_date, :hours, :hourly_rate, :description)";
    
	$bindings = array(
			array(':job_id',$data['id'],'int'),
			array(':job_date',$data['date'],'str'),
			array(':hours',$data['hours'],'str'), 
			array(':hourly_rate', $data['hourly_rate'],'str'),
			array(':description',$data['desc'],'str')
	);
		
	$result = $pdo->otherBinded($sql, $bindings);

	if($result == 'noerror'){
		return 'success';
	}
	else {
		return 'There was a problem adding the job Hour';
	}
}


function checkJobHour($job_id){

    /* for the usort method later*/
	function date_sort($a,$b){
    	 return strtotime($a) - strtotime($b);
    }

    /* get all the records from the job_hour for the job*/
	$pdo = new DBHandler();
	$sql = "SELECT * FROM job_hour WHERE job_id = :job_id";
	$bindings = array(
		array(':job_id', $job_id, 'int')
	);	
    $records = $pdo->selectedBinded($sql, $bindings);  

    if($records != 'error'){

    	if(count($records) == 0 ){
    		return 'norecord^^^none';
	    }else{
             
            /* get the beginning  and ending date of all the job hour entries from table */ 
	    	$dateArr = [];
		    foreach($records as $row){
		        array_push($dateArr, $row['job_date']);
		    }
		    usort($dateArr, "date_sort");

		    $beg_date = $dateArr[0];
		    $end_date = $dateArr[count($dateArr) - 1];
		    
		    $beg_date = substr($beg_date, 0, strpos($beg_date, "00") -1);
		    $end_date = date("Y-m-d", strtotime($end_date));

	    	return 'record^^^'.$beg_date."^^^".$end_date;
	    }
    }else{
    	return 'there is an error checking the Job Hour';
    }


}

function updJobNote($dataObj){

	$data = [];
    $len = count($dataObj);
    
	for($i = 0; $i<$len; $i++){

			$data = array_merge($data, array( $dataObj[$i]['for']=>$dataObj[$i]['value']));

	}
	//print_r($data);

	$pdo = new DBHandler();
	   //"UPDATE contact SET name = :name, work_phone = :work_phone, mobile_phone = :mobile_phone, email =  :email WHERE id = :id"; 
	$sql = "UPDATE job_note SET note_date =:note_date, note_name = :note_name, note =:note WHERE id = :id";//note_date =:note_date,
    
	$bindings = array(
			array(':id',$data['id'],'int'),
			array(':note_date',$data['date'],'str'), 
			array(':note_name', $data['note_name'],'str'),
			array(':note',$data['note'],'str')
	);
		
	$result = $pdo->otherBinded($sql, $bindings);

	if($result == 'noerror'){
		return 'success';
	}
	else {
		return 'There was a problem updating the job note';
	}

}

function updJobHours($dataObj){

	$data = [];
    $len = count($dataObj);
    
	for($i = 0; $i<$len; $i++){

			$data = array_merge($data, array( $dataObj[$i]['for']=>$dataObj[$i]['value']));

	}

	$pdo = new DBHandler();
	$sql = "UPDATE job_hour SET job_date =:job_date, hours = :hours, hourly_rate =:hourly_rate, description = :description WHERE id = :id";
    
	$bindings = array(
			array(':id',$data['id'],'int'),
			array(':job_date',$data['date'],'str'), 
			array(':hours', $data['hours'],'str'),
			array(':hourly_rate',$data['rate'],'str'),
			array(':description',$data['desc'],'str')
	);
		
	$result = $pdo->otherBinded($sql, $bindings);

	if($result == 'noerror'){
		return 'success';
	}
	else {
		return 'There was a problem updating the job hour';
	}

}


function addJob($dataObj){

    $data = [];
    $account_folder;
    $len = count($dataObj);
    
	for($i = 0; $i<$len; $i++){

			$data = array_merge($data, array( $dataObj[$i]['for']=>$dataObj[$i]['value']));

	}
	//print_r($data);
	//get the current path and the account folder then create the job folder
	$pdo = new DBHandler();
	$sql = "SELECT * FROM account WHERE id = :id";
	$bindings = array(
		array(':id', $data['id'],'int'),
	);
	$records = $pdo->selectedBinded($sql, $bindings);
 
	if($records == 'error'){
		return 'There has been and error processing your request';
	}else{
		if(count($records) != 0){
			$account_folder = $records[0]['folder'];
		}
		else {
			return 'Please Select an Account';
		}
	}	

	$PageData = new PageData();
	$dir = getcwd() . $PageData->uploadFolder . $account_folder;
	/* 
     Modify the current umask, set it temporarily to zero so it has no effect,
     then after create the directory set it back to what it was
     This makes sure that the created account folder has the permission for uploading file.
	*/
	$oldmask = umask(0);
	$success= mkdir($dir . "/". $data['job_asset_folder'], 0777);
	umask($oldmask);
   
    if($success) {

		//make a index.php file silently disable the folder-browsing
			$txt = <<<TXT
			<?php
			//Slience is Golden;
		    ?>
TXT;
		    $indexFile = fopen($dir . "/". $data['job_asset_folder'].'/index.php', 'w');
		    fwrite($indexFile, $txt);
		    fclose($indexFile);
		
        //add data into the database
		$pdo = new DBHandler();
	    
		$sql = "INSERT INTO job (account_id, name, asset_folder) VALUES (:account_id, :name, :asset_folder)";
    
	    $bindings = array(
			array(':account_id',$data['id'],'int'),
			array(':name',$data['job_name'],'str'),
			array(':asset_folder',$data['job_asset_folder'],'str')
		);
		
		$result = $pdo->otherBinded($sql, $bindings);

		if($result == 'noerror' && $success){
			return 'success';
		}
		else {
			return 'There was a problem adding the job';
		}
    }
    else{
    	return 'There was a problem adding the job with this folder name.';
    }

}

function addContact($dataObj){

	$data = [];
    
    $len = count($dataObj);
    
	for($i = 0; $i<$len; $i++){

			$data = array_merge($data, array( $dataObj[$i]['for']=>$dataObj[$i]['value']));

	}

    //add data into the database
	$pdo = new DBHandler();
	    
	$sql = "INSERT INTO contact(name, work_phone, mobile_phone, email) VALUES (:name, :work_phone, :mobile_phone, :email)";
    
	    $bindings = array(
			array(':name',$data['name'],'str'),
			array(':work_phone',$data['work_phone'],'str'),
			array(':mobile_phone',$data['mobile_phone'],'str'),
			array(':email',$data['email'],'str')
		);
		
		$result = $pdo->otherBinded($sql, $bindings);

		if($result == 'noerror'){
			return 'success';
		}
		else {
			return 'There was a problem adding the contact';
		}
}


function addAccount($dataObj){

    $data = [];
    
    $len = count($dataObj);
    
	for($i = 0; $i<$len; $i++){

			$data = array_merge($data, array( $dataObj[$i]['for']=>$dataObj[$i]['value']));

	}
	//get the current path and create the folder
	$PageData = new PageData();
	$dir = getcwd() . $PageData->uploadFolder;
	/* 
     Modify the current umask, set it temporarily to zero so it has no effect,
     then after create the directory set it back to what it was
     This makes sure that the created account folder has the permission for uploading file.
	*/
	$oldmask = umask(0);
	$success= mkdir($dir . $data['account_folder'], 0777);
	umask($oldmask);

	if($success) {

		//make a index.php file silently disable the folder-browsing
			$txt = <<<TXT
			<?php
			//Slience is Golden;
		    ?>
TXT;
		    $indexFile = fopen($dir .$data['account_folder'].'/index.php', 'w');
		    fwrite($indexFile, $txt);
		    fclose($indexFile);
		
        //add data into the database
		$pdo = new DBHandler();
	    
		$sql = "INSERT INTO account (name, address, state, city, zip, folder) VALUES (:name, :address, :state, :city, :zip, :folder)";
    
	    $bindings = array(
			array(':name',$data['name'],'str'),
			array(':address',$data['address'],'str'),
			array(':state',$data['state'],'str'),
			array(':city',$data['city'],'str'),
			array(':zip',$data['zip'],'str'),
			array(':folder',$data['account_folder'],'str')
		);
		
		$result = $pdo->otherBinded($sql, $bindings);

		if($result == 'noerror' && $success){
			return 'success';
		}
		else {
			return 'There was a problem updating the account';
		}
    }
    else{
    	return 'There was a problem updating the account with this folder name.';
    }
	  
	
}

function delJobAsset($asset_id){

	$job_id = 0; $path ='';
    //get job_id and file path
    $pdo = new DBHandler();
	$sql = "SELECT * FROM job_asset WHERE id = :id";
	$bindings = array(
		array(':id', $asset_id, 'int')
	);
	$records = $pdo->selectedBinded($sql, $bindings);
	
	if($records != 'error'){
		
		$job_id = $records[0]['job_id'];
		$path = $records[0]['file'];

	}
	else {
		return 'error^^^There was a problem deleting the asset';
	} 

	//get the rigth fromat of the file path then delete file from server, 
	$pos = strpos($path, '..');
    $path = substr($path, $pos, strlen($path));
    
	//delete record from table
	if(unlink($path)){
		 
		//delete asset from the database
		$pdo = new DBHandler();
		$sql = "DELETE FROM job_asset WHERE id = :id";
		$bindings = array(
			array(':id', $asset_id, 'int')
		);
		$result = $pdo->otherBinded($sql, $bindings);
		if($result == 'noerror'){
			return 'success^^^'.showJobAssetTable($job_id);
		}
		else {
			return 'error^^^There was a problem deleting the asset';
		} 

	}
	else{
		return 'error^^^There was a problem deleting the asset file';
	}


}

function delAccAsset($dataObj){

	//remove asset from the folder first using unlink()
    $path = $dataObj['file'];
    //get the right file path 
    $pos = strpos($path, '..');
    $path = substr($path, $pos, strlen($path));

    if(unlink($path)){
		 
		//delete asset from the database
		$pdo = new DBHandler();
		$sql = "DELETE FROM account_asset WHERE id = :id";
		$bindings = array(
			array(':id',$dataObj['id'],'int')
		);
		$result = $pdo->otherBinded($sql, $bindings);
		if($result == 'noerror'){
			return 'success^^^'. getAccAsset($dataObj['acc_id']);
		}
		else {
			return 'error^^^There was a problem deleting the asset';
		} 

	}
	else{
		return 'error^^^There was a problem deleting the asset file';
	}
}

function showInfo4vdAccAsset($dataObj){

    $acc_id = $dataObj['id'];
    return getAccAsset($acc_id);			

}

function getAccAsset($acc_id){
    
	$pdo = new DBHandler();

	$sql = "SELECT * FROM account_asset WHERE account_id = :account_id";
	$bindings = array(
				array(':account_id', $acc_id,'int'),
			);
	$records = $pdo->selectedBinded($sql, $bindings);
 
	if($records == 'error'){
		return 'There has been and error processing your request';
	}
 
	else{
		if(count($records) != 0){
			return createAccAssetTable($records);
			
		}
		else {
			return '<p>There is no asset in this account.</p>';
		}
	}		
}

function createAccAssetTable($records){

	$table = <<<STR
	<table class="table table-striped table-bordered" id="assetList">
		<thead>
			<tr>
				<th>Name</th>
				<th>Delete</th>
			</tr>
		</thead>
	    <tbody>
STR;
    
    $PageData = new PageData();
    $basePath = $PageData->basePath;

	foreach ($records as $row){
		$table .= '<tr>';
		$table .= "<td><a href=\"{$basePath}{$row['file']}\" target=\"_blank\">{$row['name']}</a></td>";
		$table .= "<td><input type='button' class='btn btn-danger' id='asset{$row['id']}' value='Delete'></td>";
		$table .= '</tr>';
	}
	$table .= '</tbody></table>';
	return $table;
}

function addAdmin($dataObj){

	//print_r($dataObj);
    
    $pdo = new DBHandler();
    $sql = "SELECT email FROM admin WHERE email = :email";
	$bindings = array(
		array(':email', $dataObj['email'], 'str')
	);

    $records = $pdo->selectedBinded($sql, $bindings);

	/** IF THERE WAS AN RETURN ERROR STRING */
	if($records == 'error'){
		return 'error';
	}
	
	/** CHECK FOR A DUPLICATE USERNAME IF FOUND THEN RETURN DUPLICATE OTHERWISE ADD USERNAME AND PASSWORD TO DATABASE */
	else{
		if(count($records) != 0){
            return "duplicate";
		}
		else {
			/** ENCRYPT THE PASSWORD USING PASSWORD_HASH */
			$dataObj['password'] = password_hash($dataObj['password'], PASSWORD_DEFAULT);
			$sql = "INSERT INTO admin (email, password) VALUES (:email, :password)";
			$bindings = array(
				array(':email',$dataObj['email'],'str'),
				array(':password',$dataObj['password'],'str')
			);
			$result = $pdo->otherBinded($sql, $bindings);
			if($result == 'noerror'){
				return 'added';
			}
			else {
				return 'error';
			}
		}
	}
}

function addJobAsset($data, $file){

	//print_r($data);

	/*
		Array ( 
			[0] => Array ( 
				[for] => job_id 
				[value] => 1 ) 
			[1] => Array ( 
				[for] => acc_id 
				[value] => 8 ) 
			[2] => Array ( 
				[for] => asset_name 
				[regex] => asset_name 
				[msg] => Asset Name cannot be blank and can only begin with Letters, can include other symbols 
				[value] => asset ) 
			[3] => Array ( 
				[for] => asset_file 
				[regex] => file 
				[msg] => Please upload the asset file. File Size not bigger than 800KB and has to be PDF Format. 
				) 
		)

	*/

    $job_id = $data[0]['value'];
	$account_id = $data[1]['value'];	
	$asset_name = $data[2]['value'];

    $accFolder = getAccountFolder($account_id);
    $jobFolder = getJobFolder($job_id);
    $folder = $accFolder . '/' . $jobFolder;

    $uID = md5(time());
    $ext_pos = strrpos( $file['name'], '.'); 
    $new_file_name = substr($file['name'], 0, $ext_pos) . '_'. $uID . substr($file['name'], $ext_pos);
    //then move the temp file to the right folder
    $PageData = new PageData();
    $upFolder = $PageData->uploadFolder;
    
    $modifiedPath = substr($upFolder, 1, strlen($upFolder));
	$upload = move_uploaded_file($file['tmp_name'], $modifiedPath.$folder.'/'.$new_file_name);

    $path = $upFolder . $folder.'/'.$new_file_name;
    //store the job id and asset name and path in database
    if($upload){

        $pdo = new DBHandler();
	    
		$sql = "INSERT INTO job_asset (job_id, name, file) VALUES (:job_id, :name, :file)";
    
	    $bindings = array(
			array(':job_id',$job_id,'int'),
			array(':name',$asset_name,'str'),
			array(':file',$path,'str')
		);
		
		$result = $pdo->otherBinded($sql, $bindings);

		if($result == 'noerror'){
			return 'success';
		}
		else {
			return 'There was a problem adding the job asset';
		}
    }
    else{
    	return 'There is an error uploading the file.';
    }
	
}

function getAccountFolder($account_id){

	//using the account id to find the account folder name first
    $folder ='';
    $pdo = new DBHandler();
	$sql = "SELECT folder FROM account WHERE id = :id";
	$bindings = array(
		array(':id', $account_id, 'int'),
	);
	$records = $pdo->selectedBinded($sql, $bindings);
    if($records == 'error'){
		return 'There has been an error getting the account folder.';
	}
	else{
		if(count($records) != 0){
			 
			$arr = $records[0];
			$folder= $arr['folder'];
		}
		else{
			return 'Please select an account!';
		}
	}
	return $folder;
}

function getJobFolder($job_id){

	//using the job id to find the job asset folder name 
    $folder ='';
    $pdo = new DBHandler();
	$sql = "SELECT asset_folder FROM job WHERE id = :id";
	$bindings = array(
		array(':id', $job_id, 'int'),
	);
	$records = $pdo->selectedBinded($sql, $bindings);
    if($records == 'error'){
		return 'There has been an error getting the account folder.';
	}
	else{
		if(count($records) != 0){
			 
			$arr = $records[0];
			$folder= $arr['asset_folder'];
		}
		else{
			return 'Please select an account!';
		}
	}
	return $folder;
}

function addAccAsset($data, $file){

	//print_r($data);

	/*
		Array ( 
		  [0] => Array ( 
		    [for] => id 
		    [value] => 4 
		    ) 
		  [1] => Array ( 
		    [for] => asset_name 
		    [regex] => asset_name 
		    [msg] => Asset Name cannot be blank and can only begin with Letters, can include other symbols 
		    [value] => test Asset ) 
		  [2] => Array ( 
		    [for] => asset_file 
		    [regex] => file 
		    [msg] => Please upload the asset file. File Size not bigger than 800KB and has to be PDF Format. ) 
		    ) 
	*/

	$id = $data[0]['value'];
	$asset_name = $data[1]['value'];
    //using the account id to find the account folder name first
    $folder ='';
    $pdo = new DBHandler();
	$sql = "SELECT folder FROM account WHERE id = :id";
	$bindings = array(
		array(':id', $id, 'int'),
	);
	$records = $pdo->selectedBinded($sql, $bindings);
    if($records == 'error'){
		return 'There has been an error getting the account folder.';
	}
	else{
		if(count($records) != 0){
			 
			$arr = $records[0];
			$folder= $arr['folder'];
		}
		else{
			return 'Please select an account!';
		}
	}
    
    $uID = md5(time());
    $ext_pos = strrpos( $file['name'], '.'); 
    $new_file_name = substr($file['name'], 0, $ext_pos) . '_'. $uID . substr($file['name'], $ext_pos);
    //then move the temp file to the right folder
    $PageData = new PageData();
    $upFolder = $PageData->uploadFolder;
    //$upload = move_uploaded_file($file['tmp_name'], $PageData->uploadFolder. $folder.'/'.$new_file_name);
    $modifiedPath = substr($upFolder, 1, strlen($upFolder));
	$upload = move_uploaded_file($file['tmp_name'], $modifiedPath.$folder.'/'.$new_file_name);

    $path = $upFolder . $folder.'/'.$new_file_name;
	//store the account id and asset name and path in database
    if($upload){

       $pdo = new DBHandler();
	    
		$sql = "INSERT INTO account_asset (account_id, name, file) VALUES (:account_id, :name, :file)";
    
	    $bindings = array(
			array(':account_id',$id,'int'),
			array(':name',$asset_name,'str'),
			array(':file',$path,'str')
		);
		
		$result = $pdo->otherBinded($sql, $bindings);

		if($result == 'noerror'){
			return 'success';
		}
		else {
			return 'There was a problem adding the asset';
		}
    }
    else{
    	return 'There is an error uploading the file.';
    }
	 
}

function updAccount($dataObj){

    $PageData = new PageData();
    $dir = getcwd() . $PageData->uploadFolder;

	$data = [];
    $len = count($dataObj);
    
    for($i = 0; $i<$len; $i++){

			$data = array_merge($data, array( $dataObj[$i]['for']=>$dataObj[$i]['value']));
	}
	
    //check if the folder has a new name, if it doesn't, then go ahead update, if it does than rename the folder
	$pdo = new DBHandler();
	$sql = "SELECT folder FROM account WHERE id = :id";
	$bindings = array(
		array(':id', $data['id'], 'int'),
	);
	$records = $pdo->selectedBinded($sql, $bindings);

	if($records == 'error'){
		return 'There has been an error getting the account folder.';
	}
	else{
		
		$arr = $records[0];
		$folder= $arr['folder'];
        if($folder == $data['account_folder']){
        	
        	return update_account($data);
        }else{
            // before rename the folder we need to check if the new name is already taken by other account??

            $success = rename($dir.$folder, $dir.$data['account_folder'] );
            if($success){    
			     
			     return update_account($data);

			  }
			  else{
			    return "There was a problem renaming the directory.";
			  }

        }
		 
	}
	
}

function updContact($dataObj){

	$data = [];
    $len = count($dataObj);
   
    for($i = 0; $i<$len; $i++){

			$data = array_merge($data, array( $dataObj[$i]['for']=>$dataObj[$i]['value']));
	}

	$pdo = new DBHandler();
	$sql = "UPDATE contact SET name = :name, work_phone = :work_phone, mobile_phone = :mobile_phone, email =  :email WHERE id = :id";
	$bindings = array(
		array(':name',$data['name'],'str'),
		array(':work_phone',$data['work_phone'],'str'),
		array(':mobile_phone',$data['mobile_phone'],'str'),
		array(':email',$data['email'],'str'),
		array(':id', $data['id'], 'int')
	);
	$result = $pdo->otherBinded($sql, $bindings);
	
	if($result == 'noerror'){
		return 'success';
	}
	else {
		return 'There was a problem updating the contact';
	}
}

function update_account($data){
    //echo($data['id']. "****" . $data['name']);  
	$pdo = new DBHandler();
	$sql = "UPDATE account SET name = :name, address = :address, state = :state, city =  :city, zip = :zip, folder = :folder  WHERE id = :id";

	$bindings = array(
			array(':name',$data['name'],'str'),
			array(':address',$data['address'],'str'),
			array(':state',$data['state'],'str'),
			array(':city',$data['city'],'str'),
			array(':zip',$data['zip'],'str'),
			array(':folder',$data['account_folder'],'str'),
			array(':id',$data['id'],'int')
		);
	$result = $pdo->otherBinded($sql, $bindings);
	if($result == 'noerror'){
		return 'success';
	}
	else {
		return 'There was a problem updating the account';
	}

}


function checkAssociationInfo($contact_id){

	$pdo = new DBHandler();
	$sql = "SELECT ajc.id as associ_id, ajc.account_id, ajc.job_id, a.name as account_name, j.name as job_name  FROM account_job_contact ajc, account a, job j WHERE ajc.contact_id= :contact_id AND ajc.account_id = a.id AND ajc.job_id = j.id";
	$bindings = array(
		array(':contact_id', $contact_id, 'int'),
	);
	$records = $pdo->selectedBinded($sql, $bindings);
	if(count($records)==0){
		return '<p>There is not any association for this contact.</p>';
	}else{

		return createAssociTable($records);
	}
	
}

function createAssociTable($records){

	$tableContent = <<<STR
	<thead>
	   <tr><th> Account </th><th> Job </th><th> Delete </th>
	</thead>
	<tbody>
STR;
   foreach ($records as $row){
   		$tableContent .= "<tr>";
        $tableContent .= "<td>{$row['account_name']}</td>";
        $tableContent .= "<td>{$row['job_name']}</td>";
        $tableContent .= '<td><input type="button" name="delAssociBtn" id="'.$row['associ_id'].'" class="btn btn-danger" value="Delete" </td>';
        $tableContent .= "</tr>";
   }
    $tableContent .= "</tbody>";
   return $tableContent;

} 

/* $dataStr is like flag^^^" + job_id + "^^^" + beg_date + "^^^" + end_date; */
function getInvoice($dataStr){

	$idArr = explode("^^^", $dataStr);
	
    $job_id = $idArr[1];
    $beg_date = $idArr[2];
    $end_date = $idArr[3];

	$pdo = new DBHandler();
	$sql = "SELECT * FROM job_hour WHERE job_id = :job_id AND job_date BETWEEN CAST(:beg_date AS DATE) AND CAST(:end_date AS DATE) ORDER BY job_date";
	$bindings = array(
		array(':job_id', $job_id, 'int'),
		array(':beg_date', $beg_date, 'str'),
		array(':end_date', $end_date, 'str')
	);
	$records = $pdo->selectedBinded($sql, $bindings);
    
    if($records != 'error'){
    	if(count($records) != 0){
    		return createInvTable($records);
    	}else{
    		return 'norecord';
    	}
    	
    }else{
    	return 'error';
    }
}

function createInvTable($records){

	$table = <<<STR
            <table class="table table-striped table-bordered">
		        <thead>
		          <th>Date</th>
		          <th>Description</th>
		          <th>Hours</th>
		          <th>Hourly Rate</th>
		          <th>Total</th>
		        </thead>
                <tbody>

STR;
	
    $total = 0;
	foreach($records as $row){
		$sub_total = $row['hours'] * $row['hourly_rate'];
		$total += $sub_total;
    	$table .= "<tr>";
    	//clean the tail part( 00:00:00) of the data value
    	$date = $row['job_date'];
    	$date = substr($date, 0, strpos($date, "00")-1);
        $table .= '<td>'.$date.'</td>';
        $table .= '<td>'. $row['description'].'</td>';
        $table .= '<td>'. $row['hours'].'</td>';
        $table .= '<td>'. $row['hourly_rate'].'</td>';
        $table .= '<td>$'.$sub_total.'</td>';
        $table .= "</tr>";
    }

    $table .= '<tr><td colspan="4" style="text-align: right; font-weight: bold;">Grand Total</td>';
    $table .= "<td>$". $total."</td>";
    $table .= "</tr>";
    $table .= "</tbody></table></div>";
    return $table;
}

function getTitle4Invoice($job_id){

	$pdo = new DBHandler();
	$sql = "SELECT DISTINCT a.name, a.address, a.city, a.state, a.zip FROM job j INNER JOIN account a ON j.id = :id AND j.account_id = a.id";
	$bindings = array(
		array(':id', $job_id, 'int'),
	);
	$records = $pdo->selectedBinded($sql, $bindings);
    $account_name = $records[0]['name'];
    $account_add = $records[0]['address'];
    $account_city = $records[0]['city'];
    $account_state =$records[0]['state'];
    $account_zip = $records[0]['zip'];

    $pdo = new DBHandler();
	$sql = "SELECT DISTINCT j.name FROM job_hour jh INNER JOIN job j ON jh.job_id = :id AND jh.job_id = j.id";
	$bindings = array(
		array(':id', $job_id, 'int'),
	);
    $records2 = $pdo->selectedBinded($sql, $bindings);
    $job_name = $records2[0]['name'];

    return $account_name. "^^^" . $job_name. "^^^" . $account_add. "^^^". $account_city. "^^^". $account_state."^^^". $account_zip;

}

 
function getAccountInfo($account_id){
    
	$pdo = new DBHandler();
	$sql = "SELECT * FROM account WHERE id = :id";
	$bindings = array(
		array(':id', $account_id, 'int'),
	);
	$records = $pdo->selectedBinded($sql, $bindings);
	if($records == 'error'){
		return 'There has been an error showing the account detail.';
	}
	else{
		 
		$arr = $records[0];
		$data = $arr['name']."^^^".$arr['address']."^^^".$arr['state']."^^^".$arr['city']."^^^".$arr['zip']."^^^".$arr['folder']."^^^".$arr['id'];
		return $data;
	}


}

function getContactInfo($contact_id){

	$pdo = new DBHandler();
	$sql = "SELECT * FROM contact WHERE id = :id";
	$bindings = array(
		array(':id', $contact_id, 'int'),
	);
	$records = $pdo->selectedBinded($sql, $bindings);
	if($records == 'error'){
		return 'There has been an error showing the contact detail.';
	}
	else{
			 
		$arr = $records[0];
		$data = $arr['name']."^^^".$arr['work_phone']."^^^".$arr['mobile_phone']."^^^".$arr['email']."^^^".$arr['id'];
		return $data;
	}


}

function showJobList($account_id){

	   $pdo = new DBHandler();
       $sql = "SELECT id, name FROM job WHERE account_id = :account_id";
       $bindings = array(
          array(':account_id', $account_id, 'int'),
        );
       $records = $pdo->selectedBinded($sql, $bindings);

       if($records == 'error'){
              return '<option>There was a problem getting the job list</option>';
       }
       else {
       	  if(count($records) == 0){
       	  	 return 'norecord';
       	  }
       	  else{
       	  	$PageData = new PageData();
       	  	return $PageData->createSelectList($records,'job');
       	  }
          
       }    
}

/* $dataStr has data: flag^^^account_id^^^job_id */
function showContactTable($dataStr){ //4ViewJobContact

	$idArr = explode("^^^", $dataStr);
	
    $account_id = $idArr[1];
    $job_id = $idArr[2];

    $pdo = new DBHandler();
	$sql = "SELECT c.name, c.work_phone, c.mobile_phone, c.email FROM account_job_contact ajc INNER JOIN contact c ON ajc.account_id = :account_id AND ajc.job_id =:job_id AND ajc.contact_id = c.id";
	$bindings = array(
		array(':account_id', $account_id, 'int'),
		array(':job_id', $job_id, 'int')
	); 
	$records = $pdo->selectedBinded($sql, $bindings); 

	if(count($records)==0){
		return 'norecord'; //There is no contact associate with this job in this account.';
	}else{
		return createContactTable4ViewContact($records);
	}
    
}

function createContactTable4ViewContact($records){

	$tableContent = <<<STR
	<thead>
	   <tr><th> Name </th><th> Email </th><th> Work Phone </th><th> Mobile Phone </th>
	</thead>
	<tbody>
STR;
   
    for($i=0; $i<count($records); $i++){
   		$tableContent .= "<tr>";
        $tableContent .= "<td>{$records[$i]['name']}</td>";
        $tableContent .= "<td>{$records[$i]['email']}</td>";
        $tableContent .= "<td>{$records[$i]['work_phone']}</td>";
        $tableContent .= "<td>{$records[$i]['mobile_phone']}</td>";    
        $tableContent .= "</tr>";
   }
    $tableContent .= "</tbody>";
   return $tableContent;
}

function delContact($contact_id){
    
    /* delete from the contact table */
	$pdo = new DBHandler();
	$sql = "DELETE FROM contact WHERE id = :id";
	$bindings = array(
		array(':id',$contact_id,'int')
	);
	$result1 = $pdo->otherBinded($sql, $bindings);

    /* delete from the association table */
	$pdo = new DBHandler();
	$sql = "DELETE FROM account_job_contact WHERE contact_id = :id";
	$bindings = array(
		array(':id',$contact_id,'int')
	);
	$result2 = $pdo->otherBinded($sql, $bindings);

	if($result1 == 'noerror' and $result2 == 'noerror'){
		$PageData = new PageData();
		return 'success^^^'.$PageData->showContactTable();
	}
	else {
		return 'error^^^There was a problem deleting the contact';
	} 
}

/* $dataStr has format flag^^^associ_id^^^contact_id */
/* associ_id is used for delete the association */
/* contact_id is used for show the table after delete */
function delContactAssoci($dataStr){

	$idArr = explode("^^^", $dataStr);
	
	$associ_id = $idArr[1];
    $contact_id = $idArr[2];

	 /* delete from the association table */
	$pdo = new DBHandler();
	$sql = "DELETE FROM account_job_contact WHERE id = :id";
	$bindings = array(
		array(':id', $associ_id, 'int')
	);
	$result = $pdo->otherBinded($sql, $bindings);

	if($result == 'noerror'){
		return 'success^^^'.checkAssociationInfo($contact_id);
	}
	else {
		return 'error^^^There was a problem deleting the contact';
	} 

}

function delJobNote($dataStr){

	$idArr = explode("^^^", $dataStr);
	
	$jobnote_id = $idArr[1];
    $account_id = $idArr[2];
    $job_id = $idArr[3];

	$pdo = new DBHandler();
	$sql = "DELETE FROM job_note WHERE id = :id";
	$bindings = array(
		array(':id',$jobnote_id,'int')
	);
	$result = $pdo->otherBinded($sql, $bindings);

	if($result == 'noerror'){
		//$PageData = new PageData();
		return 'success^^^'.showJobNoteTable('flag^^^'.$account_id."^^^".$job_id);
	}
	else {
		return 'error^^^There was a problem deleting the Job Note';
	} 

}


function delJobHour($dataStr){

	$idArr = explode("^^^", $dataStr);
	
	$jobhour_id = $idArr[1];
    $account_id = $idArr[2];
    $job_id = $idArr[3];

	$pdo = new DBHandler();
	$sql = "DELETE FROM job_hour WHERE id = :id";
	$bindings = array(
		array(':id',$jobhour_id,'int')
	);
	$result = $pdo->otherBinded($sql, $bindings);

	if($result == 'noerror'){
		//$PageData = new PageData();
		return 'success^^^'.showJobHourTable('flag^^^'.$account_id."^^^".$job_id);
	}
	else {
		return 'error^^^There was a problem deleting the Job Note';
	} 

}

function showJobAssetTable($job_id){

	$pdo = new DBHandler();
	$sql = "SELECT * FROM job_asset WHERE job_id = :job_id";
	$bindings = array(
		array(':job_id', $job_id, 'int')
	); 
	$records = $pdo->selectedBinded($sql, $bindings); 

	if(count($records)==0){
		return 'norecord'; //There is no contact associate with this job in this account.';
	}else{
		return createJobAssetTable($records);
	}

}

function createJobAssetTable($records){

	$table = <<<STR
	<table class="table table-striped table-bordered" id="">
		<thead>
			<tr>
				<th>Name</th>
				<th>Delete</th>
			</tr>
		</thead>
	    <tbody>
STR;
    
    $PageData = new PageData();
    $basePath = $PageData->basePath;

	foreach ($records as $row){
		$table .= '<tr>';
		$table .= "<td><a href=\"{$basePath}{$row['file']}\" target=\"_blank\">{$row['name']}</a></td>";
		$table .= "<td><input type='button' class='btn btn-danger' id='{$row['id']}' value='Delete'></td>";
		$table .= '</tr>';
	}
	$table .= '</tbody></table>';
	return $table;
}

/* $dataStr has data: flag^^^account_id^^^job_id */
function showJobHourTable($dataStr){

	$idArr = explode("^^^", $dataStr);
	
    $account_id = $idArr[1];
    $job_id = $idArr[2];

    $pdo = new DBHandler();
	$sql = "SELECT jh.id, jh.job_date, jh.hours, jh.hourly_rate, jh.description FROM job j INNER JOIN job_hour jh ON j.account_id = :account_id AND j.id =:job_id AND j.id = jh.job_id ORDER BY jh.job_date";
	$bindings = array(
		array(':account_id', $account_id, 'int'),
		array(':job_id', $job_id, 'int')
	); 
	$records = $pdo->selectedBinded($sql, $bindings); 

	if(count($records)==0){
		return 'norecord'; //There is no contact associate with this job in this account.';
	}else{
		return createJobHourTable($records);		
	}

}

function createJobHourTable($records){

	$table = <<<STR
            <div class="row col-12">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Hours</th>
                      <th>Rate</th>
                      <th>Description</th>
                      <th>Update</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>

STR;
	
    //for($i=0; $i<count($records); $i++){
	foreach($records as $row){
    	$table .= "<tr>";
    	//clean the tail part( 00:00:00) of the data value
    	$date = $row['job_date'];
    	$date = substr($date, 0, strpos($date, "00")-1);
        $table .= '<td><input type="date" class="form-control" id="date" name="date" value="'.$date. '"></td>';
        $table .= '<td><input type="text" class="form-control" id="hours" name="hours" value ="'. $row['hours'].'"></td>';
        $table .= '<td><input type="text" class="form-control" id="rate" name="rate" value="'. $row['hourly_rate'].'"></td>';
        $table .= '<td><textarea id="desc" name="desc">'. $row['description']. '</textarea></td>';
        $table .= '<td><input type="button" name="updJobHour" id="'. $row['id'].'" class="btn btn-success" value="Update"</td>';
        $table .= '<td><input type="button" name="delJobHour" id="'. $row['id']. '" class="btn btn-danger" value="Delete"</td>';
        $table .= "</tr>";
    }

    $table .= "</tbody></table></div>";
    return $table;


}

/* $dataStr has data: flag^^^account_id^^^job_id */
function showJobNoteTable($dataStr){

	$idArr = explode("^^^", $dataStr);
	
    $account_id = $idArr[1];
    $job_id = $idArr[2];

    $pdo = new DBHandler();
	$sql = "SELECT jn.id, jn.note_date, jn.note_name, jn.note FROM job j INNER JOIN job_note jn ON j.account_id = :account_id AND j.id =:job_id AND j.id = jn.job_id";
	$bindings = array(
		array(':account_id', $account_id, 'int'),
		array(':job_id', $job_id, 'int')
	); 
	$records = $pdo->selectedBinded($sql, $bindings); 

	if(count($records)==0){
		return 'norecord'; //There is no contact associate with this job in this account.';
	}else{
		return createJobNoteTable($records);
	}

}

function createJobNoteTable($records){

	$table = <<<STR
            <div class="row col-12">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Note Name</th>
                      <th>Note</th>
                      <th>Update</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>

STR;
	
    //for($i=0; $i<count($records); $i++){
	foreach($records as $row){
    	$table .= "<tr>";
    	//clean the tail part( 00:00:00) of the data value
    	$date = $row['note_date'];
    	$date = substr($date, 0, strpos($date, "00")-1);
        $table .= '<td><input type="date" class="form-control" id="date" name="date" value="'.$date. '"</td>';
        $table .= '<td><input type="text" class="form-control" id="note_name" name="note_name" value="'.$row['note_name'].'"</td>';
        $table .= '<td><textarea id="note" name="desc" cols="70" rows=6>'.$row['note'].'</textarea></td>';
        $table .= '<td><input type="button" name="updJobNote" id="'. $row['id'].'" class="btn btn-success" value="Update"</td>';
        $table .= '<td><input type="button" name="delJobNote" id="'. $row['id']. '" class="btn btn-danger" value="Delete"</td>';
        $table .= "</tr>";
    }

    $table .= "</tbody></table></div>";
    return $table;
}



//<td><button type="button" name="delAssociBtn" id="'.$row['associ_id'].'" class="btn btn-danger"> Delete </button> </td>'