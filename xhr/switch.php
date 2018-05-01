<?php

require_once(dirname(__FILE__). '/../controller/crud.php');

$ori_data = $_POST['data'];

$data = json_decode($ori_data, true);
//test if the $data is an array after json_decode
$sign = is_array($data);

if($sign) {

	if(isset($_FILES['file'])){
		$file = $_FILES['file'];
	}

	//print_r($data[1]);
	/* $data[0] is the page flag, $data[1] is the autually data */
	switch($data[0]['page']){
		case "addAcc" : array_shift($data); echo addAccount($data); break;
		case "updAcc" : array_shift($data); echo updAccount($data); break;
		case "addAccAsset": array_shift($data); $file = $_FILES['file']; echo addAccAsset($data, $file); break;
		case "addJobAsset": array_shift($data); $file = $_FILES['file']; echo addJobAsset($data, $file); break;
		case "addAdmin" : array_shift($data); echo addAdmin($data[0]); break;
		case "showInfo4vdAccAsset" : array_shift($data); echo showInfo4vdAccAsset($data[0]); break;
		case "delAssset" : array_shift($data); echo delAccAsset($data[0]); break;
		case "addCon" : array_shift($data); echo addContact($data); break;
		case "updCon" : array_shift($data); echo updContact($data); break;
		case "addJob" : array_shift($data); echo addJob($data); break;
		case "addJobNote" : array_shift($data); echo addJobNote($data); break;
		case "addJobHours": array_shift($data); echo addJobHours($data); break;
		case "updJobNote" : array_shift($data); echo updJobNote($data); break;
		case "updJobHour" : array_shift($data); echo updJobHours($data); break;
	}


} else {
    
    $info = explode('^^^', $ori_data);
    //print_r($info);
    switch($info[0]){
    	case "account" : echo getAccountInfo($info[1]); break;
    	case "contact" : echo getContactInfo($info[1]); break;
    	case "mc_contact": echo checkAssociationInfo($info[1]); break;
    	case "mc_account": echo showJobList($info[1]); break;
    	case "mc_addAssoci": echo addAssoci($ori_data); break;
    	case "vjc_contact": echo showContactTable($ori_data); break;
    	case "del_contact": echo delContact($info[1]); break;
    	case "job_account": echo showJobList($info[1]); break;
    	case "del_associ" : echo delContactAssoci($ori_data); break;
    	case "vcdjn_account_job": echo showJobNoteTable($ori_data); break;
    	case "del_jobNote": echo delJobNote($ori_data); break;
    	case "del_jobHour": echo delJobHour($ori_data); break;
    	case "udh_account_job": echo showJobHourTable($ori_data); break;
    	case "vd_JobAsset": echo showJobAssetTable($info[1]); break;
    	case "del_jobAsset": echo delJobAsset($info[1]); break;
    	case "checkJobHour": echo checkJobHour($info[1]); break;
    	case "getName_Inv": echo getTitle4Invoice($info[1]); break;
    	case "getTable_Inv": echo getInvoice($ori_data); break;

    }
	

}
