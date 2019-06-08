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

        $object = (object) $result;
//        return json_encode($object);
        Yii::$app->response->data = $object; //Json::encode($object);
        Yii::$app->response->send();

        Yii::$app->end();

        //return json_encode($result);
    }
}