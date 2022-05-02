<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/entite/depot' => [[['_route' => 'app_entite_depot_index', '_controller' => 'App\\Controller\\Entite\\DepotController::index'], null, ['GET' => 0], null, true, false, null]],
        '/entite/depot/new' => [[['_route' => 'app_entite_depot_new', '_controller' => 'App\\Controller\\Entite\\DepotController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/entite/entite' => [[['_route' => 'app_entite_entite_index', '_controller' => 'App\\Controller\\Entite\\EntiteController::index'], null, ['GET' => 0], null, true, false, null]],
        '/entite/entite/new' => [[['_route' => 'app_entite_entite_new', '_controller' => 'App\\Controller\\Entite\\EntiteController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/entite/sous/entite' => [[['_route' => 'app_entite_sous_entite_index', '_controller' => 'App\\Controller\\Entite\\SousEntiteController::index'], null, ['GET' => 0], null, true, false, null]],
        '/entite/sous/entite/new' => [[['_route' => 'app_entite_sous_entite_new', '_controller' => 'App\\Controller\\Entite\\SousEntiteController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/ged/fichier' => [[['_route' => 'app_ged_fichier_index', '_controller' => 'App\\Controller\\Ged\\FichierController::index'], null, ['GET' => 0], null, true, false, null]],
        '/ged/fichier/new' => [[['_route' => 'app_ged_fichier_new', '_controller' => 'App\\Controller\\Ged\\FichierController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/ged/type/fichier' => [[['_route' => 'app_ged_type_fichier_index', '_controller' => 'App\\Controller\\Ged\\TypeFichierController::index'], null, ['GET' => 0], null, true, false, null]],
        '/ged/type/fichier/new' => [[['_route' => 'app_ged_type_fichier_new', '_controller' => 'App\\Controller\\Ged\\TypeFichierController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/' => [[['_route' => 'app_home', '_controller' => 'App\\Controller\\HomeController::index'], null, null, null, false, false, null]],
        '/interlocuteur/interlocuteur' => [[['_route' => 'app_interlocuteur_interlocuteur_index', '_controller' => 'App\\Controller\\Interlocuteur\\InterlocuteurController::index'], null, ['GET' => 0], null, true, false, null]],
        '/interlocuteur/interlocuteur/new' => [[['_route' => 'app_interlocuteur_interlocuteur_new', '_controller' => 'App\\Controller\\Interlocuteur\\InterlocuteurController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/login' => [[['_route' => 'app_login', '_controller' => 'App\\Controller\\SecurityController::login'], null, null, null, false, false, null]],
        '/logout' => [[['_route' => 'app_logout', '_controller' => 'App\\Controller\\SecurityController::logout'], null, null, null, false, false, null]],
        '/user/poste' => [[['_route' => 'app_user_poste_index', '_controller' => 'App\\Controller\\User\\PosteController::index'], null, ['GET' => 0], null, true, false, null]],
        '/user/poste/new' => [[['_route' => 'app_user_poste_new', '_controller' => 'App\\Controller\\User\\PosteController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/user/service' => [[['_route' => 'app_user_service_index', '_controller' => 'App\\Controller\\User\\ServiceController::index'], null, ['GET' => 0], null, true, false, null]],
        '/user/service/new' => [[['_route' => 'app_user_service_new', '_controller' => 'App\\Controller\\User\\ServiceController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/user' => [[['_route' => 'app_user_index', '_controller' => 'App\\Controller\\UserController::index'], null, ['GET' => 0], null, true, false, null]],
        '/user/new' => [[['_route' => 'app_user_new', '_controller' => 'App\\Controller\\UserController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:102)'
                            .'|router(*:116)'
                            .'|exception(?'
                                .'|(*:136)'
                                .'|\\.css(*:149)'
                            .')'
                        .')'
                        .'|(*:159)'
                    .')'
                .')'
                .'|/entite/(?'
                    .'|depot/([^/]++)(?'
                        .'|(*:197)'
                        .'|/edit(*:210)'
                        .'|(*:218)'
                    .')'
                    .'|entite/([^/]++)(?'
                        .'|(*:245)'
                        .'|/edit(*:258)'
                        .'|(*:266)'
                    .')'
                    .'|sous/entite/([^/]++)(?'
                        .'|(*:298)'
                        .'|/edit(*:311)'
                        .'|(*:319)'
                    .')'
                .')'
                .'|/ged/(?'
                    .'|fichier/([^/]++)(?'
                        .'|(*:356)'
                        .'|/edit(*:369)'
                        .'|(*:377)'
                    .')'
                    .'|type/fichier/([^/]++)(?'
                        .'|(*:410)'
                        .'|/edit(*:423)'
                        .'|(*:431)'
                    .')'
                .')'
                .'|/interlocuteur/interlocuteur/([^/]++)(?'
                    .'|(*:481)'
                    .'|/edit(*:494)'
                    .'|(*:502)'
                .')'
                .'|/user/(?'
                    .'|poste/([^/]++)(?'
                        .'|(*:537)'
                        .'|/edit(*:550)'
                        .'|(*:558)'
                    .')'
                    .'|service/([^/]++)(?'
                        .'|(*:586)'
                        .'|/edit(*:599)'
                        .'|(*:607)'
                    .')'
                    .'|([^/]++)(?'
                        .'|(*:627)'
                        .'|/edit(*:640)'
                        .'|(*:648)'
                    .')'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        102 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        116 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        136 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        149 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        159 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        197 => [[['_route' => 'app_entite_depot_show', '_controller' => 'App\\Controller\\Entite\\DepotController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        210 => [[['_route' => 'app_entite_depot_edit', '_controller' => 'App\\Controller\\Entite\\DepotController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        218 => [[['_route' => 'app_entite_depot_delete', '_controller' => 'App\\Controller\\Entite\\DepotController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        245 => [[['_route' => 'app_entite_entite_show', '_controller' => 'App\\Controller\\Entite\\EntiteController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        258 => [[['_route' => 'app_entite_entite_edit', '_controller' => 'App\\Controller\\Entite\\EntiteController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        266 => [[['_route' => 'app_entite_entite_delete', '_controller' => 'App\\Controller\\Entite\\EntiteController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        298 => [[['_route' => 'app_entite_sous_entite_show', '_controller' => 'App\\Controller\\Entite\\SousEntiteController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        311 => [[['_route' => 'app_entite_sous_entite_edit', '_controller' => 'App\\Controller\\Entite\\SousEntiteController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        319 => [[['_route' => 'app_entite_sous_entite_delete', '_controller' => 'App\\Controller\\Entite\\SousEntiteController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        356 => [[['_route' => 'app_ged_fichier_show', '_controller' => 'App\\Controller\\Ged\\FichierController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        369 => [[['_route' => 'app_ged_fichier_edit', '_controller' => 'App\\Controller\\Ged\\FichierController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        377 => [[['_route' => 'app_ged_fichier_delete', '_controller' => 'App\\Controller\\Ged\\FichierController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        410 => [[['_route' => 'app_ged_type_fichier_show', '_controller' => 'App\\Controller\\Ged\\TypeFichierController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        423 => [[['_route' => 'app_ged_type_fichier_edit', '_controller' => 'App\\Controller\\Ged\\TypeFichierController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        431 => [[['_route' => 'app_ged_type_fichier_delete', '_controller' => 'App\\Controller\\Ged\\TypeFichierController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        481 => [[['_route' => 'app_interlocuteur_interlocuteur_show', '_controller' => 'App\\Controller\\Interlocuteur\\InterlocuteurController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        494 => [[['_route' => 'app_interlocuteur_interlocuteur_edit', '_controller' => 'App\\Controller\\Interlocuteur\\InterlocuteurController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        502 => [[['_route' => 'app_interlocuteur_interlocuteur_delete', '_controller' => 'App\\Controller\\Interlocuteur\\InterlocuteurController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        537 => [[['_route' => 'app_user_poste_show', '_controller' => 'App\\Controller\\User\\PosteController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        550 => [[['_route' => 'app_user_poste_edit', '_controller' => 'App\\Controller\\User\\PosteController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        558 => [[['_route' => 'app_user_poste_delete', '_controller' => 'App\\Controller\\User\\PosteController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        586 => [[['_route' => 'app_user_service_show', '_controller' => 'App\\Controller\\User\\ServiceController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        599 => [[['_route' => 'app_user_service_edit', '_controller' => 'App\\Controller\\User\\ServiceController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        607 => [[['_route' => 'app_user_service_delete', '_controller' => 'App\\Controller\\User\\ServiceController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        627 => [[['_route' => 'app_user_show', '_controller' => 'App\\Controller\\UserController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        640 => [[['_route' => 'app_user_edit', '_controller' => 'App\\Controller\\UserController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        648 => [
            [['_route' => 'app_user_delete', '_controller' => 'App\\Controller\\UserController::delete'], ['id'], ['POST' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
