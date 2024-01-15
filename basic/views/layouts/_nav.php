<?php 

use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Html;

/*
GENERAL - Inicio (todos) | (A = menu administración)

GRUPO 1 - 
    -> Registro [/user/register] -> Invitado
    -> Login [/site/login] -> Invitado
    -> Logout [/site/logout] -> Todos menos Invitado
    A<- Roles [/auth-item] -> sysadmin 
    A<- Usuarios [/user] -> sysadmin, admin
    -> Perfil [/user/view-profile/] -> Todos menos Invitado

GRUPO 2 -
    <- Torneos [/torneo/index] -> Todos
    A<- Partidos [partidoS/index]-> sysadmin, admin, organizador
    A<- Reservas [/reserva/index] -> sysadmin, admin, organizador, gestor
    A<- Disciplina [/disciplinas/index] -> sysadmin, admin
    A<- Categoria [/categoria/index] -> sysadmin, admin
    A<- Clase [/clase/index] -> sysadmin, admin
    A<- Tipo torneo [/tipo-torneo/index] -> sysadmin, admin
    A<- Premios ['premio/index'] -> sysadmin, admin, organizador

GRUPO 3 - 
    A<- Equipos ['/equipo/index'] => sysadmin, admin, gestor
    A<- Participantes ['participante/index'] => sysadmin, admin, gestor

GRUPO 4 - 
    <- Pistas ['pista/pistas'] -> Todos
    A<- Pistas ['pista/index'] -> sysadmin, admin
    A<- Direccion ['direccion/index] -> sysadmin, admin
    <- Calendario ['calendario/index] -> Todos
    A<- Backup ['backup/index'] -> sysadmin, admin
    A<- Logs ['log/index'] -> sysadmin, admin 
*/

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top'],
    'innerContainerOptions' => ['class' => 'container-fluid px-4'],
    'containerOptions' => ['class' => 'justify-content-between'],
]);

$elementos_izquierda = [
    ['label' => 'Inicio', 'url' => ['/site/index']],
    ['label' => 'Torneos', 'url' => ['/torneo/index']],
    ['label' => 'Partidos', 'url' => ['/partido/index']],
    ['label' => 'Pistas', 'url' => ['/pista/pistas']],
    ['label' => 'Calendario', 'url' => ['/calendario/index']],
    [
        'label' => 'Panel de administración',
        'items' => [
            ['label' => 'Usuarios', 'url' => ['/user/index'], 
                'visible' => Yii::$app->user->can('sysadmin') || Yii::$app->user->can('admin')],
            ['label' => 'Reservas', 'url' => ['/reserva/index'], 
                'visible' => Yii::$app->user->can('sysadmin') || Yii::$app->user->can('admin') || Yii::$app->user->can('organizador') || Yii::$app->user->can('gestor')],
            /* ['label' => 'Partidos', 'url' => ['/partido/index'], 
                'visible' => Yii::$app->user->can('sysadmin') || Yii::$app->user->can('admin') || Yii::$app->user->can('organizador')], */
            ['label' => 'Disciplinas', 'url' => ['/disciplina/index'], 
                'visible' => Yii::$app->user->can('sysadmin') || Yii::$app->user->can('admin')],
            ['label' => 'Categorias de Torneo', 'url' => ['/categoria/index'], 
                'visible' => Yii::$app->user->can('sysadmin') || Yii::$app->user->can('admin')],
            ['label' => 'Clases de Torneo', 'url' => ['/clase/index'], 
                'visible' => Yii::$app->user->can('sysadmin') || Yii::$app->user->can('admin')],
            ['label' => 'Tipo de Torneo', 'url' => ['/tipo-torneo/index'], 
                'visible' => Yii::$app->user->can('sysadmin') || Yii::$app->user->can('admin')],
            ['label' => 'Premios', 'url' => ['/premio/index'], 
                'visible' => Yii::$app->user->can('sysadmin') || Yii::$app->user->can('admin') || Yii::$app->user->can('organizador')],
            ['label' => 'Equipos', 'url' => ['/equipo/index'], 
                'visible' => Yii::$app->user->can('sysadmin') || Yii::$app->user->can('admin') || Yii::$app->user->can('gestor')],
            ['label' => 'Participantes', 'url' => ['/participante/index'], 
                'visible' => Yii::$app->user->can('sysadmin') || Yii::$app->user->can('admin') || Yii::$app->user->can('gestor')],
            ['label' => 'Pistas', 'url' => ['/pista/index'], 
                'visible' => Yii::$app->user->can('sysadmin') || Yii::$app->user->can('admin')],
            /* ['label' => 'Reserva Pistas', 'url' => ['/reserva-pista/index'], 'visible' => Yii::$app->user->can('sysadmin') || Yii::$app->user->can('admin')], */
            ['label' => 'Direcciones', 'url' => ['/direccion/index'], 
                'visible' => Yii::$app->user->can('sysadmin') || Yii::$app->user->can('admin')],
            ['label' => 'Backups base de datos', 'url' => ['/backup/index'], 
                'visible' => Yii::$app->user->can('sysadmin') || Yii::$app->user->can('admin')],
            ['label' => 'Logs', 'url' => ['/log/index'], 
                'visible' => Yii::$app->user->can('sysadmin') || Yii::$app->user->can('admin')],
            ['label' => 'Roles', 'url' => ['/auth-item/index'], 
                'visible' => Yii::$app->user->can('sysadmin')],
        ],
        'visible' => Yii::$app->user->can('sysadmin') || Yii::$app->user->can('admin') || Yii::$app->user->can('organizador') || Yii::$app->user->can('gestor'),
        'dropdownOptions' => [
            'class' => 'dropdown-menu-end dropdown-menu-dark',
        ],
    ],
];

//Si el usuario es invitado se le muestra el inicio de sesión
if(Yii::$app->user->isGuest) {
    $elementos_derecha = [
        ['label' => 'Iniciar sesión', 'url' => ['/site/login']],
        ['label' => 'Registrarse', 'url' => ['/user/register']],
    ];
} else {
    $elementos_derecha = [
        [
            'label' => Html::encode(Yii::$app->user->identity->nombre),
            'items' => [
                ['label' => 'Perfil', 'url' => ['/user/view-profile']],
                ['label' => 'Logout', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
            ],
            'dropdownOptions' => [
                'class' => 'dropdown-menu-end dropdown-menu-dark',
            ],
        ],
    ];
}


echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $elementos_izquierda,
]);


echo Nav::widget([
    'options' => ['class' => 'navbar-nav ml-auto'],
    'items' => $elementos_derecha,
]);

NavBar::end();
