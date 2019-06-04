<?php


namespace frontend\controllers;


use Yii;
use yii\web\Controller;
use yii\web\Response;

class MainController extends Controller
{
//    public function actions()
//    {
//        return [
//            'getGoods'=>['class'=>\MainGetGoodsAction::class],
//            'print'=>['class'=>\MainPrintReceiptAction::class],
//            'status'=>['class'=>\MainStatusAction::class],
////            'openShift'=>['class'=>],
////            'closeShift'=>['class'=>],
//        ];
//    }
    public function actionStatus()
    {
        $result = ['error' => true,'message'=>'Это не ajax'];

        if (Yii::$app->request->isGet && Yii::$app->request->isAjax) {
            Yii::$app->response->format=Response::FORMAT_JSON;

            $result = [
                'result' => [
                    'connected' => true,
                    'shift_open' => true,
                ],
                'error' => false,
            ];
        }

        return json_encode($result);
    }

    public function actionGetgoods()
    {
        $result = ['error' => true,'message'=>'Это не ajax'];

        if (Yii::$app->request->isGet && Yii::$app->request->isAjax) {
            //TODO: заменить на получение товаров из ДБ

            $goods = [];
            for ($i=0;$i<10;$i++) {
                $goods[] = [
                    'product_id' => $i,
                    'name' => 'prodName'.$i,
                    'price' => $i+5,
                ];
            }
            Yii::$app->response->format=Response::FORMAT_JSON;

            $result = [
                'result' => $goods,
                'error' => false,
            ];
        }

        return json_encode($result);
    }

    public function actionPrint() {
        $result = ['error' => true,'message'=>'Это не ajax'];

        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format=Response::FORMAT_JSON;

            $result = [
                'error'=>false,
                'result'=>[
                    'total'=>25,
                    'fiscalDocumentNumber'=>'2458',
                ]
            ];
        }

        return json_encode($result);
    }
}