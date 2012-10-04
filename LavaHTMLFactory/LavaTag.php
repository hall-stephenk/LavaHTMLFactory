<?php

abstract class LavaTag {
	protected $_name;
	protected $_attributes;
	protected $_children;
	protected $_innerHTML;
	
	public function __construct($name) {
		$this->_name = $name;
	}
	
	public function addChild($child) {
		if($child instanceOf LavaTag) {
			$this->_children[] = $child;
			return true;
		} else { return false;	}
	}
	
	public function innerHTML($text) {
		$this->_innerHTML = $text;
	}
	
	public function render() {
		echo "<" . $this->_name;
		if(isset($this->_attributes) && count($this->_attributes) > 0) {
			foreach($this->_attributes as $key => $value) {
				echo " " . $key . "='" . $value . "'";
			}
		}
		echo ">";	
		if(isset($this->_children) && count($this->_children) > 0) {
			foreach($this->children as $child) {
				if($child instanceOf LavaTag) {
					$child->render();
				} else {
					echo $child;
				}
			}
		}
		echo "</" . $this->_name . ">";
		return true;
	}
}

?>
