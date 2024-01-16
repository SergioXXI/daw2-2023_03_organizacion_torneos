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
 * @property Usuario $usuario
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
     * Reglas de los campos del modelo
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
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
            [['creador_id'], 'exist', 'skipOnError' => true, 'targetClass' => Participante::class, 'targetAttribute' => ['creador_id' => 'id']],
            [['numParticipantes'], 'integer'],
        ];
    }

    /**
     * Etiquetas de los campos del modelo
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'licencia' => Yii::t('app', 'Licencia'),
            'categoria_id' => Yii::t('app', 'Categoria'),
            'numParticipantes' => Yii::t('app', 'Numero Participantes'),
            'creador_id' => Yii::t('app', 'Lider/Creador'),
        ];
    }

    /**
     * Devuelve el valor del campo creador_id de la tabla equipo
     *
     * @return \yii\db\ActiveQuery|CreadorQuery
     */
    public function getCreador()
    {
        return $this->hasOne(Participante::class, ['id' => 'creador_id']);
    }


    /**
     * Devuelve el valor del campo categoria_id de la tabla equipo
     *
     * @return \yii\db\ActiveQuery|CategoriaQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }
    

    /**
     * Devuelve los ids de equipos en los que se participa
     *
     * @return \yii\db\ActiveQuery|EquipoParticipanteQuery
     */
    public function getEquipoParticipantes()
    {
        return $this->hasMany(EquipoParticipante::class, ['equipo_id' => 'id']);
    }

    /**
     * Devuelve los participantes de un equipo a partir de la tabla equipo_participante
     *
     * @return \yii\db\ActiveQuery|ParticipanteQuery
     */
    public function getParticipantes()
    {
        return $this->hasMany(Participante::class, ['id' => 'participante_id'])->viaTable('{{%equipo_participante}}', ['equipo_id' => 'id']);
    }


    /**
     * Devuelve los usuarios que son participantes
     *
     * @return \yii\db\ActiveQuery|UsuarioQuery
     */
    public function getUsuario()  
    {
        return $this->hasOne(User::class, ['id' => 'usuario_id'])->viaTable('{{%participante}}', ['id' => 'creador_id']);
    }
    
    /**
     * Cuenta cuantos participantes tiene el equipo
     */
    public function getNumParticipantes()
    {
        return $this->getParticipantes()->count();
    }

    /**
     * Devuelve los partidos en los que participa un equipo
     *
     * @return \yii\db\ActiveQuery|PartidoEquipoQuery
     */
    public function getPartidoEquipos()
    {
        return $this->hasMany(PartidoEquipo::class, ['equipo_id' => 'id']);
    }

    /**
     * Devuelve el id de los partidos en los que participa un equipo a través de la tabla partido_equipo
     *
     * @return \yii\db\ActiveQuery|PartidoQuery
     */
    public function getPartidos()
    {
        return $this->hasMany(Partido::class, ['id' => 'partido_id'])->viaTable('{{%partido_equipo}}', ['equipo_id' => 'id']);
    }

    /**
     * Devuelve los premios que hay
     *
     * @return \yii\db\ActiveQuery|PremioQuery
     */
    public function getPremios()
    {
        return $this->hasMany(Premio::class, ['equipo_id' => 'id']);
    }

    /**
     * Devuelve los torneos en los que participan los equipos
     *
     * @return \yii\db\ActiveQuery|TorneoEquipoQuery
     */
    public function getTorneoEquipos()
    {
        return $this->hasMany(TorneoEquipo::class, ['equipo_id' => 'id']);
    }

    /**
     * Devuelve los torneos a partir de la tabla torneo_equipo
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
