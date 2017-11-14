# TapMovies - Movie Database #

## Web Server ChangeLog ##

@date 11/12/2017<br/>
@version 0.3<br/>

### CHANGE LOG ###
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
