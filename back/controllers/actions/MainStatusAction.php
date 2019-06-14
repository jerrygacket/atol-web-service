<?php


namespace app\controllers\actions;


use app\base\BasicAction;
use Yii;


class MainStatusAction extends BasicAction
{
    public function run()
    {
        $result = ['error' => true,];

        if (Yii::$app->request->isGet) {
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