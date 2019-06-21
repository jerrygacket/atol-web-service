<?php


namespace app\components;


use app\base\BasicComponent;
use app\models\Printers;
use Yii;


class PrinterComponent extends BasicComponent
{
    public $model;

    /**
     * @var $model Printers
     * @param string $id
     * @return Printers
     */
    public function getModel($params) {
        $model = new $this->nameClass(
            $this->nameClass::findOne(
                ['printer_id' => ($params['info']['printer_id'] ?? '')]
            )
        );

        return $model;
    }

    /**
     * @param $model Printers
     * @return mixed
     */
    public function getAll($model) {
        return $model::find()->cache(10)->all();
    }

    /**
     * @param $model Printers
     * @return mixed
     */
    public function getOne($model) {
        return $model::find()
            ->where(['printer_id' => $model->printer_id])
            ->cache(10)
            ->one();
    }

    public function createPrinter(&$model):bool {
        return false;
    }

    public function editPrinter(&$model):bool {
        return false;
    }

    /**
     * @param $model Printers
     * @return bool
     * @throws \yii\base\ExitException
     */
    public function openShift($model) {
        $result = false;
        if (!$model->isShiftOpen()) {
            $response = $model->openShift();
            if ($response) {
//                $result['shift_open'] = ($response['results'][0]['result']['deviceStatus']['shift'] == 'open');
//                $result['connected'] = ($response['results'][0]['status'] == 'ready');
                print_r($response);
                Yii::$app->end();
                $result = true;
            }
        }

        return $result;
    }

    /**
     * @param $model Printers
     * @return mixed
     */
    public function closeShift($model) {
        $result = false;
        if ($model->isShiftOpen()) {
            $response = $model->closeShift();
            if ($response) {
//                $result['shift_open'] = ($response['results'][0]['result']['deviceStatus']['shift'] == 'open');
//                $result['connected'] = ($response['results'][0]['status'] == 'ready');
                print_r($response);
                Yii::$app->end();
                $result = true;
            }
        }

        return $result;
    }

    public function printSellReceipt($params) {
        $model = $this->getModel();
        $model->load($params['info']['printer_id'] ?? '');
        $result = $model->printSellReceipt($params);

        return $result;
    }

    /**
     * @param $model Printers
     * @return mixed
     */
    public function status($model) {
        $response = $model->checkKKT();
        if ($response) {
            $result['shift_open'] = ($response['results'][0]['result']['deviceStatus']['shift'] == 'open');
            $result['connected'] = ($response['results'][0]['status'] == 'ready');
        } else {
            $result['error'] = 'Error while get status';
        }

        return $result;
    }
}