<?php

namespace app\components;

use yii\base\Component;
use yii\base\Model;

abstract class Service extends Component
{
    protected $form;
    protected $model;

    public function __construct(Model $form, Model $model = null, array $config = [])
    {
        parent::__construct($config);
        $this->form = $form;
        $this->model = $model;
    }

    abstract public function execute();
}
