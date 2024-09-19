<?php

declare(strict_types=1);

namespace Test\Output;

use php_user_filter;

class Intercept extends php_user_filter
{
    public static string $cache = '';

    public function filter($in, $out, &$consumed, $closing): int
    {
        while ($bucket = stream_bucket_make_writeable($in)) {
            self::$cache .= $bucket->data;
            $bucket->data = '';
            $bucket->datalen = 0;
            $consumed += $bucket->datalen;
            stream_bucket_append($out, $bucket);
        }
        return PSFS_PASS_ON;
    }
}
