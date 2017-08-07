<?php

namespace Dwnload\WpComposer;

// Not a WP-CLI Request
if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
    return;
}

use Composer\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use WP_CLI_Command;
use WP_CLI;

/**
 * Class ComposerCommand
 *
 * @package Dwnload\WpComposer
 */
class WpCliCommand extends WP_CLI_Command {

    /** @var  WpComposer $wp_composer */
    private $wp_composer;

    /**
     * WpCliCommand constructor.
     *
     * @param WpComposer $composer
     */
    public function __construct( WpComposer $composer ) {
        $this->wp_composer = $composer;
    }

    public function install() {
        $this->wp_composer->recursiveExecution( function( $path, $data, $is_plugin, $is_theme ) {
            WP_CLI::line( sprintf( 'Starting to process %s', end( explode( '/', $path ) ) ) );
            // Run the Composer command.
            $application = $this->wp_composer->getApp();
            $application->setAutoExit( false );
            $application->run( new ArrayInput( [ 'command' => 'install' ] ) );
            WP_CLI::success( 'Finished processing' );
        } );
    }

    public function update() {
        $this->wp_composer->recursiveExecution( function( $path, $data, $is_plugin, $is_theme ) {
            WP_CLI::line( sprintf( 'Starting to process %s', end( explode( '/', $path ) ) ) );
            // Run the Composer command.
            $application = $this->wp_composer->getApp();
            $application->setAutoExit( false );
            $application->run( new ArrayInput( [ 'command' => 'update' ] ) );
            WP_CLI::success( 'Finished processing' );
        } );
    }

    public function diagnose() {
        $this->wp_composer->recursiveExecution( function( $path, $data, $is_plugin, $is_theme ) {
            WP_CLI::line( sprintf( 'Starting to process %s', end( explode( '/', $path ) ) ) );
            // Run the Composer command.
            $application = $this->wp_composer->getApp();
            $application->setAutoExit( false );
            $application->run( new ArrayInput( [ 'command' => 'diagnose' ] ) );
            WP_CLI::success( 'Finished processing' );
        } );
    }

    public function status() {
        $this->wp_composer->run();
    }

    public function about() {
        $this->wp_composer->run();
    }

    public function version() {
        WP_CLI::line( sprintf( 'wp-composer version: %s', WpComposer::VERSION ) );
    }
}

$callback = new WpCliCommand( new WpComposer( new Application() ) );
WP_CLI::add_command( 'composer', $callback );
