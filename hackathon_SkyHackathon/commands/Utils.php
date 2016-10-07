<?php

namespace ContenderApps\CatalystBot\Commands;

class Utils {
    
    
    public static function getFrom($update) {
        $message = $update["message"];
        $from = $message["from"];
        return from;
    }
    
    
}