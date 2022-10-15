<?php

namespace app\widgets\language;

use RedBeanPHP\R;

/**
 * Класс для виджета переключения языков
 */
class Language
{
    /**
     * название шаблона
     * @var string
     */
    protected $tpl;

    /**
     * Все доступные языки
     * @var
     */
    protected $allLanguages;

    /**
     * текущий язык
     * @var
     */
    protected $currentLanguage;

    public function __construct()
    {
        $this->tpl = __DIR__ . 'lang_tpl.php';
        $this->run();
    }

    /**
     * метод для запуска виджета
     * @return void
     */
    protected function run()
    {

    }

    /**
     * Метод для получения всех языков
     * @return array
     */
    public static function getAllLanguages() : array
    {
        return R::getAssoc("SELECT code, id, title, base FROM language ORDER BY base DESC");
    }

    /**
     * Метод для получения текущего языка
     * @param $languages
     * @return void
     */
    public static function getCurrentLanguage($languages)
    {

    }
}