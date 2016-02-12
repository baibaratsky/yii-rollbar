<?php

class RollbarComponent extends CApplicationComponent
{
    public $accessToken;
    public $environment;
    public $branch;
    public $code_version;
    public $host;
    public $batched;
    public $batchSize;
    public $timeout;
    public $logger;
    public $includedErrno;
    public $baseApiUrl;
    public $rootAlias = 'application';
    public $scrubFields = ['passwd', 'password', 'secret', 'auth_token', 'YII_CSRF_TOKEN'];

    public function init()
    {
        Rollbar::init(
            array(
                'access_token' => $this->accessToken,
                'environment' => $this->environment,
                'branch' => $this->branch,
                'code_version' => $this->code_version,
                'host' => $this->host,
                'batched' => $this->batched,
                'batch_size' => $this->batchSize,
                'timeout' => $this->timeout,
                'logger' => $this->logger,
                'included_errno' => $this->includedErrno,
                'base_api_url' => $this->baseApiUrl,
                'root' => !empty($this->rootAlias) ? Yii::getPathOfAlias($this->rootAlias) : '',
                'scrub_fields' => $this->scrubFields,
            ),
            false,
            false);

        parent::init();
    }
}
