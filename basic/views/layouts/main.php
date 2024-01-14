<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\web\View;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
$this->registerJsFile('https://kit.fontawesome.com/6a8d4512ef.js', ['position' => View::POS_HEAD]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            ['label' => 'Test', 'url' => ['/test/index']],
            ['label' => 'Torneos', 'url' => ['/torneo/index']],
            ['label' => 'Disciplinas', 'url' => ['/disciplina/index']],
            ['label' => 'Clases de torneo', 'url' => ['/clase/index']],
            ['label' => 'Reservas', 'url' => ['/reserva/index']],
            ['label' => 'Materiales', 'url' => ['/material/index']],
            ['label' => 'Partidos', 'url' => ['/partido/index']],
            [
                'label' => 'Registro',
                'url' => ['/user/register'],
                'visible' => Yii::$app->user->isGuest || (Yii::$app->user->can('gestor') && !Yii::$app->user->can('admin') && !Yii::$app->user->can('sysadmin')),
            ],            
            !Yii::$app->user->isGuest && (Yii::$app->user->can('admin') || Yii::$app->user->can('sysadmin'))
                ? ['label' => 'Usuarios', 'url' => ['/user']]
                : '',
            Yii::$app->user->can('sysadmin')
                ? ['label' => 'Roles', 'url' => ['/auth-item']]
                : '',
            ['label' => 'Pistas', 'url' => ['/pista/pistas']],
            ['label' => 'Modificar Pistas', 'url' => ['/pista/index']],
            ['label' => 'Modificar Direccion', 'url' => ['/direccion/index']],
            ['label' => 'Modificar Reserva Pista', 'url' => ['/reserva-pista/index']],
            ['label' => 'Modificar Logs', 'url' => ['/log/index']],
            ['label' => 'Calendario', 'url' => ['/calendario/index']],
            Yii::$app->user->isGuest
                ? ['label' => 'Login', 'url' => ['/site/login']]
                : ['label' => 'Mi Cuenta', 'url' => ['/user/view-profile/']],
            Yii::$app->user->isGuest
                ? ''
                : '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->email . ')',
                        ['class' => 'nav-link btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>',
        ]
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container mt-5">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget([ 
                    'links' => $this->params['breadcrumbs'],
                    'homeLink' => false,
                ]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
