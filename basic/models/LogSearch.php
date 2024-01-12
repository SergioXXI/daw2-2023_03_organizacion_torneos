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

            [['fecha_ini', 'fecha_fin'], 'required', 'when' => function ($model) {
                return ((empty($model->fecha_ini) && !empty($model->fecha_fin)) || (!empty($model->fecha_ini) && empty($model->fecha_fin)));
            }, 'message' => 'No se puede rellenar solo uno de los dos campos'],

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

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'log_time', $this->log_time])
            ->andFilterWhere(['like', 'prefix', $this->prefix])
            ->andFilterWhere(['like', 'message', $this->message]);

        
        //Buscar 
        $query->andFilterWhere(['>', 'log_time' , $this->fecha_ini]);
        $query->andFilterWhere(['<', 'log_time' , $this->fecha_fin]);
        $query->andFilterWhere(['>', 'log_time' , $this->fecha_posterior]);
        $query->andFilterWhere(['<', 'log_time' , $this->fecha_anterior]);

        return $dataProvider;
    }
}
