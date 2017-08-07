<?php

namespace Dwnload\WpComposer\WpCli;

use Dwnload\WpComposer\WpComposer;
use Dwnload\WpComposer\WpComposerInterface;
use WP_CLI_Command;

/**
 * Class AbstractWpCli
 *
 * @package Dwnload\WpComposer\WpCli
 */
abstract class AbstractWpCli extends WP_CLI_Command implements WpComposerInterface {

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

    /**
     * @return WpComposer
     */
    public function getWpComposer(): WpComposer {
        return $this->wp_composer;
    }
}