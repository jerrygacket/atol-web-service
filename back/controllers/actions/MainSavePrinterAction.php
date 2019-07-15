<?php


namespace app\controllers\actions;


use app\base\BasicAction;
use app\components\PrinterComponent;
use app\models\Printers;
use Yii;

class MainSavePrinterAction extends BasicAction
{
    public function run ()
    {
        $result = ['error' => true,'message'=>'Bad request'];
        $data = json_decode(Yii::$app->request->getRawBody(),true);

        if (Yii::$app->request->isPost) {
            $result = ['error' => true,'message'=>'Empty request'];
            $component = Yii::createObject(['class' => PrinterComponent::class,'nameClass'=>'\app\models\Printers']);
            $model = Printers::find()
                ->where(['printer_id' => $data['printer_id']])
                ->one();;
            $model->setAttributes($data);
            if ($component->savePrinter($model)) {
                $result = [
                    'result' => [
                        'saved' => true,
                        'model' => $model,
                        'printer_id' => $model->getPrinterId(),
                    ],
                    'error' => false,
                ];
            } else {
                $result['message'] = 'Not saved';
            }
        }

        $this->SendJsonResponse($result);
    }
}