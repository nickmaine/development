<?

abstract class WebGet {
	protected $ch;
	protected $url;
	protected $htmlPage;

	public function __construct($url = NULL) {
		if (!is_null($url)) {
			$this->exec($url);
		}
	}

	protected function exec($url){
		$this->setURL($url);
		$this->ch = curl_init($this->getURL());
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1); 
		$this->htmlPage = curl_exec($this->ch);   
	}

	protected function setURL($url) {
		$this->url = $url;	
	}

	protected function getURL() {
		return $this->url;	
	}

	protected function getHtml() {
		return $this->htmlPage;
	}

	public function __destruct() {
		curl_close($this->ch);
	}

}

class WebWordCount extends WebGet {
	protected $cleanHtml;
	protected $wordCountArray = array();

	public function __construct($url = NULL) {
		if (!is_null($url)) {
			parent::__construct($url);
			$this->cleanHtml = parent::getHtml();
		}
	}

	public function getWordCountFile() {
		$this->getCleanHtml();
		$this->getWordsArray();
		$this->createCSVFile();
	}

	private function getCleanHtml() {
		$this->getBody();
		$this->removeScriptTags();
		$this->removeStyleTags();
		$this->cleanHtml = strip_tags($this->cleanHtml);
	}

	private function getWordsArray() {
		$words = str_word_count($this->cleanHtml, 1);
		$this->wordCountArray = array_count_values($words);
	}

	private function createCSVFile() {
		if (!is_dir('csv')) {
			mkdir('csv', 0777, true); 
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

	private function getBody() {
		preg_match('#<body(.*?)>(.*?)</body>#is', $this->cleanHtml, $matches);
		if (isset($matches[2])) {
			$this->cleanHtml = $matches[2];
		} 
	}

	private function removeScriptTags() {
		$this->cleanHtml = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $this->cleanHtml); 
	} 

	private function removeStyleTags() {
		$this->cleanHtml = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $this->cleanHtml); 
	} 
}

?>