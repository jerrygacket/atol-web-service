<?php
namespace app\base;

use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class BaseController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return ArrayHelper::merge([
            'corsFilter'  => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['POST','GET', 'HEAD', 'OPTIONS'],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 3600,
                ],
            ],
        ], parent::behaviors());
    }


}