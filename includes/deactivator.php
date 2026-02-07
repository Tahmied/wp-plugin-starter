<?php

namespace Cartcarebd\Cartsheild;

class Deactivator
{
    public static function deactivate()
    {
        // Clear scheduled events, flush rules
        flush_rewrite_rules();
    }
}
