<?php
	
	/**
	 * Form used by the catchspotifyredirector.php script
	 *
	 * Author: Lukas Westholt
	 */
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Spotify Authorization Scopes</title>
</head>
<body>
<form action="catchspotifyredirector.php?send=true" method="post">

	<div id="ugc-image-upload">
	  <p><code>ugc-image-upload</code><input type="checkbox" name="ugc-image-upload" /></p>

	  <table>
		<tbody>
		  <tr>
			<td><strong>Description</strong></td>
			<td>Write access to user-provided images.
			</td>
		  </tr>
		  <tr>
			<td><strong>Visible to users</strong></td>
			<td>Upload images to Spotify on your behalf.
			</td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <p><strong>Endpoints that require the <code>ugc-image-upload</code> scope</strong></p>
			  <ul>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/upload-custom-playlist-cover/">Upload a Custom Playlist Cover Image</a></li>
				
			  </ul>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>

	<div id="user-read-playback-state">
	  <p><code>user-read-playback-state</code><input type="checkbox" name="user-read-playback-state" /></p>

	  <table>
		<tbody>
		  <tr>
			<td><strong>Description</strong></td>
			<td>Read access to a user’s player state.
			</td>
		  </tr>
		  <tr>
			<td><strong>Visible to users</strong></td>
			<td>Read your currently playing track and Spotify Connect devices information.
			</td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <p><strong>Endpoints that require the <code>user-read-playback-state</code> scope</strong></p>
			  <ul>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/player/get-a-users-available-devices/">Get a User's Available Devices</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/player/get-information-about-the-users-current-playback/">Get Information About The User's Current Playback</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/player/get-the-users-currently-playing-track/">Get the User's Currently Playing Track</a></li>
				
			  </ul>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>


	<div id="streaming">
	  <p><code>streaming</code><input type="checkbox" name="streaming" /></p>

	  <table>
		<tbody>
		  <tr>
			<td><strong>Description</strong></td>
			<td>Control playback of a Spotify track. This scope is currently available to the Web Playback SDK. The user must have a Spotify Premium account.
			</td>
		  </tr>
		  <tr>
			<td><strong>Visible to users</strong></td>
			<td>Play music and control playback on your other devices.
			</td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <p><strong>Endpoints that require the <code>streaming</code> scope</strong></p>
			  <ul>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-playback-sdk/">Web Playback SDK</a></li>
				
			  </ul>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>

	<div id="user-read-email">
	  <p><code>user-read-email</code><input type="checkbox" name="user-read-email" /></p>

	  <table>
		<tbody>
		  <tr>
			<td><strong>Description</strong></td>
			<td>Read access to user’s email address.
			</td>
		  </tr>
		  <tr>
			<td><strong>Visible to users</strong></td>
			<td>Get your real email address.
			</td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <p><strong>Endpoints that require the <code>user-read-email</code> scope</strong></p>
			  <ul>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/users-profile/get-current-users-profile/">Get Current User's Profile</a></li>
				
			  </ul>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>

	<div id="playlist-read-collaborative">
	  <p><code>playlist-read-collaborative</code><input type="checkbox" name="playlist-read-collaborative" /></p>

	  <table>
		<tbody>
		  <tr>
			<td><strong>Description</strong></td>
			<td>Include collaborative playlists when requesting a user's playlists.
			</td>
		  </tr>
		  <tr>
			<td><strong>Visible to users</strong></td>
			<td>Access your collaborative playlists.
			</td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <p><strong>Endpoints that require the <code>playlist-read-collaborative</code> scope</strong></p>
			  <ul>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/get-a-list-of-current-users-playlists/">Get a List of Current User's Playlists</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/get-list-users-playlists/">Get a List of a User's Playlists</a></li>
				
			  </ul>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>

	<div id="user-modify-playback-state">
	  <p><code>user-modify-playback-state</code><input type="checkbox" name="user-modify-playback-state" /></p>

	  <table>
		<tbody>
		  <tr>
			<td><strong>Description</strong></td>
			<td>Write access to a user’s playback state
			</td>
		  </tr>
		  <tr>
			<td><strong>Visible to users</strong></td>
			<td>Control playback on your Spotify clients and Spotify Connect devices.
			</td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <p><strong>Endpoints that require the <code>user-modify-playback-state</code> scope</strong></p>
			  <ul>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/player/pause-a-users-playback/">Pause a User's Playback</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/player/seek-to-position-in-currently-playing-track/">Seek To Position In Currently Playing Track</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/player/set-repeat-mode-on-users-playback/">Set Repeat Mode On User’s Playback</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/player/set-volume-for-users-playback/">Set Volume For User's Playback</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/player/skip-users-playback-to-next-track/">Skip User’s Playback To Next Track</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/player/skip-users-playback-to-previous-track/">Skip User’s Playback To Previous Track</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/player/start-a-users-playback/">Start/Resume a User's Playback</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/player/toggle-shuffle-for-users-playback/">Toggle Shuffle For User’s Playback</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/player/transfer-a-users-playback/">Transfer a User's Playback</a></li>
				
			  </ul>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>

	<div id="user-read-private">
	  <p><code>user-read-private</code><input type="checkbox" name="user-read-private" /></p>

	  <table>
		<tbody>
		  <tr>
			<td><strong>Description</strong></td>
			<td>Read access to user’s subscription details (type of user account).
			</td>
		  </tr>
		  <tr>
			<td><strong>Visible to users</strong></td>
			<td>Access your subscription details.
			</td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <p><strong>Endpoints that require the <code>user-read-private</code> scope</strong></p>
			  <ul>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/search/search/">Search for an Item</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/users-profile/get-current-users-profile/">Get Current User's Profile</a></li>
				
			  </ul>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>

	<div id="playlist-modify-public">
	  <p><code>playlist-modify-public</code><font color=00ca00> (Recommended for SpotiApp)</font><input type="checkbox" name="playlist-modify-public" /></p>

	  <table>
		<tbody>
		  <tr>
			<td><strong>Description</strong></td>
			<td>Write access to a user's public playlists.
			</td>
		  </tr>
		  <tr>
			<td><strong>Visible to users</strong></td>
			<td>Manage your public playlists.
			</td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <p><strong>Endpoints that require the <code>playlist-modify-public</code> scope</strong></p>
			  <ul>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/follow/follow-playlist/">Follow a Playlist</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/follow/unfollow-playlist/">Unfollow a Playlist</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/add-tracks-to-playlist/">Add Tracks to a Playlist</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/change-playlist-details/">Change a Playlist's Details</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/create-playlist/">Create a Playlist</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/remove-tracks-playlist/">Remove Tracks from a Playlist</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/reorder-playlists-tracks/">Reorder a Playlist's Tracks</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/replace-playlists-tracks/">Replace a Playlist's Tracks</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/upload-custom-playlist-cover/">Upload a Custom Playlist Cover Image</a></li>
				
			  </ul>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>

	<div id="user-library-modify">
	  <p><code>user-library-modify</code><input type="checkbox" name="user-library-modify" /></p>

	  <table>
		<tbody>
		  <tr>
			<td><strong>Description</strong></td>
			<td>Write/delete access to a user's "Your Music" library.
			</td>
		  </tr>
		  <tr>
			<td><strong>Visible to users</strong></td>
			<td>Manage your saved tracks and albums.
			</td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <p><strong>Endpoints that require the <code>user-library-modify</code> scope</strong></p>
			  <ul>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/library/remove-albums-user/">Remove Albums for Current User</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/library/remove-tracks-user/">Remove User's Saved Tracks</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/library/save-albums-user/">Save Albums for Current User</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/library/save-tracks-user/">Save Tracks for User</a></li>
				
			  </ul>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>

	<div id="user-top-read">
	  <p><code>user-top-read</code><input type="checkbox" name="user-top-read" /></p>

	  <table>
		<tbody>
		  <tr>
			<td><strong>Description</strong></td>
			<td>Read access to a user's top artists and tracks.
			</td>
		  </tr>
		  <tr>
			<td><strong>Visible to users</strong></td>
			<td>Read your top artists and tracks.
			</td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <p><strong>Endpoints that require the <code>user-top-read</code> scope</strong></p>
			  <ul>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/personalization/get-users-top-artists-and-tracks/">Get a User's Top Artists and Tracks</a></li>
				
			  </ul>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>

	<div id="user-read-currently-playing">
	  <p><code>user-read-currently-playing</code><font color=00ca00> (Recommended for SpotiApp)</font><input type="checkbox" name="user-read-currently-playing" /></p>

	  <table>
		<tbody>
		  <tr>
			<td><strong>Description</strong></td>
			<td>Read access to a user’s currently playing track
			</td>
		  </tr>
		  <tr>
			<td><strong>Visible to users</strong></td>
			<td>Read your currently playing track
			</td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <p><strong>Endpoints that require the <code>user-read-currently-playing</code> scope</strong></p>
			  <ul>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/player/get-the-users-currently-playing-track/">Get the User's Currently Playing Track</a></li>
				
			  </ul>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>

	<div id="playlist-read-private">
	  <p><code>playlist-read-private</code><font color=00ca00> (Recommended for SpotiApp)</font><input type="checkbox" name="playlist-read-private" /></p>

	  <table>
		<tbody>
		  <tr>
			<td><strong>Description</strong></td>
			<td>Read access to user's private playlists.
			</td>
		  </tr>
		  <tr>
			<td><strong>Visible to users</strong></td>
			<td>Access your private playlists.
			</td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <p><strong>Endpoints that require the <code>playlist-read-private</code> scope</strong></p>
			  <ul>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/follow/check-user-following-playlist/">Check if Users Follow a Playlist</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/get-a-list-of-current-users-playlists/">Get a List of Current User's Playlists</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/get-list-users-playlists/">Get a List of a User's Playlists</a></li>
				
			  </ul>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>

	<div id="user-follow-read">
	  <p><code>user-follow-read</code><input type="checkbox" name="user-follow-read" /></p>

	  <table>
		<tbody>
		  <tr>
			<td><strong>Description</strong></td>
			<td>Read access to the list of artists and other users that the user follows.
			</td>
		  </tr>
		  <tr>
			<td><strong>Visible to users</strong></td>
			<td>Access your followers and who you are following.
			</td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <p><strong>Endpoints that require the <code>user-follow-read</code> scope</strong></p>
			  <ul>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/follow/check-current-user-follows/">Check if Current User Follows Artists or Users</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/follow/get-followed/">Get User's Followed Artists</a></li>
				
			  </ul>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>

	<div id="app-remote-control">
	  <p><code>app-remote-control</code><input type="checkbox" name="app-remote-control" /></p>

	  <table>
		<tbody>
		  <tr>
			<td><strong>Description</strong></td>
			<td>Remote control playback of Spotify. This scope is currently available to Spotify iOS and Android SDKs.
			</td>
		  </tr>
		  <tr>
			<td><strong>Visible to users</strong></td>
			<td>Communicate with the Spotify app on your device.
			</td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <p><strong>Endpoints that require the <code>app-remote-control</code> scope</strong></p>
			  <ul>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/ios/">iOS SDK</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/android/">Android SDK</a></li>
				
			  </ul>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>

	<div id="user-read-recently-played">
	  <p><code>user-read-recently-played</code><font color=00ca00> (Recommended for SpotiApp)</font><input type="checkbox" name="user-read-recently-played" /></p>

	  <table>
		<tbody>
		  <tr>
			<td><strong>Description</strong></td>
			<td>Read access to a user’s recently played tracks.
			</td>
		  </tr>
		  <tr>
			<td><strong>Visible to users</strong></td>
			<td>Access your recently played items.
			</td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <p><strong>Endpoints that require the <code>user-read-recently-played</code> scope</strong></p>
			  <ul>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/player/get-recently-played/">Get Current User's Recently Played Tracks</a></li>
				
			  </ul>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>

	<div id="playlist-modify-private">
	  <p><code>playlist-modify-private</code><font color=00ca00> (Recommended for SpotiApp)</font><input type="checkbox" name="playlist-modify-private" /></p>

	  <table>
		<tbody>
		  <tr>
			<td><strong>Description</strong></td>
			<td>Write access to a user's private playlists.
			</td>
		  </tr>
		  <tr>
			<td><strong>Visible to users</strong></td>
			<td>Manage your private playlists.
			</td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <p><strong>Endpoints that require the <code>playlist-modify-private</code> scope</strong></p>
			  <ul>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/follow/follow-playlist/">Follow a Playlist</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/follow/unfollow-playlist/">Unfollow a Playlist</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/add-tracks-to-playlist/">Add Tracks to a Playlist</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/change-playlist-details/">Change a Playlist's Details</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/create-playlist/">Create a Playlist</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/remove-tracks-playlist/">Remove Tracks from a Playlist</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/reorder-playlists-tracks/">Reorder a Playlist's Tracks</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/replace-playlists-tracks/">Replace a Playlist's Tracks</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/playlists/upload-custom-playlist-cover/">Upload a Custom Playlist Cover Image</a></li>
				
			  </ul>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>

	<div id="user-follow-modify">
	  <p><code>user-follow-modify</code><input type="checkbox" name="user-follow-modify" /></p>

	  <table>
		<tbody>
		  <tr>
			<td><strong>Description</strong></td>
			<td>Write/delete access to the list of artists and other users that the user follows.
			</td>
		  </tr>
		  <tr>
			<td><strong>Visible to users</strong></td>
			<td>Manage who you are following.
			</td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <p><strong>Endpoints that require the <code>user-follow-modify</code> scope</strong></p>
			  <ul>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/follow/follow-artists-users/">Follow Artists or Users</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/follow/unfollow-artists-users/">Unfollow Artists or Users</a></li>
				
			  </ul>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>

	<div id="user-library-read">
	  <p><code>user-library-read</code><input type="checkbox" name="user-library-read" /></p>

	  <table>
		<tbody>
		  <tr>
			<td><strong>Description</strong></td>
			<td>Read access to a user's "Your Music" library.
			</td>
		  </tr>
		  <tr>
			<td><strong>Visible to users</strong></td>
			<td>Access your saved tracks and albums.
			</td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <p><strong>Endpoints that require the <code>user-library-read</code> scope</strong></p>
			  <ul>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/library/check-users-saved-albums/">Check User's Saved Albums</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/library/check-users-saved-tracks/">Check User's Saved Tracks</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/library/get-users-saved-albums/">Get Current User's Saved Albums</a></li>
				
				<li><a target="_blank" href="https://developer.spotify.com/documentation/web-api/reference/library/get-users-saved-tracks/">Get a User's Saved Tracks</a></li>
				
			  </ul>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>	
	<p><input type="submit" /></p></form>
</body>
</html>