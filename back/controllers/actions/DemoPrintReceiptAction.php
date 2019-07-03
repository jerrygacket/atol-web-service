<?php


namespace app\controllers\actions;


use app\base\BasicAction;
use Yii;


class DemoPrintReceiptAction extends BasicAction
{
    public function run()
    {
        $result = ['error' => true,'message' => 'Wrong request'];

        if (Yii::$app->request->isPost) {
            $data = json_decode(Yii::$app->request->getRawBody());
            $result = [
                'error' => false,
                'result' => [
                    'total' => 25,
                    'fiscalDocumentNumber' => '2458',
                    'goods' => $data->goods,
                    'type' => $data->type,
                ]
            ];
        }

        $this->SendJsonResponse($result);
    }
}