<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pista;

/**
 * PistaSearch represents the model behind the search form of `app\models\Pista`.
 */
class PistaSearch extends Pista
{

    public $direccionCompleta;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'direccion_id'], 'integer'],
            [['nombre', 'descripcion', 'direccionCompleta'], 'safe'],
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
        $query = Pista::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //Esto permite ordenar segun la dirección
        $orden = $dataProvider->getSort();
        $orden->attributes['direccionCompleta'] = [
            'asc' => ['calle' => SORT_ASC],
            'desc' => ['calle' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'direccion_id' => $this->direccion_id,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        //Join con la tabla dirección
        if(isset($orden->attributeOrders['direccionCompleta']) || !empty($this->direccionCompleta))
            $query->joinWith(['direccion']);

        $query->porDireccionCompleta($this->direccionCompleta);

        return $dataProvider;
    }
}
