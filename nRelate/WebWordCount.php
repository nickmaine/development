<?

include_once('IWebGet.php');
include_once('WebWordsDOM.php');
include_once('WebWordsRegex.php');

class WebWordCount extends IWebGet {
	protected $cleanHtml;
	protected $useDOM;
	protected $wordCountArray = array();

	public function __construct($url = NULL, $useDOM = TRUE) {
		$this->useDOM = $useDOM;
		if (!is_null($url)) {
			parent::__construct($url);
		}
	}

	public function getWordCountFile() {
		if ($this->useDOM == TRUE) {
			$ww = new WebWordsDOM();
			$this->cleanHtml = $ww->getCleanHtml(parent::getHtml());
		}
		else {
			$ww = new WebWordsRegex();
			$this->cleanHtml = $ww->getCleanHtml(parent::getHtml());
		}

		$this->getWordsArray();
		$this->createCSVFile();
	}

	private function getWordsArray() {
		$words = str_word_count($this->cleanHtml, 1);
		$this->wordCountArray = array_count_values($words);
	}

	private function createCSVFile() {
		if (!is_dir('csv')) {
			mkdir('csv', 0777); 
		}

		$url_parts = parse_url(parent::getURL());
		$file_name = 'csv/' . $url_parts['host'] . (isset($url_parts['path']) ? preg_replace('/\//', '-', $url_parts['path']) : "");
		$fp = fopen($file_name . '.csv', 'w');

		foreach ($this->wordCountArray as $key => $value) {
			fputcsv($fp, array($key, $value));
		}

		fclose($fp);

		echo "Created $file_name\n";
	}
}
