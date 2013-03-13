<?

include_once('IWebWords.php');

class WebWordsRegex implements IWebWords {
	protected $cleanHtml;

	public function getCleanHtml($html) {
		echo "REGEX\n";
		$this->getBody();
		$this->removeScriptTags();
		$this->removeStyleTags();
		$this->cleanHtml = strip_tags($this->cleanHtml);
		return $this->cleanHtml;
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