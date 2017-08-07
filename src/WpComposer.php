<?php

namespace Dwnload\WpComposer;

use Composer\Console\Application;

/**
 * Class WpComposer
 *
 * @package Dwnload\WpComposer
 */
class WpComposer {

    const VERSION = '0.0.1';

    /** @var  Application $app */
    protected $app;

    /**
     * WpComposer constructor.
     *
     * @param Application $application
     */
    public function __construct( Application $application ) {
        $this->app = $application;
    }

    /**
     * @return Application
     */
    public function getApp(): Application {
        return $this->app;
    }

    /**
     * {@inheritdoc}
     */
    public function run() {
        // Run the Composer command.
        $application = $this->app;
        $application->setAutoExit( false );
        $application->run();
    }

    /**
     * Execute a composer command for all the themes and plugins
     *
     * @param callable $callback A callback function to execute for each function
     */
    public function recursiveExecution( callable $callback ) {
        if ( ! is_callable( $callback ) ) {
            die( 'Not a valid callback.' );
        }

        $directories = $this->getDirectories();
        $current_dir = getcwd();

        foreach ( $directories as $dir => $data ) {
            chdir( $dir );

            $is_theme = ( is_object( $data ) && get_class( $data ) === 'WP_Theme' );
            $is_plugin = ! $is_theme;

            call_user_func_array( $callback, [ $dir, $data, $is_plugin, $is_theme ] );
        }

        chdir( $current_dir );
    }

    /**
     * Retrieve the Directories to act upon
     *
     * @return array Array of plugins or WP_Theme objects
     */
    private function getDirectories() {
        $index = [];

        $plugins = apply_filters( 'all_plugins', get_plugins() );
        if ( count( $plugins ) > 0 ) :
            foreach ( $plugins as $path => $data ) :
                $plugin = $this->filterPlugin( $path );

                if ( $plugin !== null && $this->shouldUsePath( $plugin ) )
                    $index[ $plugin ] = $data;
            endforeach;
        endif;

        // Themes
        $themes = wp_get_themes();
        $themes_root = trailingslashit( get_theme_root() );

        if ( count( $themes ) > 0 ) :
            foreach ( $themes as $path => $data ) :
                if ( $this->shouldUsePath( $themes_root . $path ) )
                    $index[ $themes_root . '/' . $path ] = $data;
            endforeach;
        endif;

        return apply_filters( 'wp_composer_paths', $index );
    }

    /**
     * Internally Filter the plugin's path
     *
     * @param string $plugin
     *
     * @return null|string Null for a plugin not to be included
     */
    private function filterPlugin( string $plugin ) {
        // They're not in a single file, cannot support them
        if ( dirname( trailingslashit( WP_PLUGIN_DIR ) . $plugin ) === WP_PLUGIN_DIR ) {
            return null;
        } else {
            return trailingslashit( WP_PLUGIN_DIR ) . dirname( $plugin );
        }
    }

    /**
     * See if we should include a path if they don't have a composer.json
     *
     * @param string $path
     *
     * @return bool
     */
    private function shouldUsePath( string $path ): bool {
        return file_exists( trailingslashit( $path ) . 'composer.json' );
    }
}
