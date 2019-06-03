<?php


namespace frontend\controllers;


use BaseController;
use MainGetGoodsAction;
use MainPrintReceiptAction;
use MainStatusAction;

class MainController extends BaseController
{
    public function actions()
    {
        return [
            'getGoods'=>['class'=>MainGetGoodsAction::class],
            'print'=>['class'=>MainPrintReceiptAction::class],
            'status'=>['class'=>MainStatusAction::class],
//            'openShift'=>['class'=>],
//            'closeShift'=>['class'=>],
        ];
    }
}