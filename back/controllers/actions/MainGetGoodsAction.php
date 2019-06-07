<?php


namespace app\controllers\actions;

use Yii;
use yii\base\Action;
use yii\helpers\Json;
use yii\web\Response;

class MainGetGoodsAction extends Action
{
    public function run()
    {
        $result = ['error' => true,];

        if (Yii::$app->request->isGet) {
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

        $object = (object) $result;
//        return json_encode($object);
        Yii::$app->response->data = $object; //Json::encode($object);
        Yii::$app->response->send();
//        return Json::encode($result);
        Yii::$app->end();
    }
}