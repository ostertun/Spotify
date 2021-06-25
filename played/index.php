<!DOCTYPE HTML>
<!--
	Multiverse by Pixelarity
	pixelarity.com | hello@pixelarity.com
	License: pixelarity.com/license
-->
<html>
	<head>
		<title>Zuletzt gespielte Songs</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<h1><a href="index.html">Zuletzt gespielte <strong>Songs</strong></a></h1>
						<?php /*<nav>
							<ul>
								<li><a href="#footer" class="icon solid fa-info-circle">About</a></li>
							</ul>
						</nav>*/ ?>
					</header>

				<!-- Main -->
					<div id="main">
						<?php
							$file = file_get_contents(__DIR__ . '/../site/server/playlist/tracks');
							$tracks = array_reverse(explode("\n", $file));
							foreach ($tracks as $track) {
								$track = explode("\t", $track);
								if (count($track) < 6) continue;
								$trackId = $track[0];
								$title = $track[1];
								$artists = $track[2];
								$album = $track[3];
								$time = $track[4];
								$coverUrl = $track[5];
								$coverUrlSmall = count($track) > 6 ? $track[6] : $coverUrl;
								if ($time < strtotime('-20 hours')) break;
								echo '<article class="thumb">';
								echo '<a href="' . $coverUrl . '" class="image"><img src="' . $coverUrlSmall . '" alt="" /></a>';
								echo '<h2>' . date('H:i', $time) . ' ' . htmlentities($title, ENT_COMPAT, 'utf-8') . '</h2>';
								echo '<p>';
								echo htmlentities($artists, ENT_COMPAT, 'utf-8') . '<br>';
								echo htmlentities($album, ENT_COMPAT, 'utf-8') . '<br>';
								echo '<a href="https://open.spotify.com/track/' . $trackId . '"><i class="fab fa-spotify"></i> Spotify</a>';
								echo '</p>';
								echo '</article>';
							}
						?>
					</div>

				<!-- Footer -->
					<footer id="footer" class="panel">
						<div class="inner split">
							<div>
								<section>
									<h2>Magna feugiat sed adipiscing</h2>
									<p>Nulla consequat, ex ut suscipit rutrum, mi dolor tincidunt erat, et scelerisque turpis ipsum eget quis orci mattis aliquet. Maecenas fringilla et ante at lorem et ipsum. Dolor nulla eu bibendum sapien. Donec non pharetra dui. Nulla consequat, ex ut suscipit rutrum, mi dolor tincidunt erat, et scelerisque turpis ipsum.</p>
								</section>
								<section>
									<h2>Follow me on ...</h2>
									<ul class="icons">
										<li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
										<li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
										<li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
										<li><a href="#" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
										<li><a href="#" class="icon brands fa-dribbble"><span class="label">Dribbble</span></a></li>
										<li><a href="#" class="icon brands fa-linkedin-in"><span class="label">LinkedIn</span></a></li>
									</ul>
								</section>
								<p class="copyright">
									&copy; Unttled.
								</p>
							</div>
							<div>
								<section>
									<h2>Get in touch</h2>
									<form method="post" action="#">
										<div class="fields">
											<div class="field half">
												<input type="text" name="name" id="name" placeholder="Name" />
											</div>
											<div class="field half">
												<input type="text" name="email" id="email" placeholder="Email" />
											</div>
											<div class="field">
												<textarea name="message" id="message" rows="4" placeholder="Message"></textarea>
											</div>
										</div>
										<ul class="actions">
											<li><input type="submit" value="Send" class="primary" /></li>
											<li><input type="reset" value="Reset" /></li>
										</ul>
									</form>
								</section>
							</div>
						</div>
					</footer>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.poptrox.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>