<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Direccion;

/**
 * DireccionSearch represents the model behind the search form of `app\models\Direccion`.
 */
class DireccionSearch extends Direccion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'numero', 'cod_postal'], 'integer'],
            [['calle', 'ciudad', 'provincia', 'pais'], 'safe'],
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
        $query = Direccion::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        //Filtros básicos por campo
        $query->andFilterWhere([
            'id' => $this->id,
            'numero' => $this->numero,
            'cod_postal' => $this->cod_postal,
        ]);
        $query->andFilterWhere(['like', 'calle', $this->calle])
            ->andFilterWhere(['like', 'ciudad', $this->ciudad])
            ->andFilterWhere(['like', 'provincia', $this->provincia])
            ->andFilterWhere(['like', 'pais', $this->pais]);

        return $dataProvider;
    }
}
