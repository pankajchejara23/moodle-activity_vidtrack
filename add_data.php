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
$record->course=(string)$course;
$record->name=(string)$video;
$record->state=$state;
$record->time_occurred=date('Y-m-d H:i:s');
$id=$DB->insert_record('youtube',$record,false);
	

?>