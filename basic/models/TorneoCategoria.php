<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%torneo_categoria}}".
 *
 * @property int $torneo_id
 * @property int $categoria_id
 *
 * @property Categorium $categoria
 * @property Torneo $torneo
 */
class TorneoCategoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%torneo_categoria}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['torneo_id', 'categoria_id'], 'required'],
            [['torneo_id', 'categoria_id'], 'integer'],
            [['torneo_id', 'categoria_id'], 'unique', 'targetAttribute' => ['torneo_id', 'categoria_id']],
            [['torneo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Torneo::class, 'targetAttribute' => ['torneo_id' => 'id']],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorium::class, 'targetAttribute' => ['categoria_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'torneo_id' => Yii::t('app', 'Torneo ID'),
            'categoria_id' => Yii::t('app', 'Categoria ID'),
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery|CategoriumQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categorium::class, ['id' => 'categoria_id']);
    }

    /**
     * Gets query for [[Torneo]].
     *
     * @return \yii\db\ActiveQuery|TorneoQuery
     */
    public function getTorneo()
    {
        return $this->hasOne(Torneo::class, ['id' => 'torneo_id']);
    }

    /**
     * {@inheritdoc}
     * @return TorneoCategoriaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TorneoCategoriaQuery(get_called_class());
    }
}
