#!/bin/bash
if [ -z "$1" ]
then
	echo "If ya don't put anything here, Mangab is best PM and you don't want that"
else
	#zips the APIVersionControl as the variable name
	zip -r $1 /home/kuldeep/APIVersionControl

	#sets the zip file to a variable
	zipVar="$1.zip"

	#sets the path variable
	pathVar="/home/kuldeep/$zipVar"

	#transfers the zip file
	scp kuldeep@192.168.1.111:$pathVar ben@192.168.1.101:/home/ben/IT490/VersionControl/APIVersion

	#transfers change log
	#scp kuldeep@192.168.1.111:/path/to/your/changelog ben@192.168.1.101:/home/ben/IT490/ChangeLog/APIServerChangeLog

fi
