<?php

class LavaTag {
	protected $_name;
	protected $_attributes;
	protected $_children;
	
	public function __construct($name) {
		$this->_name = $name;
	}
	
	public function addAttributes($attributes) {
		if(is_array($attributes)) {
			foreach($attributes as $key => $value) {
				$this->_attributes[$key] = $value;
			}
		} else { return false; }
	}
	
	public function delAttribute($key) {
		unset($this->_children[$key]);
	}
	
	public function addChild($child) {
		$this->_children[] = $child;
		return true;
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
			foreach($this->_children as $child) {
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

class LavaTagFactory {
	public static function create($name) {
		return new LavaTag($name);
	}
}


?>
