<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%torneo_normativa}}".
 *
 * @property int $torneo_id
 * @property int $normativa_id
 *
 * @property Normativa $normativa
 * @property Torneo $torneo
 */
class TorneoNormativa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%torneo_normativa}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['torneo_id', 'normativa_id'], 'required'],
            [['torneo_id', 'normativa_id'], 'integer'],
            [['torneo_id', 'normativa_id'], 'unique', 'targetAttribute' => ['torneo_id', 'normativa_id']],
            [['torneo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Torneo::class, 'targetAttribute' => ['torneo_id' => 'id']],
            [['normativa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Normativa::class, 'targetAttribute' => ['normativa_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'torneo_id' => Yii::t('app', 'Torneo ID'),
            'normativa_id' => Yii::t('app', 'Normativa ID'),
        ];
    }

    /**
     * Gets query for [[Normativa]].
     *
     * @return \yii\db\ActiveQuery|NormativaQuery
     */
    public function getNormativa()
    {
        return $this->hasOne(Normativa::class, ['id' => 'normativa_id']);
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
     * @return TorneoNormativaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TorneoNormativaQuery(get_called_class());
    }
}
