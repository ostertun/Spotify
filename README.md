# Spotify Party Service

## Description
TODO

## Installation
1. Copy all files to a webserver
2. Go to https://developer.spotify.com
   1. Login and create an app
   2. add the url to your installation to the whitelisted urls for this app
   3. note your CLIENT_ID and CLIENT_SECRET
3. Create 4 playlists:
   1. PL_WISH - this is the playlist that will keep the wished songs until they are played
   2. PL_WDW - a common playlist - here guests can add their wishes directly from spotify
   3. PL_SAVED - here all wished songs will be saved, so that you can later see, what was played on the party
   4. PL_POOL - a playlist containing many songs - if there are no songs in the wishlist, a random song from here will be played
4. Call the setup.php in a browser
   1. Fill in all fields
   2. Press Send
5. Call the api/scripts/catchspotifyredirector.php in a browser
   1. Select at least the following scopes and press Send
      - user-read-playback-state
      - user-read-currently-playing
      - user-modify-playback-state
      - playlist-read-collaborative
      - playlist-modify-private
      - playlist-modify-public
      - playlist-read-private
      - streaming
   2. Copy the refresh token, the script returns to the server/server/const.php
6. Go to https://www.spotifycodes.com/
   1. Create a spotify code for your PL_WDW playlist (white on black is best)
   2. download the code and save the file in the root directory of the installation as spcode.svg
7. Call api/newtoken.php in a browser
   1. By that an initial access token is generated
   2. If necessary, the software refreshes the token automatically
8. Create a cron job, that calls api/cron.php every minute
