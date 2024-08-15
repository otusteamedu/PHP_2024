<?php

require 'vendor/autoload.php';

use Amikha1lov\OtusComposerPackage\HelloWorld;

$helloWorld = new HelloWorld();
echo $helloWorld->sayHelloFromComposerPackage();