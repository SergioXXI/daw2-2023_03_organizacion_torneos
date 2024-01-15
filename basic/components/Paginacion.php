<?php

namespace app\components;

use yii\base\BaseObject;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;

use Yii;

class Paginacion extends BaseObject
{

    /*
     * Función que permite dado un dataProvider establecer una string que muestra
     * los elementos actuales mostrados y los totales
     * Componentes como LinkPager ya traen esto implementado por defecto pero solo
     * permiten utilizarlo dentro de su propia vista y además no está traducido al español
     * Por lo tanto se ha creado este método para más flexibilidad a la hora de mostrar este mensaje
    */
    public static function getRangoElementos($elementos, $total)
    {
        
        $pagina = Yii::$app->request->get('page',1);
        //Para generar el rango de objetos mostrados hay que ver cuantos elementos se muestran
        //por pagina y la página actual

        $rango_min = ($pagina-1) * $elementos + 1;
        $rango_max = min($pagina * $elementos, $total); //Valor mínimo entre los máximo elementos y los mostrados

        return Html::tag('div', 'Mostrando ' . Html::tag('b',$rango_min) . '-' . Html::tag('b',$rango_max) . ' de ' . Html::tag('b',$total) . ' elementos',['class' => 'summary']);
    }
}