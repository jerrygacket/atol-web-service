<?php


namespace app\controllers\actions;


use app\base\BasicAction;
use app\components\PrinterComponent;
use Yii;


class DemoStatusAction extends BasicAction
{
    public function run()
    {
        $result = [
            'result' => [
                'connected' => true,
                'shift_open' => false,
            ],
            'error' => false,
        ];

        $this->SendJsonResponse($result);
    }
}