<?php

use yii\base\Action;
use yii\web\Controller;


class BaseController extends Controller
{
    /**
     * @param $action Action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        // TODO: redirect to auth
        return parent::beforeAction($action);
    }

    /**
     * @param \yii\base\Action $action
     * @param mixed $result
     * @return mixed
     */
    public function afterAction($action, $result)
    {
        return parent::afterAction($action, $result);
    }
}