<?php

use Rollbar\Rollbar;
use Rollbar\Payload\Level;

class RollbarErrorHandler extends CErrorHandler
{
    protected function handleException($exception)
    {
        if (!($exception instanceof CHttpException && $exception->statusCode == 404)) {
            Rollbar::log(Level::error(), $exception);
        }

        parent::handleException($exception);
    }


    protected function handleError($event)
    {
        Rollbar::errorHandler($event->code, $event->message, $event->file, $event->line);

        parent::handleError($event);
    }
}
