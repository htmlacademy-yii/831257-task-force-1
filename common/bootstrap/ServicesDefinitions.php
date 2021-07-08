<?php

namespace common\bootstrap;

use yii\base\BootstrapInterface;
use frontend\models\Users;
use frontend\models\Cities;
use frontend\models\SignupForm;

/**
 *
 */
class ServicesDefinitions implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     * @see \yii\base\BootstrapInterface::bootstrap()
     */
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setDefinitions([
            SignupForm::class => function ($container, $params, $config) {
                return new SignupForm($container->get(Users::class), $container->get(Cities::class));
            },
            Users::class => function ($container, $params, $config) {
                return new Users($config);
            },
            Cities::class => function ($container, $params, $config) {
                return new Cities($config);
            }
        ]);
    }
}
