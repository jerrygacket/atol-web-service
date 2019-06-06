<?php


use yii\base\Action;
use yii\web\Response;

class MainGetGoodsAction extends Action
{
    public function run()
    {
        $result = ['error' => true,];

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

        return $result;
    }
}