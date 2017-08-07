<?php

namespace Dwnload\WpComposer;

/**
 * Interface WpComposerInterface
 *
 * @package Dwnload\WpComposer
 */
interface WpComposerInterface {

    /**
     * @param WpComposer $composer
     */
    public function __construct( WpComposer $composer );

    /**
     * @return WpComposer
     */
    public function getWpComposer(): WpComposer;
}
