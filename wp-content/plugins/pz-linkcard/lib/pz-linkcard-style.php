<?php if (!function_exists("get_option")) die; ?>
<?php
	if (!isset($this->options['style']) || !$this->options['style']) {

		// $css_file = plugin_dir_path(__FILE__).'style.css';
		// $css_url  = plugin_dir_url(__FILE__).'style.css';
		$wp_upload_dir	= wp_upload_dir();
		$css_dir		= $wp_upload_dir['basedir'].'/'.$this->slug;
		$css_path = $wp_upload_dir['basedir'].'/'.$this->slug.'/style.css';
		$css_url  = $wp_upload_dir['baseurl'].'/'.$this->slug.'/style.css';
		if (!is_dir($css_dir)) {
			if (!wp_mkdir_p($css_dir)) {
				$css_path = $wp_upload_dir['basedir'].'/'.$this->slug.'-style.css';
				$css_url  = $wp_upload_dir['baseurl'].'/'.$this->slug.'-style.css';
			}
		}
		if (preg_match('/.*(\/\/.*)/', $css_url, $m)) {
			$css_url = $m[1];
		}
		if (is_null($this->options['css-path']) || is_null($this->options['css-url']) || $this->options['css-path'] <> $css_path || $this->options['css-url']  <> $css_url) {
			$this->options['css-path'] = $css_path;
			$this->options['css-url']  = $css_url;
			update_site_option('Pz_LinkCard_options', $this->options);
		}

		$temp_name = $this->plugin_dir_path.'templete/pz-linkcard-templete.css'; // 元となるテンプレート

		$file_text = file_get_contents($temp_name);
		if ($file_text) {
			// バージョン
			$file_text = str_replace('/*VERSION*/', $this->options['plugin-version'], $file_text );
			
			// オマケ書式
			switch ($this->options['special-format']) {
			case 'LkC': // Pz-LkC Default
				$file_text = str_replace('/*EX-IMAGE*/', 'background-image: linear-gradient(#78f 0%, #78f 10%, #fff 30%);', $file_text );
				$file_text = str_replace('/*IN-IMAGE*/', 'background-image: linear-gradient(#ca4 0%, #ca4 10%, #fff 30%);', $file_text );
				$file_text = str_replace('/*TH-IMAGE*/', 'background-image: linear-gradient(#ca4 0%, #ca4 10%, #eee 30%);', $file_text );
				switch ($this->options['info-position']) {
				case '1':
					$file_text = str_replace('/*COLOR-INFO*/',		'color: #fff;', $file_text );
					$file_text = str_replace('/*COLOR-ADDED*/',		'color: #fff;', $file_text );
				}
				$file_text = str_replace('/*THUMBNAIL_POSITION*/',	'float: left;', $file_text );
				break;
			case 'smp': // Hatena Blogcard
				$file_text = str_replace('/*BORDER*/',			'border: none;', $file_text );
				$file_text = str_replace('/*NONE-INFO*/',		'display: none !important;', $file_text );
				$file_text = str_replace('/*NONE-EXCERPT*/',	'display: none !important;', $file_text );
				break;
			case 'hbc': // Hatena Blogcard
				$file_text = str_replace('/*BORDER*/',			'border: 1px solid rgba(0,0,0,0.1);', $file_text );
				$file_text = str_replace('/*RADIUS*/',			'border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px;', $file_text );
				$file_text = str_replace('/*SHADOW*/',			'box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);', $file_text );
				break;
			case 'JIN': // Headline
				$file_text = str_replace('/*MARGIN-TOP*/',		'margin-top: 24px;', $file_text );
				$file_text = str_replace('/*MARGIN-RIGHT*/',	'margin-right: auto;', $file_text );
				$file_text = str_replace('/*MARGIN-BOTTOM*/',	'margin-bottom: 30px;', $file_text );
				$file_text = str_replace('/*MARGIN-LEFT*/',		'margin-left: auto;', $file_text );
				$file_text = str_replace('/*CARD-TOP*/',		'margin-top: 24px;', $file_text );
				$file_text = str_replace('/*CARD-RIGHT*/',		'margin-right: 20px;', $file_text );
				$file_text = str_replace('/*CARD-BOTTOM*/',		'margin-bottom: 20px;', $file_text );
				$file_text = str_replace('/*CARD-LEFT*/',		'margin-left: 20px;', $file_text );
				$file_text = str_replace('/*WIDTH*/',			'max-width: 96%;', $file_text );
				$file_text = str_replace('/*RADIUS*/',			'border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px;', $file_text );
				$file_text = str_replace('/*LINKCARD-WRAP-MARGIN*/',	'margin: 0 auto;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-WIDTH*/',			'max-width: 150px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-HEIGHT*/',		'height: 108px; overflow: hidden;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-IMG-WIDTH*/',		'width: 150px;', $file_text );
				$file_text = str_replace('/*OPACITY*/',			'opacity: 0.8;', $file_text );
				$file_text = str_replace('/*OPTION*/',			'.linkcard p { display: none; }', $file_text );
				$file_text = str_replace('/*COLOR-ADDED*/',		'color: #fff;', $file_text );
				$file_text = str_replace('/*SIZE-ADDED*/',		'font-size: 12px;', $file_text );
				$file_text = str_replace('/*HEIGHT-ADDED*/',	'line-height: 30px;', $file_text );
				$added_height	=	intval(preg_replace('/[^0-9]/', '', isset($this->options['height-added'] ) ? $this->options['height-added']  : $this->defaults['height-added']  ) );
				$heading_height	=	intval( $added_height / 2 );
				$heading_padding =	intval( $added_height / 4 );
				$file_text		=	str_replace('/*HEADING*/',	'position: absolute; top: -15px; left: 20px; padding: 0 10px; background-color: '.$this->options['border-color'].'; border-radius: 2px;', $file_text );
				if (isset($this->options['thumbnail-resize']) && $this->options['thumbnail-resize'] == '1') {
					$size_title			=	intval(preg_replace('/[^0-9]/', '', isset($this->options['size-title']) ? $this->options['size-title'] : $this->defaults['size-title'] ) );
					$size_excerpt		=	intval(preg_replace('/[^0-9]/', '', isset($this->options['size-excerpt']) ? $this->options['size-excerpt'] : $this->defaults['size-excerpt'] ) );
					$height_title		=	intval(preg_replace('/[^0-9]/', '', isset($this->options['height-title']) ? $this->options['height-title'] : $this->defaults['height-title'] ) );
					$height_excerpt		=	intval(preg_replace('/[^0-9]/', '', isset($this->options['height-excerpt']) ? $this->options['height-excerpt'] : $this->defaults['height-excerpt'] ) );
					$thumbnail_width	=	150;
					$file_text = str_replace('/*RESIZE*/',
						'@media screen and (max-width: 767px)  {'.PHP_EOL.' .lkc-internal-wrap { max-width: 100% }'.PHP_EOL.' .lkc-external-wrap { max-width: 100% }'.PHP_EOL.' .lkc-this-wrap { max-width: 100% }'.PHP_EOL.' .lkc-title { font-size: '.intval($size_title * 0.9).'px; line-height: '.intval($height_title * 0.9).'px; }'.PHP_EOL.' .lkc-excerpt { font-size: '.intval($size_excerpt * 0.95).'px; }'.PHP_EOL.' .lkc-thumbnail { max-width: '.intval($thumbnail_width * 0.9).'px; }'.PHP_EOL.' .lkc-thumbnail-img { max-width: '.intval($thumbnail_width * 0.9).'px; }'.PHP_EOL.'}'.PHP_EOL.
						'@media screen and (max-width: 512px)  {'.PHP_EOL.' .lkc-internal-wrap { max-width: 100% }'.PHP_EOL.' .lkc-external-wrap { max-width: 100% }'.PHP_EOL.' .lkc-this-wrap { max-width: 100% }'.PHP_EOL.' .lkc-title { font-size: '.intval($size_title * 0.8).'px; line-height: '.intval($height_title * 0.8).'px; }'.PHP_EOL.' .lkc-excerpt { font-size: '.intval($size_excerpt * 0.8).'px; }'.PHP_EOL.' .lkc-thumbnail { max-width: '.intval($thumbnail_width * 0.7).'px; }'.PHP_EOL.' .lkc-thumbnail-img { max-width: '.intval($thumbnail_width * 0.7).'px; }'.PHP_EOL.'}'.PHP_EOL.
						'@media screen and (max-width: 320px)  {'.PHP_EOL.' .lkc-internal-wrap { max-width: 100% }'.PHP_EOL.' .lkc-external-wrap { max-width: 100% }'.PHP_EOL.' .lkc-this-wrap { max-width: 100% }'.PHP_EOL.' .lkc-title { font-size: '.intval($size_title * 0.7).'px; line-height: '.intval($height_title * 0.7).'px; }'.PHP_EOL.' .lkc-excerpt { font-size: '.intval($size_excerpt * 0.6).'px; }'.PHP_EOL.' .lkc-thumbnail { max-width: '.intval($thumbnail_width * 0.5).'px; }'.PHP_EOL.' .lkc-thumbnail-img { max-width: '.intval($thumbnail_width * 0.5).'px; }'.PHP_EOL.'}', $file_text );
				}
				break;
			case 'sqr': // Square
				$file_text = str_replace('/*HEIGHT*/',					'height: 337px;', $file_text );
				$file_text = str_replace('/*CONTENT-HEIGHT*/',			'height: 300px;', $file_text );
				$thumbnail_width	= preg_replace('/[^0-9]/', 			'', isset($this->options['width']) ? $this->options['width'] : $this->defaults['thumbnail-width'] ) - 0;
				$file_text = str_replace('/*THUMBNAIL-WIDTH*/',			'display: block; overflow: hidden;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-HEIGHT*/',		'max-height: 200px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-IMG-WIDTH*/',		'width: '.$thumbnail_width .'px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-IMG-HEIGHT*/',	'', $file_text );
				break;
			case 'ct1': // Cellophane tape center
				$file_text = str_replace('/*WRAP*/',			'position: relative;', $file_text );
				$file_text = str_replace('/*WRAP-BEFORE*/',		'content: "";display: block;position: absolute;left: 40%;top: -16px;width: 95px;height: 25px;z-index: 2;background-color: rgba(243,245,228,0.5);border: 2px solid rgba(255,255,255,0.5);-webkit-box-shadow: 1px 1px 4px rgba(200,200,180,0.8);-moz-box-shadow: 1px 1px 4px rgba(200,200,180,0.8);box-shadow: 1px 1px 4px rgba(200,200,180,0.8);-webkit-transform: rotate(3deg);-moz-transform: rotate(3deg);-o-transform: rotate(3deg);', $file_text );
				$file_text = str_replace('/*SHADOW*/',			'box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.2);', $file_text );
				break;
			case 'ct2': // Cellophane tape left right
				$file_text = str_replace('/*WRAP*/',			'position: relative;', $file_text );
				$file_text = str_replace('/*MARGIN-LEFT*/',		'margin-left: 40px;', $file_text );
				$file_text = str_replace('/*WRAP-BEFORE*/',		'content: "";display: block;position: absolute;left: -40px;top: -4px;width: 75px;height: 25px;z-index: 2;background-color: rgba(243,245,228,0.5);border: 2px solid rgba(255,255,255,0.5);-webkit-box-shadow: 1px 1px 4px rgba(200,200,180,0.8);-moz-box-shadow: 1px 1px 4px rgba(200,200,180,0.8);box-shadow: 1px 1px 4px rgba(200,200,180,0.8);-webkit-transform: rotate(-45deg);-moz-transform: rotate(-45deg);-o-transform: rotate(-45deg);', $file_text );
				$file_text = str_replace('/*WRAP-AFTER*/',		'content: "";display: block;position: absolute;right: -20px;top: -2px;width: 75px;height: 25px;z-index: 2;background-color: rgba(243,245,228,0.5);border: 2px solid rgba(255,255,255,0.5);-webkit-box-shadow: 1px 1px 4px rgba(200,200,180,0.8);-moz-box-shadow: 1px 1px 4px rgba(200,200,180,0.8);box-shadow: 1px 1px 4px rgba(200,200,180,0.8);-webkit-transform: rotate(16deg);-moz-transform: rotate(16deg);-o-transform: rotate(16deg);transform: rotate(16deg);', $file_text );
				$file_text = str_replace('/*MARGIN-RIGHT*/',	'margin-right: 25px;', $file_text );
				$file_text = str_replace('/*SHADOW*/',			'box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.2);', $file_text );
				break;
			case 'ct3': // Cellophane long
				$file_text = str_replace('/*WRAP*/', 			'position: relative;', $file_text );
				$file_text = str_replace('/*WRAP-BEFORE*/', 	'content: "";display: block;position: absolute;left: -5%;top: -12px;width: 110%;height: 25px;z-index: 2;background-color: rgba(243,245,228,0.5);border: 2px solid rgba(255,255,255,0.5);-webkit-box-shadow: 1px 1px 4px rgba(200,200,180,0.8);-moz-box-shadow: 1px 1px 4px rgba(200,200,180,0.8);box-shadow: 1px 1px 4px rgba(200,200,180,0.8);-webkit-transform: rotate(-3deg);-moz-transform: rotate(-3deg);-o-transform: rotate(-3deg);', $file_text );
				$file_text = str_replace('/*MARGIN-LEFT*/',		'margin-left: 32px;', $file_text );
				$file_text = str_replace('/*MARGIN-RIGHT*/',	'margin-right: 32px;', $file_text );
				$file_text = str_replace('/*SHADOW*/',			'box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.2);', $file_text );
				break;
			case 'slt': // Slanting
				$file_text = str_replace('/*WRAP*/',			'transform:skew(-10deg) rotate(1deg);-webkit-transform: skew(-10deg) rotate(1deg);-moz-transform:skew(-10deg) rotate(1deg);', $file_text );
				$file_text = str_replace('/*MARGIN-LEFT*/',		'margin-left: 12px;', $file_text );
				$file_text = str_replace('/*MARGIN-RIGHT*/',	'margin-right: 30px;', $file_text );
				break;
			case '3Dr': // 3D rotate
				$file_text = str_replace('/*WRAP*/',			'-webkit-transform:perspective(150px) scale3d(0.84,0.9,1) rotate3d(1,0,0,12deg);', $file_text );
				$file_text = str_replace('/*SHADOW*/',			'box-shadow: 0 20px 16px rgba(0, 0, 0, 0.6) , 0px 32px 32px rgba(0, 0, 0, 0.2) inset;', $file_text );
				break;
			case 'ppc': // Paper Curling
				$file_text = str_replace('/*WRAP*/',			'position: relative;', $file_text );
				$file_text = str_replace('/*WRAP-AFTER*/',		'z-index: -1; content:""; height: 10px; width: 60%; position: absolute; right: 16px; bottom: 14px; left: auto; transform: skew(5deg) rotate(3deg); -webkit-transform: skew(5deg) rotate(3deg); -moz-transform: skew(5deg) rotate(3deg); box-shadow: 0 16px 16px rgba(0,0,0,1); -webkit-box-shadow: 0 16px 16px rgba(0,0,0,1); -moz-box-shadow: 0 16px 12px rgba(0,0,0,1);', $file_text );
				$file_text = str_replace('/*SHADOW*/',			'box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.8);', $file_text );
				$file_text = str_replace('/*OPTION*/',			'article { position: relative; z-index: 0; } article blockquote { position: relative; z-index: 0; }', $file_text );
				break;
			case 'tac': // Taping and curling
				$file_text = str_replace('/*WRAP*/',			'position: relative;', $file_text );
				$file_text = str_replace('/*WRAP-BEFORE*/',		'content: ""; display: block; position: absolute; left: -24px; top: 0px; width: 200px; height: 25px; z-index: 2; background-color: rgba(243,245,228,0.5); border: 2px solid rgba(255,255,255,0.5); -webkit-box-shadow: 1px 1px 4px rgba(200,200,180,0.8); -moz-box-shadow: 1px 1px 4px rgba(200,200,180,0.8); box-shadow: 1px 1px 4px rgba(200,200,180,0.8); -webkit-transform: rotate(-8deg); -moz-transform: rotate(-8deg); -o-transform: rotate(-8deg);', $file_text );
				$file_text = str_replace('/*WRAP-AFTER*/',		'z-index: -1; content:""; height: 10px; width: 60%; position: absolute; right: 16px; bottom: 14px; left: auto; transform: skew(5deg) rotate(3deg); -webkit-transform: skew(5deg) rotate(3deg); -moz-transform: skew(5deg) rotate(3deg); box-shadow: 0 16px 16px rgba(0,0,0,1); -webkit-box-shadow: 0 16px 16px rgba(0,0,0,1); -moz-box-shadow: 0 16px 12px rgba(0,0,0,1);', $file_text );
				$file_text = str_replace('/*MARGIN-LEFT*/',		'margin-left: 24px;', $file_text );
				$file_text = str_replace('/*SHADOW*/',			'box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.8);', $file_text );
				$file_text = str_replace('/*OPTION*/',			'article { position: relative; z-index: 0; } article blockquote { position: relative; z-index: 0; }', $file_text );
				break;
			case 'stR': // Stitch red
				$file_text = str_replace('/*WRAP*/',			'position: relative;', $file_text );
				$file_text = str_replace('/*WRAP-BEFORE*/',		'content: ""; display: block; position: absolute; left: -24px; top: 0px; width: 200px; height: 25px; z-index: 2; background-color: rgba(243,245,228,0.5); border: 2px solid rgba(255,255,255,0.5); -webkit-box-shadow: 1px 1px 4px rgba(200,200,180,0.8); -moz-box-shadow: 1px 1px 4px rgba(200,200,180,0.8); box-shadow: 1px 1px 4px rgba(200,200,180,0.8); -webkit-transform: rotate(-8deg); -moz-transform: rotate(-8deg); -o-transform: rotate(-8deg);', $file_text );
				$file_text = str_replace('/*WRAP-AFTER*/',		'z-index: -1; content:""; height: 10px; width: 60%; position: absolute; right: 16px; bottom: 14px; left: auto; transform: skew(5deg) rotate(3deg); -webkit-transform: skew(5deg) rotate(3deg); -moz-transform: skew(5deg) rotate(3deg); box-shadow: 0 16px 16px rgba(0,0,0,1); -webkit-box-shadow: 0 16px 16px rgba(0,0,0,1); -moz-box-shadow: 0 16px 12px rgba(0,0,0,1);', $file_text );
				$file_text = str_replace('/*MARGIN-LEFT*/',		'margin-left: 24px;', $file_text );
				$file_text = str_replace('/*SHADOW*/',			'box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.8);', $file_text );
				$file_text = str_replace('/*OPTION*/',			'article { position: relative; z-index: 0; } article blockquote { position: relative; z-index: 0; }', $file_text );
				break;
			case 'pin': // Pushpin
				$file_text = str_replace('/*WRAP*/', 			'position: relative;', $file_text );
				$file_text = str_replace('/*WRAP-AFTER*/',		'content: ""; display: block; position: absolute; background-image: url("'.$this->plugin_dir_url.'img/pin.png"); background-repeat: no-repeat; background-position: center; left: 47%; top: -16px; width: 40px; height: 40px; z-index: 1;', $file_text );
				break;
			case 'inN': // Neutral
				$file_text = str_replace('/*BORDER*/',			'border: 4px solid #59fbea;', $file_text );
				$file_text = str_replace('/*COLOR-TITLE*/',		'color: #59fbea;', $file_text );
				$file_text = str_replace('/*COLOR-URL*/',		'color: #59fbea;', $file_text );
				$file_text = str_replace('/*COLOR-EXCERPT*/',	'color: #59fbea;', $file_text );
				$file_text = str_replace('/*COLOR-INFO*/',		'color: #59fbea;', $file_text );
				$file_text = str_replace('/*COLOR-PLUGIN*/',	'color: #59fbea;', $file_text );
				$file_text = str_replace('/*EX-BGCOLOR*/',		'background-color: rgba( 35,100, 93,0.9);', $file_text );
				$file_text = str_replace('/*IN-BGCOLOR*/',		'background-color: rgba(  8, 25, 23,0.9);', $file_text );
				$file_text = str_replace('/*TH-BGCOLOR*/',		'background-color: rgba( 89,251,234,0.05);', $file_text );
				break;
			case 'inI': // Orange
				$file_text = str_replace('/*BORDER*/', 			'border: 4px solid #ebbc4a;', $file_text );
				$file_text = str_replace('/*COLOR-TITLE*/',		'color: #ebbc4a;', $file_text );
				$file_text = str_replace('/*COLOR-URL*/',		'color: #ebbc4a;', $file_text );
				$file_text = str_replace('/*COLOR-EXCERPT*/',	'color: #ebbc4a;', $file_text );
				$file_text = str_replace('/*COLOR-INFO*/',		'color: #ebbc4a;', $file_text );
				$file_text = str_replace('/*COLOR-PLUGIN*/',	'color: #ebbc4a;', $file_text );
				$file_text = str_replace('/*EX-BGCOLOR*/',		'background-color: rgba( 94, 75, 29,0.9);', $file_text );
				$file_text = str_replace('/*IN-BGCOLOR*/',		'background-color: rgba( 23, 18,  7,0.9);', $file_text );
				$file_text = str_replace('/*TH-BGCOLOR*/',		'background-color: rgba(235,188, 74,0.05);', $file_text );
				break;
			case 'inE': // Green
				$file_text = str_replace('/*BORDER*/',			'border: 4px solid #28f428;', $file_text );
				$file_text = str_replace('/*COLOR-TITLE*/',		'color: #28f428;', $file_text );
				$file_text = str_replace('/*COLOR-URL*/',		'color: #28f428;', $file_text );
				$file_text = str_replace('/*COLOR-EXCERPT*/',	'color: #28f428;', $file_text );
				$file_text = str_replace('/*COLOR-INFO*/',		'color: #28f428;', $file_text );
				$file_text = str_replace('/*COLOR-PLUGIN*/',	'color: #28f428;', $file_text );
				$file_text = str_replace('/*EX-BGCOLOR*/',		'background-color: rgba( 16, 97, 16,0.9);', $file_text );
				$file_text = str_replace('/*IN-BGCOLOR*/',		'background-color: rgba(  4, 24,  4,0.9);', $file_text );
				$file_text = str_replace('/*TH-BGCOLOR*/',		'background-color: rgba( 40,244, 40,0.05);', $file_text );
				break;
			case 'inR': // Blue
				$file_text = str_replace('/*BORDER*/',			'border: 4px solid #00c2ff;', $file_text );
				$file_text = str_replace('/*COLOR-TITLE*/',		'color: #00c2ff;', $file_text );
				$file_text = str_replace('/*COLOR-URL*/',		'color: #00c2ff;', $file_text );
				$file_text = str_replace('/*COLOR-EXCERPT*/',	'color: #00c2ff;', $file_text );
				$file_text = str_replace('/*COLOR-INFO*/',		'color: #00c2ff;', $file_text );
				$file_text = str_replace('/*COLOR-PLUGIN*/',	'color: #00c2ff;', $file_text );
				$file_text = str_replace('/*EX-BGCOLOR*/',		'background-color: rgba(  0, 77,102,0.9);', $file_text );
				$file_text = str_replace('/*IN-BGCOLOR*/',		'background-color: rgba(  0, 19, 25,0.9);', $file_text );
				$file_text = str_replace('/*TH-BGCOLOR*/',		'background-color: rgba(  0,194,255,0.05);', $file_text );
				break;
			case 'sBR': // Stitch blue&red
				$file_text = str_replace('/*BORDER*/',			'border: 2px dashed rgba(255,255,255,0.5);', $file_text );
				$file_text = str_replace('/*EX-BGCOLOR*/',		'background: #bcddff; box-shadow: 0 0 0 5px #aabbee, 3px 3px 6px 4px rgba(0,0,0,0.6); -moz-box-shadow: 0 0 0 5px #aabbee, 3px 3px 6px 4px rgba(0,0,0,0.6); -webkit-box-shadow: 0 0 0 5px #aabbee, 3px 3px 6px 4px rgba(0,0,0,0.6);', $file_text );
				$file_text = str_replace('/*IN-BGCOLOR*/',		'background: #f8d0d0; box-shadow: 0 0 0 5px #e8a8a8, 3px 3px 6px 4px rgba(0,0,0,0.6); -moz-box-shadow: 0 0 0 5px #e8a8a8, 3px 3px 6px 4px rgba(0,0,0,0.6); -webkit-box-shadow: 0 0 0 5px #e8a8a8, 3px 3px 6px 4px rgba(0,0,0,0.6);', $file_text );
				$file_text = str_replace('/*TH-BGCOLOR*/',		'background: #f29db0; box-shadow: 0 0 0 5px #de8899, 3px 3px 6px 4px rgba(0,0,0,0.6); -moz-box-shadow: 0 0 0 5px #de8899, 3px 3px 6px 4px rgba(0,0,0,0.6); -webkit-box-shadow: 0 0 0 5px #de8899, 3px 3px 6px 4px rgba(0,0,0,0.6);', $file_text );
				break;
			case 'sGY': // Stitch green&yellow
				$file_text = str_replace('/*BORDER*/',			'border: 2px dashed rgba(255,255,255,0.5);', $file_text );
				$file_text = str_replace('/*EX-BGCOLOR*/',		'background: #acefdd; box-shadow: 0 0 0 5px #8abecb, 3px 3px 6px 4px rgba(0,0,0,0.6); -moz-box-shadow: 0 0 0 5px #8abecb, 3px 3px 6px 4px rgba(0,0,0,0.6); -webkit-box-shadow: 0 0 0 5px #8abecb, 3px 3px 6px 4px rgba(0,0,0,0.6);', $file_text );
				$file_text = str_replace('/*IN-BGCOLOR*/',		'background: #ffde51; box-shadow: 0 0 0 5px #fbca4d, 3px 3px 6px 4px rgba(0,0,0,0.6); -moz-box-shadow: 0 0 0 5px #fbca4d, 3px 3px 6px 4px rgba(0,0,0,0.6); -webkit-box-shadow: 0 0 0 5px #fbca4d, 3px 3px 6px 4px rgba(0,0,0,0.6);', $file_text );
				$file_text = str_replace('/*TH-BGCOLOR*/',		'background: #f0e0b0; box-shadow: 0 0 0 5px #decca0, 3px 3px 6px 4px rgba(0,0,0,0.6); -moz-box-shadow: 0 0 0 5px #decca0, 3px 3px 6px 4px rgba(0,0,0,0.6); -webkit-box-shadow: 0 0 0 5px #decca0, 3px 3px 6px 4px rgba(0,0,0,0.6);', $file_text );
				break;
			}

			// 文字色
			$file_text = str_replace('/*COLOR-TITLE*/',		'color: '.$this->options['color-title'].';', $file_text );
			$file_text = str_replace('/*COLOR-URL*/',		'color: '.$this->options['color-url'].';', $file_text );
			$file_text = str_replace('/*COLOR-EXCERPT*/',	'color: '.$this->options['color-excerpt'].';', $file_text );
			$file_text = str_replace('/*COLOR-INFO*/',		'color: '.$this->options['color-info'].';', $file_text );
			if (!$this->options['color-added']) {
				$this->options['color-added']	=	$this->options['color-info'];
				$this->options['size-added']	=	$this->options['size-info'];
				$this->options['height-added']	=	$this->options['height-info'];
				$this->options['outline-added']	=	$this->options['outline-info'];
			}
			$file_text = str_replace('/*COLOR-ADDED*/',		'color: '.$this->options['color-added'].';', $file_text );
			$file_text = str_replace('/*COLOR-MORE*/',		'color: '.$this->options['color-more'].';', $file_text );
			$file_text = str_replace('/*COLOR-PLUGIN*/',	'color: '.$this->options['color-plugin'].';', $file_text );

			// 文字の大きさ
			$file_text = str_replace('/*SIZE-TITLE*/',		'font-size: '.$this->options['size-title'].';', $file_text );
			$file_text = str_replace('/*SIZE-URL*/',		'font-size: '.$this->options['size-url'].';', $file_text );
			$file_text = str_replace('/*SIZE-EXCERPT*/',	'font-size: '.$this->options['size-excerpt'].';', $file_text );
			$file_text = str_replace('/*SIZE-INFO*/',		'font-size: '.$this->options['size-info'].';', $file_text );
			$file_text = str_replace('/*SIZE-ADDED*/',		'font-size: '.$this->options['size-added'].';', $file_text );
			$file_text = str_replace('/*SIZE-MORE*/',		'font-size: '.$this->options['size-more'].';', $file_text );
			$file_text = str_replace('/*SIZE-PLUGIN*/',		'font-size: '.$this->options['size-plugin'].';', $file_text );

			// 行の高さ
			$file_text = str_replace('/*HEIGHT-TITLE*/',	'line-height: '.$this->options['height-title'].';', $file_text );
			$file_text = str_replace('/*HEIGHT-URL*/',		'line-height: '.$this->options['height-url'].';', $file_text );
			$file_text = str_replace('/*HEIGHT-EXCERPT*/',	'line-height: '.$this->options['height-excerpt'].';', $file_text );
			$file_text = str_replace('/*HEIGHT-INFO*/',		'line-height: '.$this->options['height-info'].';', $file_text );
			$file_text = str_replace('/*HEIGHT-ADDED*/',	'line-height: '.$this->options['height-added'].';', $file_text );
			$file_text = str_replace('/*HEIGHT-MORE*/',		'line-height: '.$this->options['height-more'].';', $file_text );
			$file_text = str_replace('/*HEIGHT-PLUGIN*/',	'line-height: '.$this->options['height-plugin'].';', $file_text );

			// 文字の縁取り
			if (isset($this->options['outline-title']) && $this->options['outline-title'] == '1') {
				$file_text = str_replace('/*OUTCOLOR-TITLE*/',	'text-shadow: 0 -1px '.$this->options['outline-color-title'].', 1px -1px '.$this->options['outline-color-title'].', 1px 0 '.$this->options['outline-color-title'].', 1px 1px '.$this->options['outline-color-title'].', 0 1px '.$this->options['outline-color-title'].', -1px 1px '.$this->options['outline-color-title'].', -1px 0 '.$this->options['outline-color-title'].', -1px -1px '.$this->options['outline-color-title'].';', $file_text );
			}
			if (isset($this->options['outline-url']) && $this->options['outline-url'] == '1') {
				$file_text = str_replace('/*OUTCOLOR-URL*/',	'text-shadow: 0 -1px '.$this->options['outline-color-url'].', 1px -1px '.$this->options['outline-color-url'].', 1px 0 '.$this->options['outline-color-url'].', 1px 1px '.$this->options['outline-color-url'].', 0 1px '.$this->options['outline-color-url'].', -1px 1px '.$this->options['outline-color-url'].', -1px 0 '.$this->options['outline-color-url'].', -1px -1px '.$this->options['outline-color-url'].';', $file_text );
			}
			if (isset($this->options['outline-excerpt']) && $this->options['outline-excerpt'] == '1') {
				$file_text = str_replace('/*OUTCOLOR-EXCERPT*/','text-shadow: 0 -1px '.$this->options['outline-color-excerpt'].', 1px -1px '.$this->options['outline-color-excerpt'].', 1px 0 '.$this->options['outline-color-excerpt'].', 1px 1px '.$this->options['outline-color-excerpt'].', 0 1px '.$this->options['outline-color-excerpt'].', -1px 1px '.$this->options['outline-color-excerpt'].', -1px 0 '.$this->options['outline-color-excerpt'].', -1px -1px '.$this->options['outline-color-excerpt'].';', $file_text );
			}
			if (isset($this->options['outline-info']) && $this->options['outline-info'] == '1') {
				$file_text = str_replace('/*OUTCOLOR-INFO*/',	'text-shadow: 0 -1px '.$this->options['outline-color-info'].', 1px -1px '.$this->options['outline-color-info'].', 1px 0 '.$this->options['outline-color-info'].', 1px 1px '.$this->options['outline-color-info'].', 0 1px '.$this->options['outline-color-info'].', -1px 1px '.$this->options['outline-color-info'].', -1px 0 '.$this->options['outline-color-info'].', -1px -1px '.$this->options['outline-color-info'].';', $file_text );
			}
			if (isset($this->options['outline-added']) && $this->options['outline-added'] == '1') {
				$file_text = str_replace('/*OUTCOLOR-ADDED*/',	'text-shadow: 0 -1px '.$this->options['outline-color-added'].', 1px -1px '.$this->options['outline-color-added'].', 1px 0 '.$this->options['outline-color-added'].', 1px 1px '.$this->options['outline-color-added'].', 0 1px '.$this->options['outline-color-added'].', -1px 1px '.$this->options['outline-color-added'].', -1px 0 '.$this->options['outline-color-added'].', -1px -1px '.$this->options['outline-color-added'].';', $file_text );
			}
			if (isset($this->options['outline-more']) && $this->options['outline-more'] == '1') {
				$file_text = str_replace('/*OUTCOLOR-MORE*/',	'text-shadow: 0 -1px '.$this->options['outline-color-more'].', 1px -1px '.$this->options['outline-color-more'].', 1px 0 '.$this->options['outline-color-more'].', 1px 1px '.$this->options['outline-color-more'].', 0 1px '.$this->options['outline-color-more'].', -1px 1px '.$this->options['outline-color-more'].', -1px 0 '.$this->options['outline-color-more'].', -1px -1px '.$this->options['outline-color-more'].';', $file_text );
			}
			if (isset($this->options['outline-plugin']) && $this->options['outline-plugin'] == '1') {
				$file_text = str_replace('/*OUTCOLOR-PLUGIN*/',	'text-shadow: 0 -1px '.$this->options['outline-color-plugin'].', 1px -1px '.$this->options['outline-color-plugin'].', 1px 0 '.$this->options['outline-color-plugin'].', 1px 1px '.$this->options['outline-color-plugin'].', 0 1px '.$this->options['outline-color-plugin'].', -1px 1px '.$this->options['outline-color-plugin'].', -1px 0 '.$this->options['outline-color-plugin'].', -1px -1px '.$this->options['outline-color-plugin'].';', $file_text );
			}

			// カードの周りへの余白
			if ($this->options['margin-top']) {
				$file_text = str_replace('/*MARGIN-TOP*/',		'margin-top: '.$this->options['margin-top'].';', $file_text );
			}
			if ($this->options['margin-right']) {
				$file_text = str_replace('/*MARGIN-RIGHT*/',	'margin-right: '.$this->options['margin-right'].';', $file_text );
			}
			if ($this->options['margin-bottom']) {
				$file_text = str_replace('/*MARGIN-BOTTOM*/',	'margin-bottom: '.$this->options['margin-bottom'].';', $file_text );
			}
			if ($this->options['margin-left']) {
				$file_text = str_replace('/*MARGIN-LEFT*/',		'margin-left: '.$this->options['margin-left'].';', $file_text );
			}

			// カードの余白等調整
			$file_text = str_replace('/*PADDING*/',				'padding: 0;', $file_text );

			// カード内側の余白
			if ($this->options['card-top']) {
				$file_text = str_replace('/*CARD-TOP*/',		'margin-top: '.$this->options['card-top'].';', $file_text );
			} else {
				$file_text = str_replace('/*CARD-TOP*/',		'margin-top: 7px;', $file_text );
			}
			if ($this->options['card-right']) {
				$file_text = str_replace('/*CARD-RIGHT*/',		'margin-right: '.$this->options['card-right'].';', $file_text );
			} else {
				$file_text = str_replace('/*CARD-RIGHT*/',		'margin-right: 7px;', $file_text );
			}
			if ($this->options['card-bottom']) {
				$file_text = str_replace('/*CARD-BOTTOM*/',		'margin-bottom: '.$this->options['card-bottom'].';', $file_text );
			} else {
				$file_text = str_replace('/*CARD-BOTTOM*/',		'margin-bottom: 7px;', $file_text );
			}
			if ($this->options['card-left']) {
				$file_text = str_replace('/*CARD-LEFT*/',		'margin-left: '.$this->options['card-left'].';', $file_text );
			} else {
				$file_text = str_replace('/*CARD-LEFT*/',		'margin-left: 7px;', $file_text );
			}

			// img のスタイルを強制リセット
			if (isset($this->options['style-reset-img'])) {
				$file_text = str_replace('/*RESET-IMG*/',		'margin: 0 !important; padding: 0; border: none;', $file_text );
				$file_text = str_replace('/*STATIC*/',			'position: static !important;', $file_text );
				$file_text = str_replace('/*IMPORTANT*/',		'!important', $file_text );
			} else {
				$file_text = str_replace('/*IMPORTANT*/',		'', $file_text );
			}

			// 外部リンク背景
			if ($this->options['ex-bgcolor']) {
				$file_text = str_replace('/*EX-BGCOLOR*/',		'background-color: '.$this->options['ex-bgcolor'].';', $file_text );
			}
			if ($this->options['ex-image']) {
				if (preg_match('/https?(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $this->options['ex-image'])) {
					$file_text = str_replace('/*EX-IMAGE*/',	'background-image: url("'.$this->options['ex-image'].'");', $file_text );
				} else {
					$file_text = str_replace('/*EX-IMAGE*/',	'background-image: '.$this->options['ex-image'].';', $file_text );
				}
			}

			// 内部リンク背景
			if ($this->options['in-bgcolor']) {
				$file_text = str_replace('/*IN-BGCOLOR*/',		'background-color: '.$this->options['in-bgcolor'].';', $file_text );
			}
			if ($this->options['in-image']) {
				if (preg_match('/https?(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $this->options['in-image'])) {
					$file_text = str_replace('/*IN-IMAGE*/',	'background-image: url("'.$this->options['in-image'].'");', $file_text );
				} else {
					$file_text = str_replace('/*IN-IMAGE*/',	'background-image: '.$this->options['in-image'].';', $file_text );
				}
			}

			// 同ページリンク背景色
			if ($this->options['th-bgcolor']) {
				$file_text = str_replace('/*TH-BGCOLOR*/',		'background-color: '.$this->options['th-bgcolor'].';', $file_text );
			}
			if ($this->options['th-image']) {
				if (preg_match('/https?(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $this->options['th-image'])) {
					$file_text = str_replace('/*TH-IMAGE*/',	'background-image: url("'.$this->options['th-image'].'");', $file_text );
				} else {
					$file_text = str_replace('/*TH-IMAGE*/',	'background-image: '.$this->options['th-image'].';', $file_text );
				}
			}

			// センタリング指定あり	
			if (isset($this->options['centering']) && $this->options['centering'] == '1') {
				$file_text = str_replace('/*LINKCARD-WRAP-MARGIN*/',	'margin: 0 auto;', $file_text );
				$file_text = str_replace('/*HATENA-WRAP-MARGIN*/',		'margin: 0 auto;', $file_text );
			} else {
				$file_text = str_replace('/*LINKCARD-WRAP-MARGIN*/', 	'margin: 0;', $file_text );
				$file_text = str_replace('/*HATENA-WRAP-MARGIN*/',		'margin: 0;', $file_text );
			}

			// 角まる指定あり
			switch ($this->options['radius']) {
			case null:
				$file_text = str_replace('/*RADIUS*/',					'', $file_text );
				$file_text = str_replace('/*THUMBNAIL-RADIUS*/',		'', $file_text );
				break;
			case '2':
				$file_text = str_replace('/*RADIUS*/',					'border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-RADIUS*/',		'border-radius: 2px; -webkit-border-radius: 2px; -moz-border-radius: 2px;', $file_text );
				break;
			case '1':
				$file_text = str_replace('/*RADIUS*/',					'border-radius: 8px; -webkit-border-radius: 8px; -moz-border-radius: 8px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-RADIUS*/',		'border-radius: 6px; -webkit-border-radius: 6px; -moz-border-radius: 6px;', $file_text );
				break;
			case '3':
				$file_text = str_replace('/*RADIUS*/',					'border-radius: 16px; -webkit-border-radius: 16px; -moz-border-radius: 16px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-RADIUS*/',		'border-radius: 8px; -webkit-border-radius: 8px; -moz-border-radius: 8px;', $file_text );
				break;
			case '4':
				$file_text = str_replace('/*RADIUS*/',					'border-radius: 32px; -webkit-border-radius: 32px; -moz-border-radius: 32px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-RADIUS*/',		'border-radius: 12px; -webkit-border-radius: 12px; -moz-border-radius: 12px;', $file_text );
				break;
			case '5':
				$file_text = str_replace('/*RADIUS*/',					'border-radius: 64px; -webkit-border-radius: 64px; -moz-border-radius: 64px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-RADIUS*/',		'border-radius: 16px; -webkit-border-radius: 16px; -moz-border-radius: 16px;', $file_text );
				break;
			}

			// 影あり
			if (isset($this->options['shadow']) && $this->options['shadow'] == '1') {
				if (isset($this->options['shadow-inset']) && $this->options['shadow-inset'] == '1') {
					$file_text = str_replace('/*SHADOW*/',		'box-shadow: 8px 8px 8px rgba(0, 0, 0, 0.5) , 0 0 16px rgba(0, 0, 0, 0.3) inset;', $file_text );
				} else {
					$file_text = str_replace('/*SHADOW*/',		'box-shadow: 8px 8px 8px rgba(0, 0, 0, 0.5);', $file_text );
				}
			} else {
				if (isset($this->options['shadow-inset']) && $this->options['shadow-inset'] == '1') {
					$file_text = str_replace('/*SHADOW*/',		'box-shadow: 0 0 16px rgba(0, 0, 0, 0.5) inset;', $file_text );
				}
			}

			// 薄める指定あり
			if (isset($this->options['opacity']) && $this->options['opacity'] == '1') {
				$file_text = str_replace('/*OPACITY*/',			'opacity: 0.8;', $file_text );
			}

			// サムネイルの位置とサイズ
			$thumbnail_width	= intval(preg_replace('/[^0-9]/', '', isset($this->options['thumbnail-width']) ? $this->options['thumbnail-width'] : $this->defaults['thumbnail-width'] ) );
			$thumbnail_height	= intval(preg_replace('/[^0-9]/', '', isset($this->options['thumbnail-height'] ) ? $this->options['thumbnail-height']  : $this->defaults['thumbnail-height']  ) );
			$content_width		= intval(preg_replace('/[^0-9]/', '', isset($this->options['width']) ? $this->options['width'] : $this->defaults['thumbnail-width'] ) );
			$content_height		= intval(preg_replace('/[^0-9]/', '', isset($this->options['content-height'] ) ? $this->options['content-height']  : $this->defaults['content-height']  ) );
			switch ($this->options['thumbnail-position']) {
			case '1':
				$file_text = str_replace('/*THUMBNAIL_POSITION*/',	'float: right;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-WIDTH*/',		'max-width: '.$thumbnail_width .'px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-HEIGHT*/',	'max-height: '.$thumbnail_height.'px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-IMG-WIDTH*/',	'width: '.$thumbnail_width .'px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-IMG-HEIGHT*/','max-height: '.$thumbnail_height.'px;', $file_text );
				break;
			case '2':
				$file_text = str_replace('/*THUMBNAIL_POSITION*/',	'float: left;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-WIDTH*/',		'max-width: '.$thumbnail_width .'px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-HEIGHT*/',	'max-height: '.$thumbnail_height.'px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-IMG-WIDTH*/',	'width: '.$thumbnail_width .'px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-IMG-HEIGHT*/','max-height: '.$thumbnail_height.'px;', $file_text );
				break;
			case '3':
				$file_text = str_replace('/*THUMBNAIL_POSITION*/',	'display: block;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-WIDTH*/',		'', $file_text );
				$file_text = str_replace('/*THUMBNAIL-HEIGHT*/',	'height: '.$thumbnail_height.'px; overflow: hidden;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-IMG-WIDTH*/',	'width: '.$content_width .'px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-IMG-HEIGHT*/','', $file_text );
				break;
			}

			// サムネイル影あり	
			if (isset($this->options['thumbnail-shadow']) && $this->options['thumbnail-shadow'] == '1') {
				$file_text = str_replace('/*THUMBNAIL-SHADOW*/',	'box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.5);', $file_text );
			}

			// サムネイルのリサイズ
			if (isset($this->options['thumbnail-resize']) && $this->options['thumbnail-resize'] == '1') {
				$size_title			=	intval(preg_replace('/[^0-9]/', '', isset($this->options['size-title']) ? $this->options['size-title'] : $this->defaults['size-title'] ) );
				$size_excerpt		=	intval(preg_replace('/[^0-9]/', '', isset($this->options['size-excerpt']) ? $this->options['size-excerpt'] : $this->defaults['size-excerpt'] ) );
				$height_title		=	intval(preg_replace('/[^0-9]/', '', isset($this->options['height-title']) ? $this->options['height-title'] : $this->defaults['height-title'] ) );
				$height_excerpt		=	intval(preg_replace('/[^0-9]/', '', isset($this->options['height-excerpt']) ? $this->options['height-excerpt'] : $this->defaults['height-excerpt'] ) );
				$thumbnail_width	=	intval(preg_replace('/[^0-9]/', '', isset($this->options['thumbnail-width']) ? $this->options['thumbnail-width'] : $this->defaults['thumbnail-width'] ) );
				$file_text = str_replace('/*RESIZE*/',
					'@media screen and (max-width: 600px)  {'.PHP_EOL.' .lkc-title { font-size: '.intval($size_title * 0.9).'px; line-height: '.intval($height_title * 0.9).'px; }'.PHP_EOL.' .lkc-excerpt { font-size: '.intval($size_excerpt * 0.95).'px; }'.PHP_EOL.' .lkc-thumbnail { max-width: '.intval($thumbnail_width * 0.9).'px; }'.PHP_EOL.' .lkc-thumbnail-img { max-width: '.intval($thumbnail_width * 0.9).'px; }'.PHP_EOL.'}'.PHP_EOL.
					'@media screen and (max-width: 480px)  {'.PHP_EOL.' .lkc-title { font-size: '.intval($size_title * 0.8).'px; line-height: '.intval($height_title * 0.8).'px; }'.PHP_EOL.' .lkc-excerpt { font-size: '.intval($size_excerpt * 0.8).'px; }'.PHP_EOL.' .lkc-thumbnail { max-width: '.intval($thumbnail_width * 0.7).'px; }'.PHP_EOL.' .lkc-thumbnail-img { max-width: '.intval($thumbnail_width * 0.7).'px; }'.PHP_EOL.'}'.PHP_EOL.
					'@media screen and (max-width: 320px)  {'.PHP_EOL.' .lkc-title { font-size: '.intval($size_title * 0.7).'px; line-height: '.intval($height_title * 0.7).'px; }'.PHP_EOL.' .lkc-excerpt { font-size: '.intval($size_excerpt * 0.6).'px; }'.PHP_EOL.' .lkc-thumbnail { max-width: '.intval($thumbnail_width * 0.5).'px; }'.PHP_EOL.' .lkc-thumbnail-img { max-width: '.intval($thumbnail_width * 0.5).'px; }'.PHP_EOL.'}', $file_text );
			}

			// 横幅
			if ($this->options['width']) {
				$file_text = str_replace('/*WIDTH*/',				'max-width: '.$this->options['width'].';', $file_text );
			} else {
				$file_text = str_replace('/*WIDTH*/',				'max-width: 100%;', $file_text );
			}

			// 記事情報の高さ
			if ($this->options['content-height']) {
				$file_text = str_replace('/*CONTENT-HEIGHT*/',		'height: '.$this->options['content-height'].';', $file_text );
			}

			// 枠線の太さ	
			switch (isset($this->options['border']) ? $this->options['border'] : '') {
			case '1gr':
				$file_text = str_replace('/*BORDER*/',	'border: 1px solid #ddd;', $file_text );
				break;
			case '2gr':
				$file_text = str_replace('/*BORDER*/',	'border: 2px solid #ddd;', $file_text );
				break;
			case '4gr':
				$file_text = str_replace('/*BORDER*/',	'border: 4px solid #ddd;', $file_text );
				break;
			case '1bk':
				$file_text = str_replace('/*BORDER*/',	'border: 1px solid #444;', $file_text );
				break;
			case '2bk':
				$file_text = str_replace('/*BORDER*/',	'border: 2px solid #444;', $file_text );
				break;
			case '4bk':
				$file_text = str_replace('/*BORDER*/',	'border: 4px solid #444;', $file_text );
				break;
			case '8bk':
				$file_text = str_replace('/*BORDER*/',	'border: 8px solid #444;', $file_text );
				break;
			case 'blu':
				$file_text = str_replace('/*BORDER*/',	'border: 4px solid #1e90ff;', $file_text );
				break;
			case 'gre':
				$file_text = str_replace('/*BORDER*/',	'border: 4px solid #66cdaa;', $file_text );
				break;
			case 'red':
				$file_text = str_replace('/*BORDER*/',	'border: 4px solid #ff69b4;', $file_text );
				break;
			case 'wht': // Wheat
				$file_text = str_replace('/*BORDER*/',	'border: 4px solid #f5deb3;', $file_text );
				break;
			case 'dbl':
				$file_text = str_replace('/*BORDER*/',	'border: 4px double #444;', $file_text );
				break;
			case 'dot':
				$file_text = str_replace('/*BORDER*/',	'border: 1px dotted #444;', $file_text );
				break;
			default:
				break;
			}

			// 枠線の太さ
			$border  = (preg_replace('/[^0-9]/', '', $this->options['border-width']) - 0).'px ';
			$border .= (isset($this->options['border-style']) ? $this->options['border-style'] : $this->defaults['border-style']).' ';
			$border .= (isset($this->options['border-color']) ? $this->options['border-color'] : $this->defaults['border-color']).';';
			$file_text = str_replace('/*BORDER*/',		'border: '.$border, $file_text );

			// 抜粋文の部分を凹ませる
			if (isset($this->options['content-inset']) && $this->options['content-inset'] == '1') {
				$file_text = str_replace('/*CONTENT-PADDING*/',	'padding: 6px;', $file_text );
				$file_text = str_replace('/*CONTENT-INSET*/',	'box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.5) inset;', $file_text );
				$file_text = str_replace('/*CONTENT-BGCOLOR*/',	'background-color: rgba(255, 255, 255, 0.8 );', $file_text );
			}

			// サイト情報の区切り線
			if (isset($this->options['separator']) && $this->options['separator'] == '1') {
				switch ($this->options['info-position']) {
				case '1':
					$file_text	=	str_replace('/*SEPARATOR*/',	'border-top: 1px solid '.$this->options['color-info'].';', $file_text );
					break;
				case '2':
					$file_text	=	str_replace('/*SEPARATOR*/',	'border-bottom: 1px solid '.$this->options['color-info'].';', $file_text );
					break;
				}
			}

			// 付加情報
			if (isset($this->options['heading']) && $this->options['heading'] == '1') {
				$added_height	=	intval(preg_replace('/[^0-9]/', '', isset($this->options['height-added'] ) ? $this->options['height-added']  : $this->defaults['height-added']  ) );
				$heading_height	=	intval( $added_height / 2 );
				$heading_padding =	intval( $added_height / 4 );
				$file_text		=	str_replace('/*HEADING*/',	'position: absolute; top: -'.$heading_height.'px; left: 20px; padding: 0 '.$heading_padding.'px; background-color: '.$this->options['border-color'].'; border-radius: 2px;', $file_text );
			}

			// 続きを読むボタン
			switch ($this->options['flg-more']) {
			case	'1':
				$file_text = str_replace('/*STYLE-MORE*/',		'padding: 4px; margin: 4px 0;', $file_text );
				break;
			case	'2':
				$file_text = str_replace('/*STYLE-MORE*/',		'border: 1px solid #888; text-align: center; padding: 4px; margin: 4px 0;', $file_text );
				break;
			case	'3':
				$file_text = str_replace('/*STYLE-MORE*/',		'border: 1px solid #888; border-radius: 6px; text-align: center; padding: 4px; margin: 4px 0; background-color: #46f;', $file_text );
				break;
			case	'4':
				$file_text = str_replace('/*STYLE-MORE*/',		'border: 1px solid #888; border-radius: 6px; text-align: center; padding: 4px; margin: 4px 0; background-color: #888;', $file_text );
				break;
			}

			// アンカーの文字装飾
			if (isset($this->options['flg-anker']) && $this->options['flg-anker'] == '1') {
				$file_text = str_replace('/*ANKER*/',			'text-decoration: none !important;', $file_text );
			}

			// 追加CSS
			if (isset($this->options['css-add'])) {
				$file_text = str_replace('/*SPECIAL*/',			$this->options['css-add'], $file_text );
			} else {
				$file_text = str_replace('/*SPECIAL*/',			'', $file_text );
			}

			// ぽぽづれ。へのリンクを表示する
			if (isset($this->options['plugin-link']) && $this->options['plugin-link'] == '1') {
				$file_text = str_replace('/*CREDIT*/',			'display: block;', $file_text );
			} else {
				$file_text = str_replace('/*CREDIT*/',			'display: none;', $file_text );
			}

			$result = file_put_contents($css_path, $file_text);
			global $pagenow;
			if (isset($pagenow) && $pagenow == 'options-general.php') {
				if ($result == true) {
					echo '<div class="updated fade"><p><strong>'.__('Style sheet saved.', $this->text_domain).'</strong></p></div>';
				} else {
					echo '<div class="error fade"><p><strong>'.__('Style sheet failed.', $this->text_domain).'</strong></p></div>';
				}
			}
		}
		unset($temp_name);
		unset($file_text);
		unset($result);
	}