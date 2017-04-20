<?php

class RollbarComponent extends CApplicationComponent
{
    private $config = [];

    public function __construct()
    {
        $this->setDefaults();
    }

    public function init()
    {
        Rollbar::init($this->config, false, false);
        parent::init();
    }
    
    public function __set($key, $value) {
      if ( $key === 'root' ) {
        $value = YiiBase::getPathOfAlias( $value ) ? YiiBase::getPathOfAlias( $value ) : $value;
      }
      $this->config[$key] = $value;
    }

    protected function setDefaults()
    {
        $this->root = Yii::getPathOfAlias('application');
        $this->scrub_fields = ['passwd', 'password', 'secret', 'auth_token', 'YII_CSRF_TOKEN'];
    }
}
