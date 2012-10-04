<?php

class LavaTag {
	protected $_name;
	protected $_attributes;
	protected $_children;
	protected $_styles;
	protected $_selfClosing;
	
	public function __construct($name, $selfClosing = false) {
		$this->_selfClosing = $selfClosing;
		$this->_name = $name;
	}
	
	public function addAttributes($attributes) {
		if(is_array($attributes)) {
			foreach($attributes as $key => $value) {
				$this->_attributes[$key] = $value;
			}
		} else { return false; }
	}
	
	public function setSelfClosing(Bool $selfClosing) {
		$this->_selfClosing = $selfClosing;
	}
	
	public function delAttribute($key) {
		unset($this->_children[$key]);
	}
	
	public function addStyles($styles) {
		if(is_array($styles)) {
			foreach($styles as $key => $value) {
				$this->_styles[$key] = $value;
			}
			return true;
		} else {
			throw Exception("styles must be in an associative array");
		}
	}
	
	public function addChild($child, $index = null) {
		if(is_null($index)) {
			$this->_children[] = $child;
		} else {
			$this->_children[$index] = $child;
		}
		return true;
	}
		
	public function setChild($child, $index) {
		$this->_children[$index] = $child;
		return true;
	}
	
	public function render($formatOutput = false, $indent = 0) {
		if($formatOutput) {
			echo $this->_renderFormatted(0);
		} else {
			echo $this->_renderUnformatted();
		}
	}
	
	protected function _renderFormatted($indentLevel) {
		$indent = "";
		for($i = 0; $i < $indentLevel; $i++) {
			$indent .= "\t";
		}
		$render = "$indent<" . $this->_name;
		if(isset($this->_attributes) && count($this->_attributes) > 0) {
			foreach($this->_attributes as $key => $value) {
				$render .= " " . $key . "='" . $value . "'";
			}
		}
		if(isset($this->_styles) && count($this->_styles) > 0) {
			$render .= " style='";
			foreach($this->_styles as $key => $value) {
				$render .= "$key:$value;";
			}
			$render .= "'";
		}
		if($this->_selfClosing) { $render .= " />\n"; }
		else {
			$render .= ">\n";	
			if(isset($this->_children) && count($this->_children) > 0) {
				foreach($this->_children as $child) {
					if($child instanceOf LavaTag) {
						$render .= $child->_renderFormatted($indent + 1);
					} else {
						$render .= $indent . "\t" . $child . "\n";
					}
				}
			}
			$render .= "$indent</" . $this->_name . ">\n";
		}
		return $render;
	}
	
	protected function _renderUnformatted() {
		$render = "<" . $this->_name;
		if(isset($this->_attributes) && count($this->_attributes) > 0) {
			foreach($this->_attributes as $key => $value) {
				$render .= " " . $key . "='" . $value . "'";
			}
		}
		if(isset($this->_styles) && count($this->_styles) > 0) {
			$render .= " style='";
			foreach($this->_styles as $key => $value) {
				$render .= "$key:$value;";
			}
			$render .= "'";
		}
		if($this->_selfClosing) { $render .= " />"; }
		else {
			$render .= ">";	
			if(isset($this->_children) && count($this->_children) > 0) {
				foreach($this->_children as $child) {
					if($child instanceOf LavaTag) {
						$render .= $child->_renderUnformatted();
					} else {
						$render .= $child;
					}
				}
			}
			$render .= "</" . $this->_name . ">";
		}
		return $render;
	}
}

class LavaTagFactory {
	public static function create($name) {
		if(self::_isSelfClosing($name)) {
			return new LavaTag($name, TRUE);
		} else {
			return new LavaTag($name);
		}
	}
	private static function _isSelfClosing($name) {
		$selfClosers = array(
			"br", "hr", "meta", "input", "link", "img"
		);
		if(in_array($name, $selfClosers)) {
			return true;
		} else {
			return false;
		}
	}
}


?>
