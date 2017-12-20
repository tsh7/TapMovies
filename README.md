# TapMovies - Movie Database #

## Web Server ChangeLog ##

@date 12/19/2017
@version 1.1

### CHANGE LOG ###
## [1.1] - 2017-12-19
#### Added
- watched and to be watched button in movie detail page if user logged in (LI)
#### Changed
- Changed email to username for registration, login, session, profile, etc
- Keep email as user information
- Changed alert for bad registration/login to JavaScript from PHP
#### Removed
- Phone in the registration is removed along with codes related to it

## [1.0] - 2017-12-18
#### Added
- Movie detail page now also shows movie ID
#### Changed
- Fixed some issues relating to login php pages after user logged in (bad redirect)
- API receivers now also retrieve movie id

## [0.9] - 2017-12-12
#### Added
- Login php pages after user logged in

## [0.8] - 2017-12-5
#### Added
- SCP configured for version control and centralized logging
- Movie detail page shows the title of the movie

## [0.7] - 2017-11-27
#### Changed
- Top Rated movie page now shows title, vote count and rating.

## [0.6] - 2017-11-27
#### Added
- Top Rated movie page works

## [0.5] - 2017-11-20
#### Added
- Snapshots and 2 VM clones created for create, install, and rollback implementation

## [0.4] - 2017-11-15
#### Added
- PHP codes after user logged in (session), duplicate web pages but with session data
- Log out php codes
#### Changed
- now RabbitMQinfo.php file store all variables needed for RabbitMQ (ip, port, user, password)
- change all files that related to RabbitMQ variables to include 'RabbitMQinfo.php'
#### Removed
- Removed unnecessary files

## [0.3] - 2017-11-12
#### Added
- Search Result page with movie title and image
- Added comments for most of the codes for a better explanation in future usage
#### Changed
- Modified the 'search' function codes, so that it works properly with RabbitMQ
- Simplified the codes for user authentication while maximizing the usage of RabbitMQ
- New versions now updated via main folder in a zip file, while 'html' folder is now discontinued
#### Removed
- Removed unnecessary files

## [0.2] - 2017-11-07
#### Added
- Implemented a simple function for search with RabbitMQ setup (php)
- Implemented SSL/https for the web server
#### Changed
- Registration/Login php codes for better implementation
- Subtle web design changes, search button with action that goes to search php
- change some php codes to implement error reporting
- change php codes that contain RabbitMQ that declare variables for easier usage

## [0.1]
#### Added
- Front End website template connected with web server
- Registration works with DB through RabbitMQ
- Php codes for registration/login without RabbitMQ
