<?php

namespace Dwnload\WpComposer;

use Symfony\Component\Console\Input\ArrayInput;

/**
 * Class ComposerInstall
 *
 * @package Dwnload\WpComposer
 */
class WpPlugin extends AbstractPlugin {

    /**
     * @return int 0 if everything went fine, or an error code
     * @throws \Exception
     */
    public function install(): int {
        $application = $this->getWpComposer()->getApp();
        $application->setAutoExit( false );

        return $application->run( new ArrayInput( [ 'command' => 'install' ] ) );
    }
}
