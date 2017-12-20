#!/bin/bash

        #sends the named WebServer Version to the Live WebServer
        scp ben@192.168.1.101:/home/ben/IT490/VersionControl/WebServerVersion/$1 webuser@192.168.1.223:/home/webuser/Live
