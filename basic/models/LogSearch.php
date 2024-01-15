<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Log;

/**
 * LogSearch represents the model behind the search form of `app\models\Log`.
 */
class LogSearch extends Log
{

    public $fecha_ini;
    public $fecha_fin;
    public $fecha_posterior;
    public $fecha_anterior;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],

             [['fecha_fin','fecha_ini'], 'validadorRango',
             'message' => 'No se puede rellenar solo uno de los dos campos'],

            [['level', 'category', 'log_time', 'prefix', 'message', 'fecha_ini', 'fecha_fin', 'fecha_posterior', 'fecha_anterior'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Log::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        //Filtrado básico
        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        $query->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'log_time', $this->log_time])
            ->andFilterWhere(['like', 'prefix', $this->prefix])
            ->andFilterWhere(['like', 'message', $this->message]);

        
        //Filtros correspondientes a la sección temporal del buscador superior de la vista index 
        //Se tiene que transformar la fecha ya que se filtra por dia y está guardada en la base de datos con horas minutos y segundos
        $query->andFilterWhere(['>=', 'STR_TO_DATE(log_time, "%Y-%m-%d")' , $this->fecha_ini]);
        $query->andFilterWhere(['<=', 'STR_TO_DATE(log_time, "%Y-%m-%d")' , $this->fecha_fin]);
        $query->andFilterWhere(['>', 'STR_TO_DATE(log_time, "%Y-%m-%d")' , $this->fecha_posterior]);
        $query->andFilterWhere(['<', 'STR_TO_DATE(log_time, "%Y-%m-%d")' , $this->fecha_anterior]);

        return $dataProvider;
    }


    public function validadorRango($attribute, $params, $validator)
    {
        if(!empty($this->fecha_ini) && empty($this->fecha_fin)) $this->addError('fecha_fin', 'Este campo es obligatorio si se rellena el campo Desde.');

        if(!empty($this->fecha_fin) && empty($this->fecha_ini)) $this->addError('fecha_ini', 'Este campo es obligatorio si se rellena el campo Hasta.');
    }
}
