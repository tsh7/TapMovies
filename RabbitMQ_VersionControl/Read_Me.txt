Username:  Ben
Password:  admin
Static IP:  192.168.1.101, Netmask:  24, Gateway:  192.168.1.1, DNS:  8.8.8.8
RabbitMQ User:  admin
RabbitMQ Password:  guest
RAM:  4 gb
Storage Space:  16 GB
Network Settings:  Bridged Adapter
OS:  Ubuntu 16.04 Desktop version

For Maximum efficiency, please start with:

"sudo service rabbitmq-server restart" and then
"sudo service rabbitmq-server status" to make sure the server is running efficiently and that all prior queues are cleared.

This VM functions primarily as the RabbitMQ server that links together all of the servers required for this project.  All messages and requests are sent through this server and as such, it is very necessary for this server to be running at all times.  If any of the other servers are shut down for any reason, be sure to restart the RabbitMQ server so that everything can start off fresh.

The secondary function of this VM is to collect and send the newer versions of the Webservers, the Database servers, and the API servers to their respective Test or Live servers.  This is done by running the automatedReceive.php script which prompts the terminal to wait for messages.

From there, the dev servers simply have to run their automatedSending.php script with either a 'promote[their server type]' or a 'test[their server type]' command to trigger the automatedReceive.php script and tell this script where to send and install the new version.

For example:  if the dev servers were to run 'automatedSending.php promoteapi' the automatedReceive.php will recognize that the new version coming in is for the API server and the promote tells the code to send that version to the Live API server.

This will then trigger the 'serverSideReceive.php' script which will automatically unzip and install the new version.  Along with this feature, this server will also host all Change Logs for every new version and will also retain all older versions so that rollback may be achieved.

In order to run rollback, simply run the rollback.sh script and specify which version to roll back to and where it should go to.
