<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Partido;

/**
 * PartidoSearch represents the model behind the search form of `app\models\Partido`.
 */
class PartidoSearch extends Partido
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jornada', 'torneo_id', 'direccion_id'], 'integer'],
            [['fecha'], 'safe'],
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
        $query = Partido::find();

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
            'jornada' => $this->jornada,
            'fecha' => $this->fecha,
            'torneo_id' => $this->torneo_id,
            'direccion_id' => $this->direccion_id,
        ]);

        return $dataProvider;
    }
}
