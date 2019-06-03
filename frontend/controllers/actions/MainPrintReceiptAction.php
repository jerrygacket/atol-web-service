<?php


use yii\base\Action;
use yii\web\Response;

class MainPrintReceiptAction extends Action
{
    public function run()
    {
        $result = ['error' => true,];

        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format=Response::FORMAT_JSON;

            $result = [
                'error'=>false,
                'result'=>[
                    'total'=>25,
                    'fiscalDocumentNumber'=>'2458',
                ]
            ];
        }

        return $result;
    }
}