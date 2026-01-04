<?php

namespace app\modules\user;

use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    /**
     * Define o namespace onde o Yii buscará os controllers deste módulo
     */
    public $controllerNamespace = 'app\modules\user\controllers';

    public function init()
    {
        parent::init();

        // Aqui você pode adicionar configurações específicas do módulo,
        // como parâmetros ou componentes exclusivos.
    }
}