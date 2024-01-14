<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "direccion".
 *
 * @property int $id
 * @property string $calle
 * @property int|null $numero
 * @property int $cod_postal
 * @property string $ciudad
 * @property string $provincia
 * @property string $pais
 *
 * @property Partido[] $partidos
 * @property Pista[] $pistas
 */
class Direccion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'direccion';
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
     * Gets query for [[Partidos]].
     *
     * @return \yii\db\ActiveQuery|PartidoQuery
     */
    public function getPartidos()
    {
        return $this->hasMany(Partido::class, ['direccion_id' => 'id']);
    }

    /**
     * Gets query for [[Pistas]].
     *
     * @return \yii\db\ActiveQuery|PistaQuery
     */
    public function getPistas()
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
}
