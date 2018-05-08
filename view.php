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
 * Prints a particular instance of vidtrack
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_vidtrack
 * @copyright  2018 Pankaj Chejara <pankajchejara23@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */



require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or
$v  = optional_param('v', 0, PARAM_INT);  // ... vidtrack instance ID - it should be named as the first character of the module.

if ($id) {
    $cm         = get_coursemodule_from_id('vidtrack', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $vidtrack  = $DB->get_record('vidtrack', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($v) {
    $vidtrack  = $DB->get_record('vidtrack', array('id' => $v), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $vidtrack->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('vidtrack', $vidtrack->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$event = \mod_vidtrack\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->add_record_snapshot($PAGE->cm->modname, $vidtrack);
$event->trigger();

// Print the page header.

$PAGE->set_url('/mod/vidtrack/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($vidtrack->name));
$PAGE->set_heading(format_string($course->fullname));

/*
 * Other things you may want to set - remove if not needed.
 * $PAGE->set_cacheable(false);
 * $PAGE->set_focuscontrol('some-html-id');
 * $PAGE->add_body_class('vidtrack-'.$somevar);
 */

// Output starts here.
echo $OUTPUT->header();

// Conditions to show the intro can change to look for own settings or whatever.
if ($vidtrack->intro) {
    echo $OUTPUT->box(format_module_intro('vidtrack', $vidtrack, $cm->id), 'generalbox mod_introbox', 'vidtrackintro');
}

// Replace the following lines with you own code.






echo $OUTPUT->heading($vidtrack->name);
//echo $PAGE->course->id."<br/>";
//echo $USER->id."<br/>";
//echo $vidtrack->id;
$parts = parse_url($vidtrack->youtube);
parse_str($parts['query'], $query);
$video=$query['v'];
?>
<div id="ytplayer"></div>
<div id="demo"></div>
<script type="text/javascript">
  // Load the IFrame Player API code asynchronously.
  var tag = document.createElement('script');
  tag.src = "https://www.youtube.com/player_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  // Replace the 'ytplayer' element with an <iframe> and
  // YouTube player after the API code downloads.
  var player;
  function onYouTubePlayerAPIReady() {
    player = new YT.Player('ytplayer', {
      height: '360',
      width: '640',
      videoId: '<?php echo $video;?>',
	  events: {
           'onStateChange': onPlayerStateChange 
          }

    });
	
	
  }
 function onPlayerStateChange(event) {
	   var course=<?php echo $PAGE->course->id;?>;
	   var user=<?php echo $USER->id;?>;
	   var video=<?php echo $vidtrack->id;?>;
	   var xhttp;
	   var state=event.data;
	   //document.getElementById("demo").innerHTML="State changed "+event.data+player.getVideoUrl()+player.getCurrentTime()+" "+course;
		
	   xhttp = new XMLHttpRequest();
	   xhttp.open("GET", "add_data.php?state="+state+"&course="+course+"&user="+user+"&video="+video, true);
	   xhttp.send();
  } 

</script>

<?php



// Finish the page.
echo $OUTPUT->footer();
