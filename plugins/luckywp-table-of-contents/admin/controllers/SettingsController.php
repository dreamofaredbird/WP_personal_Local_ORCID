<?php

namespace luckywp\tableOfContents\admin\controllers;

use luckywp\tableOfContents\core\admin\AdminController;

class SettingsController extends AdminController
{

    public function actionIndex()
    {
        $this->render('index');
    }
}
