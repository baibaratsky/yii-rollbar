<?php

use Rollbar\Rollbar;
use Rollbar\LevelFactory;

class RollbarLogRoute extends CLogRoute
{
    public $rollbarComponentName = 'rollbar';
    private $levelFactory = null;

    public function init()
    {
        if (Yii::app()->getComponent($this->rollbarComponentName) === null) {
            throw new CException('Rollbar component is not loaded.');
        }
        $this->levelFactory = new LevelFactory();
    }

    protected function processLogs($logs)
    {
        foreach ($logs as $log) {
            // Exclude records by the exceptions handler. RollbarErrorHandler takes care of them.
            if (strncmp($log[2], 'exception', 9) !== 0) {
                Rollbar::log($this->levelFactory->fromName($this->correspondingLevel($log[1])), $log[0]);
            }
        }
    }

    private function correspondingLevel($level)
    {
        if ($level == 'trace' || $level == 'profile') {
            return 'debug';
        }

        return $level;
    }
}
