<?php

namespace enricodias;

class Template {
	
	private $_tex = '.tpl';
	private $_vrs = '{$';
	private $_vre = '}';
	private $_tbb = '<!-- BLOCK ';
	private $_tbs = ' START -->';
	private $_tbe = ' END -->';
	
	private $_template;
	private $_reloadFile;
	private $_reloadCache;
	private $_blockTemplate;
	private $_blockCache;
	
	public function __construct($fileName = false) {
		
		if (!empty($fileName)) $this->load($fileName);
		
	}
	
	public function __toString() {
		
		return $this->getContent();
		
	}
	
	public function load($fileName) {
		
		if (file_exists($fileName.$this->_tex)) {
			
			$this->_template = file_get_contents($fileName.$this->_tex);
			
		}
		
	}
	
	public function reload($fileName) {
		
		if (empty($this->_reloadCache) || $this->_reloadFile != $fileName ) {
			
			$this->_reloadCache = file_get_contents($fileName.$this->_tex);
			$this->_reloadFile  = $fileName;
			
		}
		
		$this->_template .= $this->_reloadCache;
		
	}
	
	public function getBlock($block) {
		
		if ($this->_blockCache) $tmp = $this->_blockCache;
		else $tmp = $this->_template;
		
		$tmp = explode($this->_tbb.$block.$this->_tbs, $tmp, 2);
		$tmp = explode($this->_tbb.$block.$this->_tbe, $tmp[1], 2);
		
		$this->_blockTemplate = $tmp[0];
		
	}
	
	public function makeBlock() {
		
		$this->_blockCache = $this->_template;
		$this->_template   = $this->_blockTemplate;
		
	}
	
	public function reloadBlock() {
		
		$this->_template .= $this->_blockTemplate;
		
	}
	
	public function replace($var, $content) {
		
		$this->_template = str_replace($this->_vrs.$var.$this->_vre, $content, $this->_template);
		
	}
	
	public function getContent() {
		
		return $this->_template;
		
	}
	
	public function publish() {
		
		echo $this->getContent();
		
	}

}

?>