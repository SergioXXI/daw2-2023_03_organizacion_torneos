<?php
namespace app\models;

use yii\db\ActiveRecord;

class torneo extends ActiveRecord
{
    public static function torneo()
    {
        return '{{%torneo}}'; // Replace 'your_table_name' with your actual table name
    }

    /*public function rules()
    {
        return [
            [['column1', 'column2', 'column3', 'column4', 'column5'], 'required'],
            [['column1', 'column2', 'column3', 'column4', 'column5'], 'safe'],
            // Add more validation rules as needed
        ];
    }*/

    // Assuming your table has columns: id, column1, column2, column3, column4, column5

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'nombre',
            'descripcion' => 'descripcion',
            'participantes_max' => 'participantes_max',
            'disciplina_id' => 'disciplina_id',
            'tipo_torneo_id' => 'tipo_torneo_id',
            'clase_id' => 'clase_id',
        ];
    }
}
?>