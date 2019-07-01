<?php


namespace app\controllers\actions;


use app\base\BasicAction;


class DemoPrintReceiptAction extends BasicAction
{
    public function run()
    {
        $result = [
            'error'=>false,
            'result'=>[
                'total'=>25,
                'fiscalDocumentNumber'=>'2458',
            ]
        ];

        $this->SendJsonResponse($result);
    }
}