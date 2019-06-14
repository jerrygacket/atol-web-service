<?php


namespace app\controllers\actions;


use app\base\BasicAction;
use Yii;


class MainPrintReceiptAction extends BasicAction
{
    public function run()
    {
        $result = ['error' => true,];

        if (Yii::$app->request->isPost) {
            $result = [
                'error'=>false,
                'result'=>[
                    'total'=>25,
                    'fiscalDocumentNumber'=>'2458',
                ]
            ];
        }

        $this->SendJsonResponse($result);
    }
}