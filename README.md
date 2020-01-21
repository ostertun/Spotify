# Spotify Party Service

## Description
TODO

## Installation
1. Copy all files to a webserver
2. Rename the file .htaccess.example to .htaccess
   1. If necessary change the url in the second line
3. Rename the file server/server/const.php.example to const.php
   1. If necessary change the SERVER_ADDR
   2. Go to https://developer.spotify.com
      1. Login and create an app
      2. add the url to your installation to the whitelisted urls for this app
      3. copy your CLIENT_ID and CLIENT_SECRET to the const.php
   3. Call the script api/scripts/catchspotifyredirector.php in a browser
      1. Select at least the following scopes and press Send
         - user-read-playback-state
         - user-read-currently-playing
         - user-modify-playback-state
         - playlist-read-collaborative
         - playlist-modify-private
         - playlist-modify-public
         - playlist-read-private
         - streaming
      2. Copy the refresh token, the script returns to the const.php
4. Rename the file site/server/const.php.example to const.php
   1. Adjust all fields in this file.
   2. You have to create 4 playlists in your spotify account.
5. Go to https://www.spotifycodes.com/
   1. Create a spotify code for your PL_WDW playlist (white on black is best)
   2. download the code and save the file in the root directory of the installation as spcode.svg
6. Call the script api/newtoken.php in a browser once
   1. By that an initial access token is generated
   2. If necessary, the software refreshes the token automatically
7. Create a cron job, that calls api/cron.php every minute
