<?php

//require_once(dirname(__FILE__). '/../controller/crud.php')
require_once 'DBHandler.php';
require_once 'PageData.php';

class Validation{
    
	private $error = false;
	private $usStates = array( 
	  	array( "name"=> 'ALABAMA', "abbreviation"=> 'AL'),
	    array( "name"=> 'ALASKA', "abbreviation"=> 'AK'),
	    array( "name"=> 'AMERICAN SAMOA', "abbreviation"=> 'AS'),
	    array( "name"=> 'ARIZONA', "abbreviation"=> 'AZ'),
	    array( "name"=> 'ARKANSAS', "abbreviation"=> 'AR'),
	    array( "name"=> 'CALIFORNIA', "abbreviation"=> 'CA'),
	    array( "name"=> 'COLORADO', "abbreviation"=> 'CO'),
	    array( "name"=> 'CONNECTICUT', "abbreviation"=> 'CT'),
	    array( "name"=> 'DELAWARE', "abbreviation"=> 'DE'),
	    array( "name"=> 'DISTRICT OF COLUMBIA', "abbreviation"=> 'DC'),
	    array( "name"=> 'FEDERATED STATES OF MICRONESIA', "abbreviation"=> 'FM'),
	    array( "name"=> 'FLORIDA', "abbreviation"=> 'FL'),
	    array( "name"=> 'GEORGIA', "abbreviation"=> 'GA'),
	    array( "name"=> 'GUAM', "abbreviation"=> 'GU'),
	    array( "name"=> 'HAWAII', "abbreviation"=> 'HI'),
	    array( "name"=> 'IDAHO', "abbreviation"=> 'ID'),
	    array( "name"=> 'ILLINOIS', "abbreviation"=> 'IL'),
	    array( "name"=> 'INDIANA', "abbreviation"=> 'IN'),
	    array( "name"=> 'IOWA', "abbreviation"=> 'IA'),
	    array( "name"=> 'KANSAS', "abbreviation"=> 'KS'),
	    array( "name"=> 'KENTUCKY', "abbreviation"=> 'KY'),
	    array( "name"=> 'LOUISIANA', "abbreviation"=> 'LA'),
	    array( "name"=> 'MAINE', "abbreviation"=> 'ME'),
	    array( "name"=> 'MARSHALL ISLANDS', "abbreviation"=> 'MH'),
	    array( "name"=> 'MARYLAND', "abbreviation"=> 'MD'),
	    array( "name"=> 'MASSACHUSETTS', "abbreviation"=> 'MA'),
	    array( "name"=> 'MICHIGAN', "abbreviation"=> 'MI'),
	    array( "name"=> 'MINNESOTA', "abbreviation"=> 'MN'),
	    array( "name"=> 'MISSISSIPPI', "abbreviation"=> 'MS'),
	    array( "name"=> 'MISSOURI', "abbreviation"=> 'MO'),
	    array( "name"=> 'MONTANA', "abbreviation"=> 'MT'),
	    array( "name"=> 'NEBRASKA', "abbreviation"=> 'NE'),
	    array( "name"=> 'NEVADA', "abbreviation"=> 'NV'),
	    array( "name"=> 'NEW HAMPSHIRE', "abbreviation"=> 'NH'),
	    array( "name"=> 'NEW JERSEY', "abbreviation"=> 'NJ'),
	    array( "name"=> 'NEW MEXICO', "abbreviation"=> 'NM'),
	    array( "name"=> 'NEW YORK', "abbreviation"=> 'NY'),
	    array( "name"=> 'NORTH CAROLINA', "abbreviation"=> 'NC'),
	    array( "name"=> 'NORTH DAKOTA', "abbreviation"=> 'ND'),
	    array( "name"=> 'NORTHERN MARIANA ISLANDS', "abbreviation"=> 'MP'),
	    array( "name"=> 'OHIO', "abbreviation"=> 'OH'),
	    array( "name"=> 'OKLAHOMA', "abbreviation"=> 'OK'),
	    array( "name"=> 'OREGON', "abbreviation"=> 'OR'),
	    array( "name"=> 'PALAU', "abbreviation"=> 'PW'),
	    array( "name"=> 'PENNSYLVANIA', "abbreviation"=> 'PA'),
	    array( "name"=> 'PUERTO RICO', "abbreviation"=> 'PR'),
	    array( "name"=> 'RHODE ISLAND', "abbreviation"=> 'RI'),
	    array( "name"=> 'SOUTH CAROLINA', "abbreviation"=> 'SC'),
	    array( "name"=> 'SOUTH DAKOTA', "abbreviation"=> 'SD'),
	    array( "name"=> 'TENNESSEE', "abbreviation"=> 'TN'),
	    array( "name"=> 'TEXAS', "abbreviation"=> 'TX'),
	    array( "name"=> 'UTAH', "abbreviation"=> 'UT'),
	    array( "name"=> 'VERMONT', "abbreviation"=> 'VT'),
	    array( "name"=> 'VIRGIN ISLANDS', "abbreviation"=> 'VI'),
	    array( "name"=> 'VIRGINIA', "abbreviation"=> 'VA'),
	    array( "name"=> 'WASHINGTON', "abbreviation"=> 'WA'),
	    array( "name"=> 'WEST VIRGINIA', "abbreviation"=> 'WV'),
	    array( "name"=> 'WISCONSIN', "abbreviation"=> 'WI'),
	    array( "name"=> 'WYOMING', "abbreviation"=> 'WY' )

	);
	private $acc_id, $con_id, $job_id;
    /* the location of the upload folder */
    private $upload_folder = '';//'../resources/uploads/';

    public function __construct(){
        
        /* set the location of the upload folder */
    	$PageData = new PageData(); 
    	$this->upload_folder = $PageData->uploadFolder;

    }

	public function validate($obj, $file = ''){
		
		$i = 1;
		$isAddAcc = true;
		$isAddCon = true;
		 
		//check what page is passing the data for validation
		switch($obj[0]['page']){
	        /* case 'addAcc': break;case 'addCon': break; case 'addJobNote': break; */
			case 'updCon': $isAddCon = false;$this->con_id = $obj[1]['value']; $i = 2; break;
			case 'updAcc': $isAddAcc = false; $this->acc_id = $obj[1]['value']; $i = 2; break;
			case 'addAccAsset': $this->acc_id = $obj[1]['value']; $i = 2; break;
			case 'addJob': $this->acc_id = $obj[1]['value']; $i = 2; break;
			case 'addJobHours': $i = 2; break;
			case 'addJobAsset': $this->acc_id = $obj[1]['value']; $this->job_id = $obj[2]['value']; $i = 3; break;
			case 'printInvoice': $i = 1; break;

		}

		
		//print_r($obj);

		/* Loop throught the object array and check the regex should be using. send the object to the right regex function. */
		while($i < count($obj)){
			switch($obj[$i]['regex']){
				//for Account Name and Job Name
				case 'general_name': $obj[$i] = $this->general_name($obj[$i]); break;
				//the validation for forlder_name is different for add account page and update account page.
				case 'folder_name': $isAddAcc? $obj[$i] = $this->folder_name4add_account($obj[$i]) : $obj[$i] = $this->folder_name4upd_account($obj[$i]); break;
				case 'address': $obj[$i] = $this->address($obj[$i]); break;
				case 'city' : $obj[$i] = $this->city($obj[$i]); break;			
				case 'state' : $obj[$i] = $this->state($obj[$i]); break;
				case 'zip'  : $obj[$i] = $this->zip($obj[$i]); break;
				case 'phone': $obj[$i] = $this->phone($obj[$i]); break;
				case 'email': $isAddCon? $obj[$i] = $this->email4add_contact($obj[$i]) : $obj[$i] = $this->email4upd_contact($obj[$i]) ; break;
				case 'asset_name': $obj[$i] = $this->asset_name($obj[$i]);  break;
				case 'file': $obj[$i] = $this->asset_file($obj[$i], $file); break;
				case 'contact_name': $obj[$i] = $this->contact_name($obj[$i]); break; //human name
				case 'ja_folder_name': $obj[$i] = $this->folder_name4add_job($obj[$i]); break;
				case 'date': $obj[$i] = $this->date($obj[$i]); break;
				case 'hours': $obj[$i] = $this->hours($obj[$i]); break;
				case 'rate': $obj[$i] = $this->rate($obj[$i]); break;
				case 'desc': $obj[$i] = $this->desc($obj[$i]); break;
				case 'end_date': $obj[$i] = $this->end_date($obj[$i-1],$obj[$i]); break;
				
			}
			$i += 1;
		}

		/* If there is any errors then the private error property will be set to true and the modified object will be returned */
		if($this->error){
			return $obj;
		}
		/* If everything got validated then return the string success */
		else {
			return 'success';
		}
	}

	/* The functions below are for individual regex check  */

	private function end_date($objBegDate, $objEndDate){

		// if($obj2EndDate['value']!="") $match = true;
		// else $match = false;
  //       return $this->setMatch($match, $obj2EndDate);

        $beg_date = strtotime($objBegDate['value']);
        $end_date = strtotime($objEndDate['value']);
        if($objEndDate['value']!="" && $beg_date <= $end_date){
        	$match = true;
        }else { $match = false;}
        return $this->setMatch($match, $objEndDate);

	}

	private function date($obj){
		if($obj['value']!="") $match = true;
		else $match = false;
		return $this->setMatch($match, $obj);
		//$match = preg_match('pattern', $obj['value']);
	}

	private function hours($obj){
		$match = preg_match('/^(\d){1,}((\.){1}(\d){1,})?$/', $obj['value']);
		return $this->setMatch($match, $obj); 
	}

	private function rate($obj){
		$match = preg_match('/^(\d){1,}\.?(\d){1,}$/', $obj['value']);
		return $this->setMatch($match, $obj);
	}

    private function desc($obj){
		$match = true;
		return $this->setMatch($match, $obj);

    }

	private function folder_name4add_job($obj){
		$match = preg_match('/^[a-z][a-z0-9-\']{1,50}$/i', $obj['value']);

		if(!$match) {
			return $this->setMatch($match, $obj); 
		}
		else{
            //check if the new folder name is already taken by other jobs in the same account
            $new_folder_name = $obj['value'];
            $pdo = new DBHandler();
			$sql = "SELECT * FROM account WHERE id = :id";
			$bindings = array(
				array(':id', $this->acc_id, 'int'),
			);
			$records = $pdo->selectedBinded($sql,$bindings);
			$account_folder = $records[0]['folder'];
			$dir = getcwd() . $this->upload_folder;

		    if (file_exists($dir.$account_folder."/".$new_folder_name)) {
		    		//the folder is already exist with that name. so divlier the error msg.
				    $match = false;
				    $obj['msg'] = "This Asset Folder Name Already Taken by Another Job, Please Choose Another One.";
			} 
			   
                
		    return $this->setMatch($match, $obj); 		

		}		
	}

	private function contact_name($obj){
	   $name_pattern = "/^[a-zA-Z0-9\-'àÀâÂäÄáÁéÉèÈêÊëËìÌîÎïÏòóÒôÔöÖùúÙûÛüÜçÇ’ñß\.]+[\s]*[a-zA-Z0-9\-'àÀâÂäÄáÁéÉèÈêÊëËìÌîÎïÏòóÒôÔöÖùúÙûÛüÜçÇ’ñß]+$/";
	   $match = preg_match($name_pattern, $obj['value']);
	   return $this->setMatch($match, $obj);
	}

	private function asset_file($obj, $file){
		//check size should be less than 800KB (800,000byte) 	
		$match = true;	
		if( $file['size'] > 800000  ){
			$match = false;

		}
		//check file mime-type with finfo_open() method
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime_type = finfo_file($finfo, $file['tmp_name']);
		finfo_close($finfo);
		if($mime_type !== 'application/pdf'){
			$match = false;
		}
        
		return $this->setMatch($match, $obj); 
	}

	private function asset_name($obj){
		$match = preg_match('/^[a-z][a-z0-9-\'\s]{1,50}$/i', $obj['value']);

		if(!$match) {
			return $this->setMatch($match, $obj); 
		}
		else{
			//check duplicate asset name
			$asset_name = $obj['value'];
            $pdo = new DBHandler();
			$sql = "SELECT * FROM account_asset WHERE account_id = :id AND name = :name";
			$bindings = array(
				array(':id', $this->acc_id, 'int'),
				array(':name', $asset_name, 'str')
			);
			$records = $pdo->selectedBinded($sql,$bindings);
			
		    if( count($records) != 0){

				    $match = false;
				    $obj['msg'] = "Asset Name Already Taken, Please Choose Another One.";		
			   
            }         
		    return $this->setMatch($match, $obj); 
        
        }
	}

	
	private function general_name($obj){
		$match = preg_match('/^[a-z][a-z0-9-\'\s]{1,50}$/i', $obj['value']);
		return $this->setMatch($match, $obj);
	}

    /*folder name validation for add account page */
	private function folder_name4add_account($obj){
		$match = preg_match('/^[a-z][a-z0-9-\']{1,50}$/i', $obj['value']);

		if(!$match) {
			return $this->setMatch($match, $obj); 
		}
		else{
	        //check if the folder already exists
			$dir = getcwd() . $this->upload_folder;		
	        $folder = $dir . $obj['value'];
            
	  	    if (file_exists($folder)) {
			    $match = false;
			    $obj['msg'] = "Folder Name Already Taken, Please Choose Another One.";
			} 
			return $this->setMatch($match, $obj);
		}
	}

    /* folder name validation for update account page */
	private function folder_name4upd_account($obj){
		$match = preg_match('/^[a-z][a-z0-9-\']{1,50}$/i', $obj['value']);

		if(!$match) {
			return $this->setMatch($match, $obj); 
		}
		else{
            //check if the new folder name is already taken by other accounts
            $new_folder_name = $obj['value'];
            $pdo = new DBHandler();
			$sql = "SELECT folder FROM account WHERE id = :id";
			$bindings = array(
				array(':id', $this->acc_id, 'int'),
			);
			$records = $pdo->selectedBinded($sql,$bindings);
			$dir = getcwd() . $this->upload_folder;

		    if($new_folder_name !== $records[0]['folder']){
                
		    	if (file_exists($dir.$new_folder_name)) {
		    		//the folder is already exist with that name. so divlier the error msg.
				    $match = false;
				    $obj['msg'] = "Folder Name Already Taken, Choose Another One.";
			    } 
			   
            }         
		    return $this->setMatch($match, $obj); 
		}

	}

	private function address($obj){
		$match = preg_match('/^\d+([A-Z\s-.])+$/i', $obj['value']);
		return $this->setMatch($match, $obj);
	}

	private function city($obj){
		$match = preg_match('/^[a-z]+[\s -]*[a-z]+$/i', $obj['value']);
		return $this->setMatch($match, $obj);
	}

	private function state($obj){

		$value = strtoupper($obj['value']);
		$valid = false;
		$len = count($this-> usStates);
		for($i = 0; $i < $len; $i++){
		  if($value === $this->usStates[$i]['name']) $valid = true;
		  if($value === $this->usStates[$i]['abbreviation']) $valid= true;
		}

		return $this->setMatch($valid, $obj);
		 
	}

	private function zip($obj){
		$match = preg_match('/^\d{5}$/', $obj['value']);
		return $this->setMatch($match, $obj);
	}

	private function phone($obj){
		if($obj['for'] == 'work_phone'){
			$match = preg_match('/^[0-9]{9}$/', $obj['value']);
		}
		else{
			if($obj['value'] == '') $match = true;
			else $match = preg_match('/^[0-9]{9}$/', $obj['value']);
		}
		return $this->setMatch($match, $obj);
	}

	private function email4add_contact($obj){
		$match = preg_match('/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i', $obj['value']);

		if(!$match) {
			return $this->setMatch($match, $obj); 
		}
		else{
	        //check if the email address already exists
			$email = $obj['value'];
            $pdo = new DBHandler();
			$sql = "SELECT * FROM contact WHERE email = :email";
			$bindings = array(
				array(':email', $email, 'str'),
			);
			$records = $pdo->selectedBinded($sql,$bindings);
            
           
	  	    if (count($records)!= 0) {
			    $match = false;
			    $obj['msg'] = "Contact with this email address already exists, Please choose Another One.";
			} 
			return $this->setMatch($match, $obj);
		}
	}

	private function email4upd_contact($obj){
		$match = preg_match('/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i', $obj['value']);

		if(!$match) {
			return $this->setMatch($match, $obj); 
		}
		else{
	        //get all the email address from the table contact
			$email = $obj['value'];
            $pdo = new DBHandler();
			$sql = "SELECT * FROM contact";
			$records = $pdo->selectNotBinded($sql);

	  	    for($i = 0; $i<count($records); $i++){
	  	    	//check if the email exist in the table
	  	    	if($email == $records[$i]['email']){ 

                    if($this->con_id != $records[$i]['id']){
                    	//if it exist but the id is not one needs to be updating, then return validate false 
					    $match = false;
					    $obj['msg'] = "Contact with this email address already exists, Please choose Another One.";
					}
			    }
			} 
			return $this->setMatch($match, $obj);
		}
	}

	private function setMatch($match, $obj){
		if($match){
			$obj += ['status' => "success"];
		}
		else if(!$match){
			/* IF NO MATCH THEN ERROR EQUALS TRUE */
			$this->error = true;
			$obj += ['status' => "error"];
		}
		return $obj;
	}

}