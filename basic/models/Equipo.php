<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%equipo}}".
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property string $licencia Numero de licencia
 * @property int $categoria_id
 *
 * @property Categoria $categoria
 * @property EquipoParticipante[] $equipoParticipantes
 * @property Participante[] $participantes
 * @property PartidoEquipo[] $partidoEquipos
 * @property Partido[] $partidos
 * @property Premio[] $premios
 * @property TorneoEquipo[] $torneoEquipos
 * @property Torneo[] $torneos
 */
class Equipo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%equipo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'licencia', 'categoria_id'], 'required'],
            [['categoria_id'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['descripcion'], 'string', 'max' => 10000],
            [['licencia'], 'string', 'max' => 250],
            [['nombre'], 'unique'],
            [['licencia'], 'unique'],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
            [['numParticipantes'], 'integer'],
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
            'descripcion' => Yii::t('app', 'Descripcion'),
            'licencia' => Yii::t('app', 'Licencia'),
            'categoria_id' => Yii::t('app', 'Categoria ID'),
            'numParticipantes' => Yii::t('app', 'Numero Participantes'),
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery|CategoriaQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }

    /**
     * Gets query for [[EquipoParticipantes]].
     *
     * @return \yii\db\ActiveQuery|EquipoParticipanteQuery
     */
    public function getEquipoParticipantes()
    {
        return $this->hasMany(EquipoParticipante::class, ['equipo_id' => 'id']);
    }

    /**
     * Gets query for [[Participantes]].
     *
     * @return \yii\db\ActiveQuery|ParticipanteQuery
     */
    public function getParticipantes()
    {
        return $this->hasMany(Participante::class, ['id' => 'participante_id'])->viaTable('{{%equipo_participante}}', ['equipo_id' => 'id']);
    }

    //Función para contar cuantos participantes tiene el equipo
    public function getNumParticipantes()
    {
        return $this->getParticipantes()->count();
    }

    /**
     * Gets query for [[PartidoEquipos]].
     *
     * @return \yii\db\ActiveQuery|PartidoEquipoQuery
     */
    public function getPartidoEquipos()
    {
        return $this->hasMany(PartidoEquipo::class, ['equipo_id' => 'id']);
    }

    /**
     * Gets query for [[Partidos]].
     *
     * @return \yii\db\ActiveQuery|PartidoQuery
     */
    public function getPartidos()
    {
        return $this->hasMany(Partido::class, ['id' => 'partido_id'])->viaTable('{{%partido_equipo}}', ['equipo_id' => 'id']);
    }

    /**
     * Gets query for [[Premios]].
     *
     * @return \yii\db\ActiveQuery|PremioQuery
     */
    public function getPremios()
    {
        return $this->hasMany(Premio::class, ['equipo_id' => 'id']);
    }

    /**
     * Gets query for [[TorneoEquipos]].
     *
     * @return \yii\db\ActiveQuery|TorneoEquipoQuery
     */
    public function getTorneoEquipos()
    {
        return $this->hasMany(TorneoEquipo::class, ['equipo_id' => 'id']);
    }

    /**
     * Gets query for [[Torneos]].
     *
     * @return \yii\db\ActiveQuery|TorneoQuery
     */
    public function getTorneos()
    {
        return $this->hasMany(Torneo::class, ['id' => 'torneo_id'])->viaTable('{{%torneo_equipo}}', ['equipo_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return EquipoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EquipoQuery(get_called_class());
    }
}
