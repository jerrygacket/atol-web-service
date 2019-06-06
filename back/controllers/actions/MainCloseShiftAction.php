<?php


namespace app\controllers\actions;


use Yii;
use yii\helpers\Json;
use yii\web\Response;

class MainCloseShiftAction
{
    public function run()
    {
        $result = ['error' => true,];

        if (Yii::$app->request->isPost) {
            Yii::$app->response->format=Response::FORMAT_JSON;

            $result = [
                'result' => [
                    'connected' => true,
                    'shift_open' => false,
                ],
                'error' => false,
            ];
        }

        Yii::$app->response->data = Json::encode($result);
        Yii::$app->response->send();

        Yii::$app->end();

        //return json_encode($result);
    }
}