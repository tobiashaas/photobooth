<?php

require_once('lib/config.php');
require_once('lib/folders.php');
require_once('lib/db.php');

$imagelist = ($config['newest_first'] === true) ? array_reverse($images) : $images;
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
	<meta name="msapplication-TileColor" content="<?=$config['colors']['primary']?>">
	<meta name="theme-color" content="<?=$config['colors']['primary']?>">

	<title>Photobooth</title>

	<!-- Favicon + Android/iPhone Icons -->
	<link rel="apple-touch-icon" sizes="180x180" href="resources/img/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="resources/img/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="resources/img/favicon-16x16.png">
	<link rel="manifest" href="resources/img/site.webmanifest">
	<link rel="mask-icon" href="resources/img/safari-pinned-tab.svg" color="#5bbad5">

	<!-- Fullscreen Mode on old iOS-Devices when starting photobooth from homescreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />

	<link rel="stylesheet" href="node_modules/normalize.css/normalize.css" />
	<link rel="stylesheet" href="node_modules/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="node_modules/photoswipe/dist/photoswipe.css" />
	<link rel="stylesheet" href="node_modules/photoswipe/dist/default-skin/default-skin.css" />
	<link rel="stylesheet" href="resources/css/style.css" />
</head>

<body class="deselect">
	<div id="wrapper">

		<!-- Start Page -->
		<div class="stages" id="start">
			<?php if ($config['show_gallery']): ?>
			<a class="gallery-button btn" href="#"><i class="fa fa-th"></i> <span data-l10n="gallery"></span></a>
			<?php endif; ?>

			<div class="blurred"></div>

			<div class="inner">
				<?php if ($config['is_wedding']): ?>
				<div class="names">
					<hr class="small" />
					<hr>
					<div>
						<h1><?=$config['wedding']['groom']?>
							<i class="fa <?=$config['wedding']['symbol']?>" aria-hidden="true"></i>
							<?=$config['wedding']['bride']?>
							<br>
							<?=$config['start_screen_title']?>
						</h1>
						<h2><?=$config['start_screen_subtitle']?></h2>
					</div>
					<hr>
					<hr class="small" />
				</div>
				<?php else: ?>
				<div class="names">
					<hr class="small" />
					<hr>
					<div>
						<h1><?=$config['start_screen_title']?></h1>
						<h2><?=$config['start_screen_subtitle']?></h2>
					</div>
					<hr>
					<hr class="small" />
				</div>
				<?php endif; ?>

				<?php if ($config['use_filter']): ?>
				<a href="#" class="btn imageFilter"><i class="fa fa-magic"></i> <span
						data-l10n="selectFilter"></span></a>
				<?php endif; ?>

				<?php if ($config['use_collage']): ?>
				<a href="#" class="btn takeCollage"><i class="fa fa-th-large"></i> <span
						data-l10n="takeCollage"></span></a>
				<?php endif; ?>

				<a href="#" class="btn takePic"><i class="fa fa-camera"></i> <span data-l10n="takePhoto"></span></a>
			</div>

			<?php if ($config['show_fork']): ?>
			<a href="https://github.com/andreknieriem/photobooth" class="github-fork-ribbon" data-ribbon="Fork me on GitHub">Fork me on GitHub</a>
			<?php endif; ?>
		</div>

		<!-- image Filter Pane -->
		<?php if ($config['use_filter']): ?>
		<div id="mySidenav" class="dragscroll sidenav">
			<a href="#" class="closebtn"><i class="fa fa-times"></i></a>

			<div class="activeSidenavBtn" id="imgPlain"><a class="btn btn--small" href="#">original</a></div>
			<div id="imgAntique"> <a class="btn btn--small" href="#">antique</a></div>
			<div id="imgAqua"> <a class="btn btn--small" href="#">aqua</a></div>
			<div id="imgBlue"> <a class="btn btn--small" href="#">blue</a></div>
			<div id="imgBlur"> <a class="btn btn--small" href="#">blur</a></div>
			<div id="imgColor"> <a class="btn btn--small" href="#">colorful</a></div>
			<div id="imgCool"> <a class="btn btn--small" href="#">cool</a></div>
			<div id="imgEdge"> <a class="btn btn--small" href="#">edge</a></div>
			<div id="imgEmboss"> <a class="btn btn--small" href="#">emboss</a></div>
			<div id="imgEverglow"> <a class="btn btn--small" href="#">everglow</a></div>
			<div id="imgGrayscale"> <a class="btn btn--small" href="#">grayscale</a></div>
			<div id="imgGreen"> <a class="btn btn--small" href="#">green</a></div>
			<div id="imgMean"> <a class="btn btn--small" href="#">mean</a></div>
			<div id="imgNegate"> <a class="btn btn--small" href="#">negate</a></div>
			<div id="imgPink"> <a class="btn btn--small" href="#">pink</a></div>
			<div id="imgPixelate"> <a class="btn btn--small" href="#">pixelate</a></div>
			<div id="imgRed"> <a class="btn btn--small" href="#">red</a></div>
			<div id="imgRetro"> <a class="btn btn--small" href="#">retro</a></div>
			<div id="imgSelectiveBlur"> <a class="btn btn--small" href="#">selective blur</a></div>
			<div id="imgSepiaLight"> <a class="btn btn--small" href="#">sepia light</a></div>
			<div id="imgSepiaDark"> <a class="btn btn--small" href="#">sepia dark</a></div>
			<div id="imgSmooth"> <a class="btn btn--small" href="#">smooth</a></div>
			<div id="imgSummer"> <a class="btn btn--small" href="#">summer</a></div>
			<div id="imgVintage"> <a class="btn btn--small" href="#">vintage</a></div>
			<div id="imgWashed"> <a class="btn btn--small" href="#">washed</a></div>
			<div id="imgYellow"> <a class="btn btn--small" href="#">yellow</a></div>
		</div>
		<?php endif; ?>

		<!-- Loader -->
		<div class="stages" id="loader">
			<?php if ($config['previewFromCam']): ?>
			<video id="video" autoplay></video>
			<?php endif; ?>

			<div class="loaderInner">
				<div class="spinner">
					<i class="fa fa-cog fa-spin"></i>
				</div>

				<div id="counter"></div>
				<div class="loading"></div>
			</div>
		</div>

		<!-- Result Page -->
		<div class="stages" id="result">
			<a href="#" class="btn homebtn"><i class="fa fa-home"></i> <span data-l10n="home"></span></a>
			<div class="resultInner hidden">
				<?php if ($config['show_gallery']): ?>
				<a href="#" class="btn gallery-button"><i class="fa fa-th"></i> <span data-l10n="gallery"></span></a>
				<?php endif; ?>

				<?php if ($config['use_qr']): ?>
				<a href="#" class="btn qrbtn"><i class="fa fa-qrcode"></i> <span data-l10n="qr"></span></a>
				<?php endif; ?>

				<?php if ($config['use_mail']): ?>
				<a href="#" class="btn mailbtn"><i class="fa fa-envelope"></i> <span data-l10n="mail"></span></a>
				<?php endif; ?>

				<?php if ($config['use_print']): ?>
				<a href="#" class="btn printbtn"><i class="fa fa-print"></i> <span data-l10n="print"></span></a>
				<?php endif; ?>

				<a href="#" class="btn newpic"><i class="fa fa-camera"></i> <span data-l10n="newPhoto"></span></a>

				<?php if ($config['use_collage']): ?>
				<a href="#" class="btn newcollage"><i class="fa fa-th-large"></i> <span
						data-l10n="newCollage"></span></a>
				<?php endif; ?>
			</div>

			<?php if ($config['use_qr']): ?>
			<div id="qrCode" class="modal">
				<div class="modal__body"></div>
			</div>
			<?php endif; ?>
		</div>

		<?php if ($config['show_gallery']): ?>
		<!-- Gallery -->
		<div id="gallery" class="gallery">
			<div class="gallery__inner">
				<div class="gallery__header">
					<h1><span data-l10n="gallery"></span></h1>
					<a href="#" class="gallery__close close_gal"><i class="fa fa-times"></i></a>
				</div>
				<div class="gallery__body" id="galimages">
					<?php if (empty($imagelist)): ?>
					<h1 style="text-align:center" data-l10n="gallery_no_image"></h1>
					<?php else: ?>
					<?php foreach ($imagelist as $image): ?>
					<?php
                            $date = '';
                            if ($config['file_format_date'] && $config['show_date']) {
                                $date = DateTime::createFromFormat('Ymd_His', substr($image, 0, strlen($image) - 4));
                                $date = '<i class="fa fa-clock-o"></i>' . $date->format($config['gallery']['date_format']);
                            }

                            $filename_photo = $config['folders']['images'] . DIRECTORY_SEPARATOR . $image;
                            $filename_thumb = $config['folders']['thumbs'] . DIRECTORY_SEPARATOR . $image;

                            $imageinfo = getimagesize($filename_photo);
                            $imageinfoThumb = getimagesize($filename_thumb);
                            ?>

					<a href="<?=$filename_photo?>" data-size="<?=$imageinfo[0]?>x<?=$imageinfo[1]?>"
						data-med="<?=$filename_thumb?>" data-med-size="<?=$imageinfoThumb[0]?>x<?=$imageinfoThumb[1]?>">
						<figure>
							<img src="<?=$filename_thumb?>" alt="<?=$image?>" />
							<figcaption><?=$date?></figcaption>
						</figure>
					</a>
						<?php endforeach; ?>
						<?php endif; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>


	<!-- Root element of PhotoSwipe. Must have class pswp. -->
	<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

		<!-- Background of PhotoSwipe.
	 	It's a separate element, as animating opacity is faster than rgba(). -->
		<div class="pswp__bg"></div>

		<!-- Slides wrapper with overflow:hidden. -->
		<div class="pswp__scroll-wrap">

			<!-- Container that holds slides.
			PhotoSwipe keeps only 3 of them in DOM to save memory.
			Don't modify these 3 pswp__item elements, data is added later on. -->
			<div class="pswp__container">
				<div class="pswp__item"></div>
				<div class="pswp__item"></div>
				<div class="pswp__item"></div>
			</div>

			<!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
			<div class="pswp__ui pswp__ui--hidden">
				<div class="pswp__top-bar">
					<!--  Controls are self-explanatory. Order can be changed. -->

					<div class="pswp__counter"></div>
					<button class="pswp__button pswp__button--close" title="Close (Esc)"><i
							class="fa fa-times"></i></button>
					<button class="pswp__button pswp__button--share" title="Share"></button>
					<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
					<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

					<?php if ($config['use_mail']): ?>
					<button class="pswp__button pswp__button--mail" title="Per Mail senden"><i class="fa fa-envelope"></i></button>
					<?php endif; ?>

					<?php if ($config['use_print']): ?>
					<button class="pswp__button pswp__button--print" title="Drucken"><i class="fa fa-print"></i></button>
					<?php endif; ?>

					<?php if ($config['use_qr']): ?>
					<button class="pswp__button pswp__button--qrcode" title="Qr Code öffnen"><i class="fa fa-qrcode"></i></button>
					<?php endif; ?>

					<?php if ($config['chroma_keying']): ?>
					<button class="pswp__button pswp__button--print-chroma-keying" title="Print extra"><i class="fa fa-paint-brush"></i></button>
					<?php endif; ?>

					<!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
					<!-- element will get class pswp__preloader--active when preloader is running -->
					<div class="pswp__preloader">
						<div class="pswp__preloader__icn">
							<div class="pswp__preloader__cut">
								<div class="pswp__preloader__donut"></div>
							</div>
						</div>
					</div>
				</div>

				<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
					<div class="pswp__share-tooltip"></div>
				</div>

				<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
				</button>

				<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
				</button>

				<div class="pswp__caption">
					<div class="pswp__caption__center"></div>
				</div>
			</div>
		</div>
		<div class="pswp__qr">

		</div>
	</div>

	<div class="send-mail">
		<i class="fa fa-times" id="send-mail-close"></i>
		<p data-l10n="insertMail"></p>
		<form id="send-mail-form" style="margin: 0;">
			<input class="mail-form-input" size="35" type="email" name="sendTo">
			<input id="mail-form-image" type="hidden" name="image" value="">

			<?php if ($config['send_all_later']): ?>
				<input type="checkbox" id="mail-form-send-link" name="send-link" value="yes">
				<label data-l10n="sendAllMail" for="mail-form-send-link"></label>
			<?php endif; ?>

			<button class="mail-form-input btn" name="submit" type="submit" value="Senden">Senden</button>
		</form>

		<div id="mail-form-message" style="max-width: 75%"></div>
	</div>

	<div class="modal" id="print_mesg">
		<div class="modal__body"><span data-l10n="printing"></span></div>
	</div>

	<div id="adminsettings">
		<div style="position:absolute; bottom:0; right:0;">
			<img src="resources/img/spacer.png" alt="adminsettings" ondblclick="adminsettings()" />
		</div>
	</div>

	<script type="text/javascript" src="api/config.php"></script>
	<script type="text/javascript" src="resources/js/adminshortcut.js"></script>
	<script type="text/javascript" src="resources/js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="resources/js/vendor/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="resources/js/vendor/TweenLite.min.js"></script>
	<script type="text/javascript" src="resources/js/vendor/EasePack.min.js"></script>
	<script type="text/javascript" src="resources/js/vendor/jquery.gsap.min.js"></script>
	<script type="text/javascript" src="resources/js/vendor/CSSPlugin.min.js"></script>
	<script type="text/javascript" src="resources/js/photoswipe.min.js"></script>
	<script type="text/javascript" src="resources/js/photoswipe/dist/photoswipe-ui-default.min.js"></script>
	<script type="text/javascript" src="resources/js/photoinit.js"></script>
	<script type="text/javascript" src="resources/js/theme.js"></script>
	<script type="text/javascript" src="resources/js/core.js"></script>
	<script type="text/javascript" src="resources/lang/<?php echo $config['language']; ?>.js"></script>
</body>
</html>