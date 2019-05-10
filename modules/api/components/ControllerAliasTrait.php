<?php

namespace app\modules\api\components;

trait ControllerAliasTrait
{
    protected $modelAlias;

    public function init()
    {
        if ($this->modelAlias) {
            $this->serializer = ['class' => Serializer::class, 'alias' => $this->modelAlias];
        }

        parent::init();
    }
}
