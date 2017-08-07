<?php

namespace Dwnload\WpComposer;

/**
 * Class AbstractCommand
 *
 * @package Dwnload\WpComposer
 */
abstract class AbstractPlugin implements WpComposerInterface {

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
