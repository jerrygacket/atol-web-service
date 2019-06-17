<?php


namespace app\components;


use app\base\BasicComponent;
use app\models\Printers;


class PrinterComponent extends BasicComponent
{
    public function getAll() {
        $model = $this->getModel();

        return $model::find()->cache(10)->all();
    }

    /*
     * @param array $params
     * @var $model Printers
     */
    public function getOne($params) {
        $model = $this->getModel();
        $model->load($params);

        return $model::find()
            ->where(['printer_id' => $params['printer_id']])
            ->one();
    }

    public function createPrinter(&$model):bool {
        return false;
    }

    public function editPrinter(&$model):bool {
        return false;
    }

    /**
     * @param $params
     * @return mixed
     * @var $model Printers
     */
    public function openShift($params) {
        $model = $this->getModel();
        $model->load($params['info']['printer_id']);
        $result = $model->openShift($params['info']['operator']);

        return $result;
    }

    public function closeShift($params) {
        $model = $this->getModel();
        $model->load($params['info']['printer_id']);
        $result = $model->closeShift();

        return $result;
    }

    public function printSellReceipt($params) {
        $model = $this->getModel();
        $model->load($params['info']['printer_id']);
        $result = $model->printSellReceipt($params['']);

        return false;
    }
}