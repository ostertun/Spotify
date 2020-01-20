# Spotify Party Service

## Description
TODO

## Installation
 1. Copy all files to a webserver
 2. Rename the file .htaccess.example to .htaccess
   a. If necessary change the url in the second line
 3. Rename the file server/server/const.php.example to const.php
   a. If necessary change the SERVER_ADDR
   b. Follow the instructions in the file to get CLIENT_ID, CLIENT_SECRET and REFRESH_TOKEN
 4. Rename the file site/server/const.php.example to const.php
   a. Adjust all fields in this file.
 5. Go to https://www.spotifycodes.com/
   a. Create a spotify code for your PL_WDW playlist
   b. save the code in the root directory of the installation as spcode.svg
 6. Call https://domain.com/path/to/your/installation/api/newtoken.php once
   a. By that an initial access token is generated
   b. If necessary, the software refreshes the token automatically
 7. Create a cron job, that calls api/cron.php every minute
