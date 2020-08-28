<?php

namespace repoPhp\qrcode;

/**
 * This is just an example.
 */
class Qrcode extends \yii\base\Component
{
    public $name = 'qrcode';
    // image size in pixels
    public $height = 200;

    // image size in pixels
    public $width = 200;

    public $data;

    public $path = '@app/web/';

    protected $url = 'https://chart.googleapis.com/chart';

    public function qrcodePath($settings = [])
    {
        if($settings != []){
            foreach ($settings as $setting => $value){
                if(!property_exists($this,$setting)){
                    throw new \Exception('Error setting ' . $setting);
                }
                else{
                    $this->{$setting} = $value;
                }
            }
        }
        $this->validateProperties();
        return self::saveQr(self::getQr());
    }

    public function validateProperties()
    {
        if(!is_int($this->height)){
            \Yii::error('Height must be Integer');
            throw new \Exception('Height must be Integer');
        }
        if(!is_int($this->width)){
            \Yii::error('Width must be Integer');
            throw new \Exception('Width must be Integer');
        }
        if(!is_string($this->data)){
            \Yii::error('Data must be String');
            throw new \Exception('Data must be String');
        }

    }

    protected function getQr(){
        $ch = curl_init();
        $getParams = [
            'cht' => 'qr',
            'chs' => $this->width . 'x' . $this->height,
            'chl' => $this->data,
        ];
        curl_setopt($ch, CURLOPT_URL, 'https://chart.googleapis.com/chart');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($getParams));
        $result = curl_exec($ch);



        if (curl_errno($ch)) {
            \Yii::error( 'Error:' . curl_error($ch));
        }
        else{
            return $result;
        }
        curl_close($ch);
    }

    protected function saveQr($qr){
        $saveTo = \Yii::getAlias($this->path);
        $fileName = $this->name . '.jpg';
        if(file_exists($saveTo . $fileName)) unlink($saveTo . $fileName);
        $fp = fopen($saveTo . $fileName,'x');
        fwrite($fp, $qr);
        fclose($fp);
        return str_replace('/','\\',$saveTo . $fileName);
    }


}

