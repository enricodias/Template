<?php

namespace enricodias;

class Template
{
	private $_vrs = '{$';
	private $_vre = '}';
	private $_tbb = '<!-- BLOCK ';
	private $_tbs = ' START -->';
	private $_tbe = ' END -->';
	
	private $_template      = '';
	private $_reloadFile    = '';
	private $_reloadCache   = '';
	private $_blockTemplate = '';
	private $_blockCache    = '';
	
	public function __construct($fileName = null)
	{
		if ($fileName !== null) $this->load($fileName);
	}
	
	public function load($fileName)
	{
		$this->_template = $this->loadFile($fileName);
	}
	
	public function reload($fileName)
	{
		if ($this->_reloadCache === '') {
			
			$this->_reloadCache = $this->loadFile($fileName);
			$this->_reloadFile  = $fileName;
			
		}
		
		$this->_template .= $this->_reloadCache;
	}
	
	public function getBlock($block)
	{
		$tmp = $this->_template;

		if ($this->_blockCache !== '') $tmp = $this->_blockCache;
		
		$tmp = explode($this->_tbb.$block.$this->_tbs, $tmp, 2);
		$tmp = explode($this->_tbb.$block.$this->_tbe, $tmp[1], 2);
		
		$this->_blockTemplate = current($tmp);
	}
	
	public function makeBlock()
	{
		$this->_blockCache = $this->_template;
		$this->_template   = $this->_blockTemplate;
	}
	
	public function reloadBlock()
	{
		$this->_template .= $this->_blockTemplate;
	}
	
	public function replace($var, $content)
	{
		$this->_template = str_replace($this->_vrs.$var.$this->_vre, $content, $this->_template);
	}
	
	public function __toString()
	{
		return $this->getContent();
	}
	
	public function getContent()
	{
		return $this->_template;
	}
	
	public function publish()
	{
		echo $this->getContent();
	}

	private function loadFile($fileName)
	{
		if (file_exists($fileName)) return file_get_contents($fileName);
		
		return '';
	}
}