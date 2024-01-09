<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%pista}}".
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property int $direccion_id
 * @property int $disciplina_id
 *
 * @property Direccion $direccion
 * @property Direccion $direccion
 * @property ReservaPista[] $reservaPista
 * @property Reserva[] $reservas
 */
class Pista extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pista}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'direccion_id', 'disciplina_id'], 'required', 'message' => 'Este campo es obligatorio'], //Mensaje personalizado en caso de fallo
            [['direccion_id', 'disciplina_id'], 'integer'],
            [['nombre', 'descripcion'], 'string', 'max' => 100],
            [['nombre'], 'unique'],
            [['direccion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direccion::class, 'targetAttribute' => ['direccion_id' => 'id']],
            [['disciplina_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direccion::class, 'targetAttribute' => ['disciplina_id' => 'id']],
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
            'direccion_id' => Yii::t('app', 'Direccion ID'),
            'disciplina_id' => Yii::t('app', 'Disciplina ID'),
            'disciplinaNombre' => Yii::t('app', 'Disciplina'),
            'direccionCompleta' => Yii::t('app', 'Dirección Completa'),
        ];
    }

    /**
     * Gets query for [[Direccion]].
     *
     * @return \yii\db\ActiveQuery|DireccionQuery
     */
    public function getDireccion()
    {
        return $this->hasOne(Direccion::class, ['id' => 'direccion_id']);
    }

    /**
     * Gets query for [[ReservaPista]].
     *
     * @return \yii\db\ActiveQuery|ReservaPistaQuery
     */
    public function getReservaPista()
    {
        return $this->hasMany(ReservaPista::class, ['pista_id' => 'id']);
    }

    /**
     * Gets query for [[Reservas]].
     *
     * @return \yii\db\ActiveQuery|ReservaQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reserva::class, ['id' => 'reserva_id'])->viaTable('{{%reserva_pista}}', ['pista_id' => 'id']);
    }

    /**
     * Gets query for [[Disciplina]].
     *
     * @return \yii\db\ActiveQuery|DisciplinaQuery
     */
    public function getDisciplina()
    {
        return $this->hasOne(Disciplina::class, ['id' => 'disciplina_id']);
    }

    /**
     * {@inheritdoc}
     * @return PistaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PistaQuery(get_called_class());
    }

    //Función que obtiene el objeto dirección asociado a la pista llamando a la función getDirección y posteriormente devuelve una string
    //con la dirección completa formateada uniendo los campos de la tabla Dirección
    public function getDireccionCompleta()
    {
        $direccion = $this->direccion;
        if($direccion !== null)
            return $direccion->DireccionCompleta; //Llamada a la función getDirecciónCompleta
        return null;
    }

    //Función que obtiene el objeto disciplina asociado a la pista llamando a la función getDisciplina y posteriormente devuelve una string
    //con el valor del campo nombre de la tabla disciplina
    public function getDisciplinaNombre()
    {
        $disciplina = $this->disciplina;
        if($disciplina !== null)
            return $disciplina->nombre; //Acceso al parametro nombre de disciplina
        return null;
    }
}
