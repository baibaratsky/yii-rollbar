<?php

class RollbarErrorHandler extends CErrorHandler
{
    protected function handleException($exception)
    {
        if (!($exception instanceof CHttpException && $exception->statusCode == 404)) {
            Rollbar::report_exception($exception);
        }

        parent::handleException($exception);
    }


    protected function handleError($event)
    {
        Rollbar::report_php_error($event->code, $event->message, $event->file, $event->line);

        parent::handleError($event);
    }
}
