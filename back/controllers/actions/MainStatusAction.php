<?php


namespace app\controllers\actions;


use app\base\BasicAction;
use app\components\PrinterComponent;
use Yii;


class MainStatusAction extends BasicAction
{
    public function run()
    {
        $result = ['error' => true,];

        if (Yii::$app->request->isGet) {
            $component = Yii::createObject(['class' => PrinterComponent::class,'nameClass'=>'\app\models\Printers']);
            $model = $component->getModel(Yii::$app->request->queryParams);
            if ($model->connect_string !='') {
                $response = $component->status($model);

                if (array_key_exists('error', $response)) {
                    $result['message'] = $response['error'];
                } else {
                    $result = [
                        'result' => [
                            'connected' => $response['connected'],
                            'shift_open' => $response['shift_open'],
                        ],
                        'error' => false,
                    ];
                }
            } else {
                $result['message'] = 'No printer id in DB';
            }
        }

        $this->SendJsonResponse($result);
    }
}