<?php
include('LavaHTMLFactory/LavaHTMLFactory.php');

$html		= LavaTagFactory::create('html');
$head		= LavaTagFactory::create('head');
$title	= LavaTagFactory::create('title');
$keywords= LavaTagFactory::create('meta');
$body		= LavaTagFactory::create('body');
$h1		= LavaTagFactory::create('h1');
$hr		= LavaTagFactory::create('hr');
$p			= LavaTagFactory::create('p');

$keywords->addAttributes(array("content" => 'testing,testing,testing', "name" => "keywords"));
$title->addChild("This is my title");
$head->addChild($title);
$head->addChild($keywords);
// add text to the h1 tag
$h1->addChild("Title of the Page");

// Add attributes and child h1 tag to body
$body->addAttributes(array("class" => "container"));
$body->addStyles(array("font-family" => "sans-serif"));
$body->addChild($h1);
$body->addChild($hr);
// add 6000 paragraphs to the body
for($i = 1; $i <= 600; $i++) {
	$a = LavaTagFactory::create('p');	
	$a->addChild("This is paragraph number $i");
	$a->addStyles(array("background-color" => "#333", "color" => "white", "padding" => "5px"));
	$a->addStyles(array("border-radius" => "4px"));
	$body->addChild($a);
}

// Change 2nd paragraph (remember 0 index)
$body->getChild(5)->setChild("This is my new paragraph",0);

// Add another paragraph to the end of the body
$body->addChild(LavaTagFactory::create('p')->addChild("This is my OOP paragraph"));

// Add head and body to html
$html->addChild($head);
$html->addChild($body);

$html->render(true);

?>
