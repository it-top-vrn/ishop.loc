<?php

use core\Router;

Router::add('^form/auth/?$', ['controller' => 'form', 'action' => 'auth']);
Router::add('^admin/?$', ['controller' => 'main', 'action' => 'index', 'admin_prefix' => 'admin']);
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
//Router::add('^(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)/?');
