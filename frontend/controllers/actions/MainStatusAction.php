<?php


use yii\base\Action;
use yii\web\Response;

class MainStatusAction extends Action
{
    public function run()
    {
        $result = ['error' => true,];

        if (Yii::$app->request->isGet && Yii::$app->request->isAjax) {
            Yii::$app->response->format=Response::FORMAT_JSON;

            $result = [
                'result' => [
                    'connected' => true,
                    'shift_open' => true,
                ],
                'error' => false,
            ];
        }

        return $result;
    }
}