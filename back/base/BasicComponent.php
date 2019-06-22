<?php


namespace app\base;


use Yii;
use yii\base\Component;

class BasicComponent extends Component
{
    public $nameClass;

    public function init()
    {
        parent::init();
        if (empty($this->nameClass)){
            throw new \Exception('no ClassName');
        }
    }
}