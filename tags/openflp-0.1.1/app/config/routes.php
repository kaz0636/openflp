<?php
Router::connect('/api/config/load', array('controller' => 'api_config', 'action' => 'get'));
Router::connect('/api/config/save', array('controller' => 'api_config', 'action' => 'put'));
Router::connect('/api/pin/:action', array('controller' => 'api_pin'));
Router::connect('/api/feed/:action', array('controller' => 'api_feed'));
Router::connect('/api/folder/:action', array('controller' => 'api_folder'));

// e.g. /api/subs
Router::connect('/api/:action', array('controller' => 'api')); 

Router::connect('/subscribe/:feedlink', array('controller' => 'subscribe', 'action' => 'confirm'), array('feedlink' => 'https?.+'));
Router::connect('/import/:feedlink', array('controller' => 'import', 'action' => 'fetch'), array('feedlink' => 'https?.+'));
Router::connect('/about/:feedlink', array('controller' => 'about', 'action' => 'index'), array('feedlink' => 'https?.+'));
Router::connect('/user/:login_name', array('controller' => 'user', 'action' => 'index'));
Router::connect('/icon/:feed', array('controller' => 'icon', 'action' => 'get'), array('feed' => '.+'));
Router::connect('/favicon/:feed', array('controller' => 'icon', 'action' => 'get'), array('feed' => '.+'));

Router::connect('/utility/bookmarklet', array('controller' => 'utility_bookmarklet', 'action' => 'index'));


Router::connect('/signup', array('controller' => 'members', 'action' => 'create'));
Router::connect('/login', array('controller' => 'sessions', 'action' => 'create'));
Router::connect('/logout', array('controller' => 'sessions', 'action' => 'destroy'));

// root
Router::connect('/', array('controller' => 'reader', 'action' => 'welcome'));
