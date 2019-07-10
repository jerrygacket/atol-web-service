<?php


namespace app\controllers\actions;


use app\base\BasicAction;
use Yii;


class MainGetGoodsAction extends BasicAction
{
    public function run()
    {
        $result = ['error' => true,];

        if (Yii::$app->request->isPost) {
            //TODO: заменить на получение товаров из ДБ
            $goods = [];
            for ($i=0;$i<10;$i++) {
                $goods[] = [
                    'product_id' => $i,
                    'name' => 'prodName'.$i,
                    'price' => $i+5,
                ];
            }

            $result = [
                'result' => $goods,
                'error' => false,
            ];
        }

        $this->SendJsonResponse($result);
    }
}