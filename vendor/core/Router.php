<?php

namespace core;


/**
 * Класс маршрутизации
 */
class Router
{
    /**
     * Таблица маршрутов (ключ - шаблон regexp, значение - массив добавляемого маршрута)
     * @var array
     */
    protected static array $routes = [];

    /**
     * Текущий маршрут
     * @var array
     */
    protected static array $currentRoute = [];

    /**
     * Метод для добавления маршрута в таблицу маршрутов
     * @param $regexp - шаблон регулярного выражения
     * @param $route - маршрут
     * @return void
     */
    public static function add($regexp, $route = []) {
        self::$routes[$regexp] = $route;
    }

    /**
     * Метод получения таблицы маршрутов
     * @return array
     */
    public static function getRoutes() : array
    {
        return self::$routes;
    }

    /**
     * Метод получения текущего маршрута
     * @return array
     */
    public static function getRoute() : array
    {
        return self::$currentRoute;
    }

    /**
     * Метод для вызова нужного метода контроллера согласно таблице маршрутов
     * @param $url - кусок адресной строки относительно корня проекта
     * @return void
     */
    public static function dispatch($url)
    {
        if (self::matchRoutes($url)) {
            $controller = 'app\controllers\\' . self::$currentRoute['admin_prefix'] . self::$currentRoute['controller'] . 'Controller';
            if (class_exists($controller)) {
                $controllerObject = new $controller(self::$currentRoute);
                $action = self::$currentRoute['action'] . 'Action';
                if (method_exists($controllerObject, $action)) {
                    $controllerObject->$action();
                } else {
                    throw new \Exception("Метод {$controller}::{$action} не найден", 404);
                }
            } else {
                throw new \Exception("Контроллер {$controller} не найден", 404);
            }
        } else {
            throw new \Exception("Страница не найдена", 404);
        }
    }

    /**
     * Метод для поиска совпадения url с таблицей маршрутов и перенаправления на соответствующий controller
     * @param $url - текущий запрос
     * @return bool
     */
    public static function matchRoutes($url) : bool
    {
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#{$pattern}#", $url, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                }
                if (empty($route['action'])) {
                    $route['action'] = 'index';
                }
                if (!isset($route['admin_prefix'])) {
                    $route['admin_prefix'] = '';
                } else {
                    $route['admin_prefix'] .= '\\';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                $route['action'] = self::lowerCamelCase($route['action']);
                self::$currentRoute = $route;
                return true;
            }
        }
        return false;
    }

    /**
     * Метод для преведения строки к upperCamelCase
     * @param $name - строка
     * @return array|string|string[]
     */
    protected static function upperCamelCase($name)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    /**
     * Метод для преведения строки к lowerCamelCase
     * @param $name - строка
     * @return string
     */
    protected static function lowerCamelCase($name)
    {
        return lcfirst(self::upperCamelCase($name));
    }
}
