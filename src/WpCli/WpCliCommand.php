<?php

namespace Dwnload\WpComposer\WpCli;

// Not a WP-CLI Request
if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
    return;
}

use Composer\Console\Application;
use Dwnload\WpComposer\WpComposer;
use Symfony\Component\Console\Input\ArrayInput;
use WP_CLI_Command;
use WP_CLI;

/**
 * @todo: This might need to be added:
 * @link https://github.com/composer/composer/issues/1906#issuecomment-51632453
// Composer\Factory::getHomeDir() method
// needs COMPOSER_HOME environment variable set
// putenv('COMPOSER_HOME=' . __DIR__ . '/vendor/bin/composer');
 */

/**
 * Class ComposerCommand
 *
 * @package Dwnload\WpComposer
 */
class WpCliCommand extends AbstractWpCli {

    public function install() {
        $this->getWpComposer()->recursiveExecution( function( $path, $data, $is_plugin, $is_theme ) {
            WP_CLI::line( sprintf( 'Starting to process %s', end( explode( '/', $path ) ) ) );
            // Run the Composer command.
            $application = $this->getWpComposer()->getApp();
            $application->setAutoExit( false );
            $application->run( new ArrayInput( [ 'command' => 'install' ] ) );
            WP_CLI::success( 'Finished processing' );
        } );
    }

    public function update() {
        $this->getWpComposer()->recursiveExecution( function( $path, $data, $is_plugin, $is_theme ) {
            WP_CLI::line( sprintf( 'Starting to process %s', end( explode( '/', $path ) ) ) );
            // Run the Composer command.
            $application = $this->getWpComposer()->getApp();
            $application->setAutoExit( false );
            $application->run( new ArrayInput( [ 'command' => 'update' ] ) );
            WP_CLI::success( 'Finished processing' );
        } );
    }

    public function diagnose() {
        $this->getWpComposer()->recursiveExecution( function( $path, $data, $is_plugin, $is_theme ) {
            WP_CLI::line( sprintf( 'Starting to process %s', end( explode( '/', $path ) ) ) );
            // Run the Composer command.
            $application = $this->getWpComposer()->getApp();
            $application->setAutoExit( false );
            $application->run( new ArrayInput( [ 'command' => 'diagnose' ] ) );
            WP_CLI::success( 'Finished processing' );
        } );
    }

    public function status() {
        $this->getWpComposer()->run();
    }

    public function about() {
        $this->getWpComposer()->run();
    }

    public function version() {
        WP_CLI::line( sprintf( 'wp-composer version: %s', WpComposer::VERSION ) );
    }
}

$callback = new WpCliCommand( new WpComposer( new Application() ) );
WP_CLI::add_command( 'composer', $callback );
