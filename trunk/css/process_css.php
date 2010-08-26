<?php
	$_GET['css_init'] = 1;

  require_once ('../includes/_init.php');

  header('Content-type: text/css');

	if (defined('APPLICATION_URL'))
		$url = APPLICATION_URL;
	else
		$url = './';

  if (!empty($_GET['name']))
  {
	  $name = $_GET['name'];
	  $f = $GLOBALS['ROOTPATH'] . 'css/' . $name . '.css';

//	  $bannerHeight = $GLOBALS['CURRENT BANNER']['height'];

	  if (file_exists($f))
	  {
		  $fp = fopen($f,'r');

		  while($css = fgets($fp))
		  {
		    $css = str_replace('{application_url}', $url, $css);
		    echo $css;
		  }

		  fclose($fp);
	  }
	  else
	  {
	  	echo '/* FILE NOT FOUND */';
	  }
	}
  else
  {
  	echo '/* FILE NOT FOUND */';
  }
