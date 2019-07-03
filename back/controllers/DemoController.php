<?php


namespace app\controllers;


use app\controllers\actions\DemoCloseShiftAction;
use app\controllers\actions\DemoOpenShiftAction;
use app\controllers\actions\DemoPrintReceiptAction;
use app\controllers\actions\DemoStatusAction;
use yii\web\Controller;

class DemoController extends Controller
{
    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            'print'=>['class'=>DemoPrintReceiptAction::class],
            'status'=>['class'=>DemoStatusAction::class],
            'openShift'=>['class'=>DemoOpenShiftAction::class],
            'closeShift'=>['class'=>DemoCloseShiftAction::class],
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }
}