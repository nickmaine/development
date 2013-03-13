<?

abstract class IWebGet {
	protected $ch;
	protected $dom;
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
