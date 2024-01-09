<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%categoria}}".
 *
 * @property int $id
 * @property string $nombre
 * @property int $edad_min
 * @property int $edad_max
 *
 * @property Equipo[] $equipos
 * @property Premio[] $premios
 * @property TorneoCategoria[] $torneoCategorias
 * @property Torneo[] $torneos
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%categoria}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'edad_min', 'edad_max'], 'required'],
            [['edad_min', 'edad_max'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['nombre'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'edad_min' => Yii::t('app', 'Edad Min'),
            'edad_max' => Yii::t('app', 'Edad Max'),
        ];
    }

    /**
     * Gets query for [[Equipos]].
     *
     * @return \yii\db\ActiveQuery|EquipoQuery
     */
    public function getEquipos()
    {
        return $this->hasMany(Equipo::class, ['categoria_id' => 'id']);
    }

    /**
     * Gets query for [[Premios]].
     *
     * @return \yii\db\ActiveQuery|PremioQuery
     */
    public function getPremios()
    {
        return $this->hasMany(Premio::class, ['categoria_id' => 'id']);
    }

    /**
     * Gets query for [[TorneoCategorias]].
     *
     * @return \yii\db\ActiveQuery|TorneoCategoriaQuery
     */
    public function getTorneoCategorias()
    {
        return $this->hasMany(TorneoCategoria::class, ['categoria_id' => 'id']);
    }

    /**
     * Gets query for [[Torneos]].
     *
     * @return \yii\db\ActiveQuery|TorneoQuery
     */
    public function getTorneos()
    {
        return $this->hasMany(Torneo::class, ['id' => 'torneo_id'])->viaTable('{{%torneo_categoria}}', ['categoria_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CategoriaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoriaQuery(get_called_class());
    }
}
