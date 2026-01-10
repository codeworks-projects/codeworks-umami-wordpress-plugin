<?php

namespace Codeworks\Umami;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Plugin
{
    public static function init(): void
    {
        add_action( 'plugins_loaded', [ self::class, 'load' ] );
    }

    public static function load(): void
    {
        // Load textdomain (future-ready)
        load_plugin_textdomain(
            'codeworks-umami',
            false,
            dirname( plugin_basename( CODEWORKS_UMAMI_FILE ) ) . '/languages'
        );

        // Initialize features
        Analytics::init();

        // Add admin menu and settings
        add_action( 'admin_menu', [ self::class, 'add_admin_menu' ] );
        add_action( 'admin_init', [ self::class, 'register_settings' ] );

        // Add admin notice if settings are missing
        self::maybe_add_admin_notice();
    }

    public static function maybe_add_admin_notice(): void
    {
        $options = get_option( Constants::OPTION_KEY );
        $website_id = $options['umami_website_id'] ?? '';
        $script_url = $options['umami_script_url'] ?? '';

        if ( empty( $website_id ) || empty( $script_url ) ) {
            Helpers::log( 'Umami Analytics: Website ID or Script URL is missing.' );

            // Display admin notice only in admin area and for users with manage_options
            if ( is_admin() && current_user_can( 'manage_options' ) ) {
                add_action( 'admin_notices', [ Analytics::class, 'admin_missing_settings_notice' ] );
            }
        }
    }

    public static function add_admin_menu(): void
    {
        add_options_page(
            __( 'Umami Analytics', 'codeworks-umami' ),
            __( 'Umami Analytics', 'codeworks-umami' ),
            'manage_options',
            Constants::SLUG,
            [ self::class, 'settings_page' ]
        );
    }

    public static function settings_page(): void
    {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields( Constants::OPTION_KEY );
                do_settings_sections( Constants::SLUG );
                submit_button( __( 'Save Settings', 'codeworks-umami' ) );
                ?>
            </form>
        </div>
        <?php
    }

    public static function register_settings(): void
    {
        register_setting(
            Constants::OPTION_KEY,
            Constants::OPTION_KEY,
            [
                'type'              => 'array',
                'sanitize_callback' => [ self::class, 'sanitize_settings' ],
                'default'           => [],
            ]
        );

        add_settings_section(
            'codeworks_umami_main_section',
            __( 'Umami Analytics Settings', 'codeworks-umami' ),
            [ self::class, 'main_settings_section_callback' ],
            Constants::SLUG
        );

        add_settings_field(
            'umami_website_id',
            __( 'Umami Website ID', 'codeworks-umami' ),
            [ self::class, 'umami_website_id_callback' ],
            Constants::SLUG,
            'codeworks_umami_main_section'
        );

        add_settings_field(
            'umami_script_url',
            __( 'Umami Script URL', 'codeworks-umami' ),
            [ self::class, 'umami_script_url_callback' ],
            Constants::SLUG,
            'codeworks_umami_main_section'
        );
    }

    public static function sanitize_settings( array $input ): array
    {
        $new_input = [];

        if ( isset( $input['umami_website_id'] ) ) {
            $new_input['umami_website_id'] = sanitize_text_field( $input['umami_website_id'] );
        }

        if ( isset( $input['umami_script_url'] ) ) {
            $new_input['umami_script_url'] = esc_url_raw( $input['umami_script_url'] );
        }

        return $new_input;
    }

    public static function main_settings_section_callback(): void
    {
        echo '<p>' . esc_html__( 'Configure your Umami Analytics settings below.', 'codeworks-umami' ) . '</p>';
    }

    public static function umami_website_id_callback(): void
    {
        $options = get_option( Constants::OPTION_KEY );
        $website_id = $options['umami_website_id'] ?? '';
        echo '<input type="text" id="umami_website_id" name="' . esc_attr( Constants::OPTION_KEY ) . '[umami_website_id]" value="' . esc_attr( $website_id ) . '" class="regular-text" />';
        echo '<p class="description">' . esc_html__( 'Enter your Umami website ID (e.g., "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx").', 'codeworks-umami' ) . '</p>';
    }

    public static function umami_script_url_callback(): void
    {
        $options = get_option( Constants::OPTION_KEY );
        $script_url = $options['umami_script_url'] ?? '';
        echo '<input type="url" id="umami_script_url" name="' . esc_attr( Constants::OPTION_KEY ) . '[umami_script_url]" value="' . esc_attr( $script_url ) . '" class="regular-text" placeholder="https://your-umami-instance.com/script.js" />';
        echo '<p class="description">' . esc_html__( 'Enter the full URL to your Umami tracking script (e.g., "https://umami.example.com/script.js").', 'codeworks-umami' ) . '</p>';
    }

    public static function uninstall(): void
    {
        delete_option( Constants::OPTION_KEY );
    }
}
