<?php

namespace repoPhp\qrcode;

/**
 * This is just an example.
 */
class Qrcode extends \yii\base\Component
{
    // image size in pixels
    public $height = 200;

    // image size in pixels
    public $width = 200;

    public $data;

    public $path = '@app/qrcode/';

    public function run()
    {
        return \Yii::getAlias($path);
    }


}

