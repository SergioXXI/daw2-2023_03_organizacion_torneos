<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%direccion}}".
 *
 * @property int $id
 * @property string $calle
 * @property int|null $numero
 * @property int $cod_postal
 * @property string $ciudad
 * @property string $provincia
 * @property string $pais
 *
 * @property Pista[] $pista
 */
class Direccion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%direccion}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['calle', 'cod_postal', 'ciudad', 'provincia', 'pais'], 'required'],
            [['numero', 'cod_postal'], 'integer'],
            [['calle', 'ciudad', 'provincia', 'pais'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'calle' => Yii::t('app', 'Calle'),
            'numero' => Yii::t('app', 'Numero'),
            'cod_postal' => Yii::t('app', 'Cod Postal'),
            'ciudad' => Yii::t('app', 'Ciudad'),
            'provincia' => Yii::t('app', 'Provincia'),
            'pais' => Yii::t('app', 'Pais'),
        ];
    }

    /**
     * Gets query for [[Pista]].
     *
     * @return \yii\db\ActiveQuery|PistaQuery
     */
    public function getPista()
    {
        return $this->hasMany(Pista::class, ['direccion_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return DireccionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DireccionQuery(get_called_class());
    }

    //Función que devuelve una string con la dirección formateada mediante la concatenación
    //de campos pertenencientes al modelo
    // @return: String
    public function getDireccionCompleta()
    {
        return $this->calle . ' ' . $this->numero . ', ' . $this->ciudad . ', ' . $this->provincia . ', ' . $this->pais . ', CP: ' . $this->cod_postal;
    }

    //Función que devuelve un listado de todas las direcciones formateadas segun direccionCompleta
    // @return: array
    public static function getListadoDirecciones()
    {
        return ArrayHelper::map(Direccion::find()->all(), 'id', 'direccionCompleta');
    }
}
