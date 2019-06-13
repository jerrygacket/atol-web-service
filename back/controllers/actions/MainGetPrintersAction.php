<?php


namespace app\controllers\actions;


use app\base\BasicAction;
use Yii;


class MainGetPrintersAction extends BasicAction
{

    public function run()
    {
        $result = ['error' => true,];

        if (Yii::$app->request->isGet && array_key_exists('info', Yii::$app->request->queryParams)) {
            if (array_key_exists('printer_id', Yii::$app->request->queryParams['info'])) {
                $printers = $this->controller->component->getOne(Yii::$app->request->queryParams['info']);
            } else {
                $printers = $this->controller->component->getAll();
            }

            $result = [
                'result' => $printers,
                'error' => false,
            ];
        }

        $this->SendJsonResponse($result);
    }
}