<?php
include('LavaHTMLFactory/LavaHTMLFactory.php');

$html = LavaTagFactory::create('html');
$head = LavaTagFactory::create('head');
$body = LavaTagFactory::create('body');
$h1	= LavaTagFactory::create('h1');
$p		= LavaTagFactory::create('p');
// add text to the h1 tag
$h1->addChild("Title of the Page");

// Add attributes and child h1 tag to body
$body->addAttributes(array("class" => "container"));
$body->addStyles(array("font-family" => "sans-serif"));
$body->addChild($h1);

// add 4 paragraphs to the body
$content = array();
for($i = 1; $i < 6; $i++) {
	$a = LavaTagFactory::create('p');	
	$a->addChild("This is paragraph number $i");
	$a->addStyles(array("background-color" => "#$i$i$i", "color" => "white", "padding" => "5px"));
	$body->addChild($a);
}


// Add head and body to html
$html->addChild($head);
$html->addChild($body);

$html->render();

?>
