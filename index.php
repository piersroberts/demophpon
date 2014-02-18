<?php

require_once dirname(__FILE__).'/vendor/autoload.php';

$url = 'http://'.$_GET['url'];
//$payload = '<script src="http://buzzwordcompliant.co.uk/test.js"></script>';
$payload = "<script>document.body.style['-webkit-transform'] = 'rotate(180deg)';</script>";

$placement = array('top'=>'</head>','bottom'=>'</body>');

Guzzle\Http\StaticClient::mount();

$stream = Guzzle::get($url, array('stream' => true));

$deployed = FALSE;

while (!$stream->feof()) {
    $buffer = $stream->readLine();
    
    if(!$deployed && ($position = strpos($buffer,$placement['bottom'])) !== FALSE){
        $buffer = substr_replace($buffer,$payload,$position,0);
        $deployed = TRUE;
    }
    
    echo $buffer;
}