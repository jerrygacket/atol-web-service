<?php


namespace app\base;


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

    public function getModel() {
        return new $this->nameClass;
    }
}