<?php

namespace app\modules\conduit\components\validators;

use yii\validators\FilterValidator;

class HtmlPurifierFilter extends FilterValidator
{
    const HTML_ALLOWED_TAGS = 'b,strong,u,i,a[href]';

    public $config = [
        'HTML.Allowed' => '',
    ];

    public $encodeVariables = true;

    const PATTERN_ENCODED_VARIABLE = '(\%7B([\w]+)\%7D)';
    const REGEX_ENCODED_VARIABLE = '/' . self::PATTERN_ENCODED_VARIABLE . '/';

    public function init()
    {
        $this->filter = function ($value) {
            return static::execute($value, $this->config, $this->encodeVariables);
        };
        parent::init();
    }

    public static function execute($value, $configParams = [], $encodeVariables = true)
    {
        $purified = \yii\helpers\HtmlPurifier::process($value, function ($config) use ($configParams) {
            /** @var $config \HTMLPurifier_Config */
            foreach ($configParams as $key => $value) {
                $config->set($key, $value);
            }
        });

        if (!$encodeVariables) {
            $purified = static::revertEncodedVariables($purified);
        }

        return $purified;
    }

    protected static function revertEncodedVariables(string $purified)
    {
        return preg_replace(self::REGEX_ENCODED_VARIABLE, '{$2}', $purified);
    }
}
