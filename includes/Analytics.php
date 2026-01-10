<?php

namespace Codeworks\Umami;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Analytics
{
    public static function init(): void
    {
        add_action( 'wp_enqueue_scripts', [ self::class, 'enqueue_scripts' ] );
    }

    public static function enqueue_scripts(): void
    {
        $options    = get_option( Constants::OPTION_KEY );
        $website_id = $options['umami_website_id'] ?? '';
        $script_url = $options['umami_script_url'] ?? '';

        if ( empty( $website_id ) || empty( $script_url ) ) {
            Helpers::log( 'Umami Analytics: Website ID or Script URL is missing.' );
            return;
        }

        wp_enqueue_script(
                'codeworks-umami-analytics',
                $script_url,
                [],
                null,
                true
        );

        add_filter( 'script_loader_tag', [ self::class, 'add_script_attributes' ], 10, 3 );
    }

    public static function admin_missing_settings_notice(): void
    {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><?php
                echo esc_html__( 'Codeworks Umami: Umami Website ID or Script URL is not configured.', 'codeworks-umami' );
                echo ' ' . sprintf(
                    __( 'Please go to the <a href="%s">Umami Analytics settings page</a> to set them up.', 'codeworks-umami' ),
                    esc_url( admin_url( 'options-general.php?page=' . Constants::SLUG ) )
                );
            ?></p>
        </div>
        <?php
    }

    public static function add_script_attributes( string $tag, string $handle, string $src ): string
    {
        if ( 'codeworks-umami-analytics' !== $handle ) {
            return $tag;
        }

        $options    = get_option( Constants::OPTION_KEY );
        $website_id = $options['umami_website_id'] ?? '';

        if ( empty( $website_id ) ) {
            return $tag;
        }

        // Add async + defer if not already present
        if ( ! str_contains( $tag, ' async' ) ) {
            $tag = str_replace( '<script ', '<script async ', $tag );
        }

        if ( ! str_contains( $tag, ' defer' ) ) {
            $tag = str_replace( '<script ', '<script defer ', $tag );
        }

        // Add data-website-id safely
        if ( ! str_contains( $tag, 'data-website-id=' ) ) {
            $tag = str_replace(
                    ' src=',
                    ' data-website-id="' . esc_attr( $website_id ) . '" src=',
                    $tag
            );
        }

        return $tag;
    }
}