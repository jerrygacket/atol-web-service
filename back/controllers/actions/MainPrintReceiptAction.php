<?php


namespace app\controllers\actions;


use Yii;
use yii\base\Action;
use yii\helpers\Json;
use yii\web\Response;

class MainPrintReceiptAction extends Action
{
    public function run()
    {
        $result = ['error' => true,];

        if (Yii::$app->request->isPost) {
            Yii::$app->response->format=Response::FORMAT_JSON;

            $result = [
                'error'=>false,
                'result'=>[
                    'total'=>25,
                    'fiscalDocumentNumber'=>'2458',
                ]
            ];
        }

        Yii::$app->response->data = Json::encode($result);
        Yii::$app->response->send();

        Yii::$app->end();
    }
}