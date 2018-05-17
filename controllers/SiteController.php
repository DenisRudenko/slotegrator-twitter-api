<?php

namespace app\controllers;

use yii\web\Controller;


class SiteController extends Controller
{
//    public function actions()
//    {
//        return ['error' => ['class' => 'yii\web\ErrorAction']];
//    }

    /**
     * Главная страница
     *
     * @return string
     */
    public function actionIndex()
    {

        var_dump(\app\modules\v1\controllers\ApiController::className());
        exit();
        return;
    }

}
