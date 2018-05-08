<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Defines the version and other meta-info about the plugin
 *
 * Setting the $plugin->version to 0 prevents the plugin from being installed.
 * See https://docs.moodle.org/dev/version.php for more info.
 *
 * @package    mod_vidtrack
 * @copyright  2018 Pankaj Chejara <pankajchejara23@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

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