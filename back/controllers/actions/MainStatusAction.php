<?php


namespace app\controllers\actions;


use Yii;
use yii\base\Action;
use yii\helpers\Json;
use yii\web\Response;

class MainStatusAction extends Action
{
    public function run()
    {
        $result = ['error' => true,];

        if (Yii::$app->request->isGet) {
            Yii::$app->response->format=Response::FORMAT_JSON;

            $result = [
                'result' => [
                    'connected' => true,
                    'shift_open' => true,
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