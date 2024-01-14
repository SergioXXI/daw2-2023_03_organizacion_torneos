<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "clase".
 *
 * @property int $id
 * @property string $titulo
 * @property string|null $descripcion
 * @property int|null $imagen_id
 *
 * @property Imagen $imagen
 * @property Torneo[] $torneos
 */
class Clase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clase';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo'], 'required'],
            [['imagen_id'], 'integer'],
            [['titulo'], 'string', 'max' => 100],
            [['descripcion'], 'string', 'max' => 1000],
            //[['imagen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Imagen::class, 'targetAttribute' => ['imagen_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'imagen_id' => 'Imagen ID',
        ];
    }

    /**
     * Gets query for [[Imagen]].
     *
     * @return \yii\db\ActiveQuery|ImagenQuery
     */
    public function getImagen()
    {
        return $this->hasOne(Imagen::class, ['id' => 'imagen_id']);
    }

    /**
     * Gets query for [[Torneos]].
     *
     * @return \yii\db\ActiveQuery|TorneoQuery
     */
    public function getTorneos()
    {
        return $this->hasMany(Torneo::class, ['clase_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ClaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClaseQuery(get_called_class());
    }

    public static function getListadoClasePorId()
    {
        return ArrayHelper::map(Clase::find()->all(), 'id', 'titulo');
    }
}
