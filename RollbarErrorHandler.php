<?php

use Rollbar\Rollbar;
use Rollbar\Payload\Level;

class RollbarErrorHandler extends CErrorHandler
{
    protected function handleException($exception)
    {
        Rollbar::log(Level::ERROR, $exception);

        parent::handleException($exception);
    }


    protected function handleError($event)
    {
        Rollbar::errorHandler($event->code, $event->message, $event->file, $event->line);

        parent::handleError($event);
    }
}
