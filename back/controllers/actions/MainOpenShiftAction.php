<?php


namespace app\controllers\actions;


use app\base\BasicAction;
use app\components\PrinterComponent;
use function array_key_exists;
use Yii;


class MainOpenShiftAction extends BasicAction
{
    /**
     * @var $component PrinterComponent
     */
    public function run()
    {
        $result = ['error' => true,'message'=>'Bad request'];
        $data = json_decode(Yii::$app->request->getRawBody(),true);

        if (Yii::$app->request->isPost) {
            $component = Yii::createObject(['class' => PrinterComponent::class,'nameClass'=>'\app\models\Printers']);
            $model = $component->getModel($data);
            if ($model->connect_string !='') {
                $model->setOperator($data['operator']);
                if ($component->openShift($model)) {
                    $response = $component->status($model);
                    if (array_key_exists('error', $response)) {
                        $result['message'] = $response['error'];
                    } else {
                        $result = [
                            'result' => [
                                'connected' => $response['connected'],
                                'shift_open' => $response['shift_open'],
                                'printer_id' => $model->getPrinterId(),
                            ],
                            'error' => false,
                        ];
                    }
                } else {
                    $result['message'] = 'Shift not opened';
                }
            } else {
                $result['message'] = 'No printer id in DB';
            }

        }

        $this->SendJsonResponse($result);
    }
}