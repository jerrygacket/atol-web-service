<?php


namespace app\controllers\actions;


use app\base\BasicAction;
use Yii;


class MainOpenShiftAction extends BasicAction
{
    public function run()
    {
        $result = ['error' => true,];

        if (Yii::$app->request->isPost) {
            $result = [
                'result' => [
                    'connected' => true,
                    'shift_open' => true,
                ],
                'error' => false,
            ];
        }

        $this->SendJsonResponse($result);
    }
}