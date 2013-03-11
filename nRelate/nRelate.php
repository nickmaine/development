<?
/**
* nRelate.php is to be run from the command line (php nRelate.php). 
* After execution is complete there will be a directory named csv with 9 csv files inside.
*/

include_once('WebWordCount.php');

$urls = array('http://php.about.com', 
							'http://www.about.com/health',
							'http://bicycling.about.com',
							'http://www.cnn.com/TECH',
							'http://www.cnn.com/TRAVEL',
							'http://www.cnn.com/HEALTH',
							'http://www.nytimes.com/pages/technology/index.html',
							'http://www.nytimes.com/pages/fashion/index.html',
							'http://www.nytimes.com/pages/arts/index.html');

foreach($urls as $url) {
	$wg = new WebWordCount($url);
	$wg->getWordCountFile();
}

?>
