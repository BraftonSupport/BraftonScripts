# BraftonScripts
A repository of scripts designed to help both clients and Employees create or modify things as needed.  Please follow README file instructions on usage of this repo

##br_siteurl_switcher.php

Wordpress plugin to find and replace all instances of one url with another through the database.  Usefull for moving from development to live/staging enviorments.  

Recommendation: Backup database prior to running

Settings -> Brafton SiteUrl Switcher
###single sites
copy over the contents of the wp-content folder into the new installations.  import the entire wordpress database from your dev enviorment into your new enviorment if needed.

install the plugin and check off the data you want to replace the urls with.

###multsite
copy the content of the wp-content/uploads/ folder corresponding to your sites installation. ie siteId = 2
take the folder wp-content/uploads/2 and drop the the "2" folder into your new installation wp-content/uploads
