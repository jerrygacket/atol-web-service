<?php


namespace app\controllers\actions;


use app\base\BasicAction;
use app\components\PrinterComponent;


class DemoOpenShiftAction extends BasicAction
{
    /**
     * @var $component PrinterComponent
     */
    public function run()
    {
        $result = [
            'result' => [
                'connected' => true,
                'shift_open' => true,
            ],
            'error' => false,
        ];

        $this->SendJsonResponse($result);
    }
}