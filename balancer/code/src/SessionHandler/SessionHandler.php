<?php

namespace SessionHandler;

class SessionHandler
{
    public function start()
    {
        session_start();
        $_SESSION['test'] = "Memcache works" . "<br>";
        echo "Session saved: " . $_SESSION["test"];
    }
}
