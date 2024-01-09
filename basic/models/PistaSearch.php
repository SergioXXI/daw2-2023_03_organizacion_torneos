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
    public $disciplinaNombre;
    public $busquedaGlobal;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'direccion_id', 'disciplina_id'], 'integer'],
            [['nombre', 'descripcion', 'direccionCompleta', 'disciplinaNombre', 'busquedaGlobal'], 'safe'],
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

        $orden->attributes['disciplinaNombre'] = [
            'asc' => ['disciplina.nombre' => SORT_ASC],
            'desc' => ['disciplina.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        //Realizar el join con la tabla Direccion en caso de ser necesario
        if(isset($orden->attributeOrders['direccionCompleta']) || !empty($this->direccionCompleta) || !empty($this->busquedaGlobal))
            $query->joinWith(['direccion']);
        
        //Realizar el join con la tabla Disciplina en caso de ser necesario
        if(isset($orden->attributeOrders['disciplinaNombre']) || !empty($this->disciplinaNombre)  || !empty($this->busquedaGlobal))
            $query->joinWith(['disciplina']);


        //Filtros básicos por campo
        $query->andFilterWhere([
            'id' => $this->id,
            'direccion_id' => $this->direccion_id,
            'disciplina_id' => $this->disciplina_id,
        ]);
        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);



        /* FILTROS DE BUSQUEDA POR DIRECCION COMPLETA */
        
        //Obtener la expresión usada para poder llevar a cabo este filtro
        $expresionDireccionCompleta = $query->porDireccionCompleta($this->direccionCompleta);
        $query->andFilterWhere(['like', $expresionDireccionCompleta , $this->direccionCompleta]);

        /* FILTROS DE BUSQUEDA POR DISCIPLINA NOMBRE  */
        
        //Obtener la expresión usada para poder llevar a cabo este filtro
        $query->andFilterWhere(['like','disciplina.nombre',$this->disciplinaNombre]);


        /* FILTROS DE BUSQUEDA GLOBAL */

        $query->andFilterWhere(['like', 'pista.nombre', $this->busquedaGlobal])
                ->orFilterWhere(['like', 'pista.descripcion', $this->busquedaGlobal])
                ->orFilterWhere(['like', 'pista.id', $this->busquedaGlobal])
                ->orFilterWhere(['like', 'direccion_id', $this->busquedaGlobal])
                ->orFilterWhere(['like', 'disciplina.nombre', $this->busquedaGlobal])
                ->orFilterWhere(['like', $expresionDireccionCompleta, $this->busquedaGlobal]);

        return $dataProvider;
    }
}
