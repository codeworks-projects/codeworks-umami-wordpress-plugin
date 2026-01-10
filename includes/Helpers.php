<?php

namespace Codeworks\Umami;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Helpers
{
    public static function log( mixed $data ): void
    {
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log(
                is_scalar( $data ) ? $data : print_r( $data, true )
            );
        }
    }

    public static function cache_buster(): string
    {
        return CODEWORKS_UMAMI_VERSION;
    }
}
