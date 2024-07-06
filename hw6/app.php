<?php

namespace HW6;

require_once('class/App.php');

try {
    App::checkEmail();
} catch (Exception $e) {
}
