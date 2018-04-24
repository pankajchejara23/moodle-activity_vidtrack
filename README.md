# VidTrack
### Moodle activity plugin to track user's video watching behavior
VidTrack is a simple activity plugin for Moodle. It simply takes youtube video url and embed it into page by using Youtube iFrame api. This plugin records following video events using same api.
- Play
- Pause
- End
- Unstarted
- Buffering
- Cued

When one of above event occurred, VidTrack store the record in a table youtube ( which is created at the time of installing plugin). This record contain student id, course id, time. This data later can be analyzed to understand student's video watching behavior.

In this future release, we plan to include visual analytics in it to 
