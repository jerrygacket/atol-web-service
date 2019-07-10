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
        $data = json_decode(Yii::$app->request->getRawBody(),true);

        if (Yii::$app->request->isPost && array_key_exists('user_id', $data)) {
            $component = Yii::createObject(['class' => PrinterComponent::class,'nameClass'=>'\app\models\Printers']);
            $model = $component->getModel($data);
            if (array_key_exists('printer_id', $data)) {
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