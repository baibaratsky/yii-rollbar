<?php

use Rollbar\Rollbar;

class RollbarComponent extends CApplicationComponent
{
    private $config = array();

    public function __construct()
    {
        $this->setDefaults();
    }

    public function init()
    {
        Rollbar::init($this->config, false, false);
        parent::init();
    }

    public function __set($key, $value)
    {
        $key = $this->normalizeWithCompatibility($key);

        if ($key === 'root') {
            $value = Yii::getPathOfAlias($value) ? Yii::getPathOfAlias($value) : $value;
        }
        $this->config[$key] = $value;
    }

    protected function setDefaults()
    {
        $this->root = Yii::getPathOfAlias('application');
        $this->scrub_fields = array('passwd', 'password', 'secret', 'auth_token', 'YII_CSRF_TOKEN');
        $this->checkIgnore = function ($isUncaught, $exception, $payload) {
            if ($exception instanceof CHttpException && $exception->statusCode == 404) {
                return true;
            }
            return false;
        };
    }

    /**
     * Converts old public properties to new key names.
     */
    protected function normalizeWithCompatibility($key)
    {
        if ($key === 'rootAlias') {
            $key = 'root';
        }
        if ($key !== 'checkIgnore') {
            $key = $this->underscore($key);
        }

        return $key;
    }

    /**
     * Converts any "CamelCased" into an "underscored_word".
     *
     * Taken from
     * https://github.com/yiisoft/yii2/blob/6da1ec6fb2b6367cb30d8c581575d09f0072812d/framework/helpers/BaseInflector.php#L411
     *
     * @param string $words the word(s) to underscore
     * @return string
     */
    private function underscore($words)
    {
        return strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $words));
    }
}
