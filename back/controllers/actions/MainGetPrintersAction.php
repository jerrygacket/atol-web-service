<?php


namespace app\controllers\actions;


use app\base\BasicAction;
use app\components\PrinterComponent;
use Yii;


class MainGetPrintersAction extends BasicAction
{

    public function run()
    {
        $result = ['error' => true,'message' => 'Wrong request'];

        if (Yii::$app->request->isGet && array_key_exists('info', Yii::$app->request->queryParams)) {
            $component = Yii::createObject(['class' => PrinterComponent::class,'nameClass'=>'\app\models\Printers']);
            $model = $component->getModel(Yii::$app->request->queryParams);
            if (array_key_exists('printer_id', Yii::$app->request->queryParams['info'])) {
                $printers = $component->getOne($model);
            } else {
                $printers = $component->getAll($model);
            }

            $result = [
                'result' => $printers,
                'error' => false,
                'message' => '',
            ];
        }

        $this->SendJsonResponse($result);
    }
}