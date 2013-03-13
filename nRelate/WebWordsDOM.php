<?

include_once('IWebWords.php');

class WebWordsDOM implements IWebWords {
	protected $cleanHtml;
	private $dom;

	public function getCleanHtml($html) {
		echo "DOMing\n";
		$this->dom = new DOMDocument();
		$this->dom->loadHTML($html);
		$this->removeScriptTags();
		$this->removeStyleTags();
		$this->getBody();
		return $this->cleanHtml;
	}

	private function getBody() {
		$body = $this->dom->getElementsByTagName('body');
		$this->cleanHtml = $body->item(0)->textContent;
	}

	private function removeScriptTags() {
		$this->removeDOMTag('script');
	}

	private function removeStyleTags() {
		$this->removeDOMTag('style');
	}

	private function removeDOMTag($tag) {
		$domNodeList = $this->dom->getElementsByTagname($tag); 
		$domElemsToRemove = array(); 
		foreach ( $domNodeList as $domElement ) { 
		  $domElemsToRemove[] = $domElement; 
		} 
		foreach( $domElemsToRemove as $domElement ){ 
		  $domElement->parentNode->removeChild($domElement); 
		} 
	}
}
