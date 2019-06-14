<?php


namespace app\controllers;


use app\components\PrinterComponent;
use app\controllers\actions\MainCloseShiftAction;
use app\controllers\actions\MainGetGoodsAction;
use app\controllers\actions\MainGetPrintersAction;
use app\controllers\actions\MainOpenShiftAction;
use app\controllers\actions\MainPrintReceiptAction;
use app\controllers\actions\MainStatusAction;
use Yii;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class MainController extends Controller
{
    public $enableCsrfValidation = false;
    public $component;

    public function init()
    {
        parent::init();

        $this->component = Yii::createObject(['class' => PrinterComponent::class,'nameClass'=>'\app\models\Printers']);
    }

    public function actions()
    {
        return [
            'getGoods'=>['class'=>MainGetGoodsAction::class],
            'getPrinters'=>['class'=>MainGetPrintersAction::class],
            'print'=>['class'=>MainPrintReceiptAction::class],
            'status'=>['class'=>MainStatusAction::class],
            'openShift'=>['class'=>MainOpenShiftAction::class],
            'closeShift'=>['class'=>MainCloseShiftAction::class],
        ];
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'corsFilter'  => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['POST','GET', 'HEAD', 'OPTIONS'],
                    'Access-Control-Allow-Credentials' => false,
                    'Access-Control-Max-Age' => 3600,
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Expose-Headers' => [],
                    'Access-Control-Allow-Origin' => ['*'],

                ],
            ],
        ]);
    }
}