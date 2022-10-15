<?php

namespace app\controllers;

use app\models\AppModel;
use app\widgets\language\Language;
use core\App;
use core\Controller;

class AppController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();

        APP::$app->setProperty('languages', Language::getAllLanguages());
        debug(App::$app->getProperty('languages'));
    }
}