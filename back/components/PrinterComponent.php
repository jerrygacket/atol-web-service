<?php


namespace app\components;


use app\base\BasicComponent;


class PrinterComponent extends BasicComponent
{
    public function getAll() {
        $model = $this->getModel();

        return $model::find()->all();
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
}