<?php


namespace app\base;


use Yii;
use yii\base\Action;
use yii\web\Response;

class BasicAction extends Action
{
    public function SendJsonResponse(array $response) {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $object = (object) $response;
        Yii::$app->response->data = $object;
        Yii::$app->response->send();

        Yii::$app->end();
    }
}