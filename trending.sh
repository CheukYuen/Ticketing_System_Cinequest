#!/bin/bash
##########
# Name: trending.sh
# Desc: rebulds trending statistics file
#	o This exports a new trending sales snapshot every hour  
#	o The data file is used: where? how?  
# crontab entry: 25 */1 * * * /home/cquest/cgi-bin/trending/trending.sh
#
cd /home/cquest/cgi-bin/trending

dt=`date +%y%m%d`

# to keep things simple, you can create a folder in your target directory to receive your XML files.
# create a symbolic here pointing to your target. Your output will be created in the new location
# and you don't have to write additional code to move your xml files when your job is done.  
#

###
# run your first scripts to rebuild your XML data file
## php -f ./rebuiild_XML1.php
php -f ./generateXML_RushStatus_Top5Showings.php > XMLFiles/RushStatus_Top5Showings_$dt.txt

###
# run your second script to rebuild your XML data file
## php -f ./rebuild_XML2.php
php -f ./generateXML_EventsWithShowings.php > XMLFiles/EventsWithShowings_$dt.txt

###
# run your third script to rebuild your XML data file
## php -f ./rebuild_XML2.php
php -f ./generateXML_EventsWithShowingsSummary.php > XMLFiles/EventsWithShowingsSummary_.$dt.txt

###
# run your fourth script to rebuild your XML data file
## php -f ./rebuild_XML2.php
php -f ./generateXML_Trending_Top5Events.php > XMLFiles/Trending_Top5Events_$dt.txt
###
# run your fifth script to create a new logfile
## php -f ./generate_logfile.php
php -f generateLogFile.php > logFiles/logFile_$dt.txt

###
# now run your data regeneration script
php -f ./updateDB.php  2> logFiles/error.log