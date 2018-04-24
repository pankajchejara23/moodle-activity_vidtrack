<?php

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');		
	global $DB;		
			$user=$_GET['user'];
			$course=$_GET['course'];
			$video=$_GET['video'];
			$state=$_GET['state'];


$record=new stdClass();
$record->user=$user;
$record->course=$course;
$record->video=$video;
$temp='';
switch($state){
	case -1:
		$temp='unstarted';
		break;
	case 0:
		$temp='ended';
		break;
	case 1:
		$temp='playing';
		break;
	case 2:
		$temp='paused';
		break;
	case 3:
		$temp='buffering';
		break;
		
	case 4:
		$temp='video cued';
		break;
	default:
		$temp='unrecognized state';
		break;
	
}
$record->state=$temp;
$record->time_occurred=date('Y-m-d H:i:s');
$id=$DB->insert_record('youtube',$record,false);
	

?>