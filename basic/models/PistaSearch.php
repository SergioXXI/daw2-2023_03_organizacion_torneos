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

    public $direccionCompleta; //Dirección concatenada de la pista
    public $disciplinaNombre; //Nombre de la disciplina asociada a la pista
    public $direccionProvincia; //Campo provincia de la dirección asociada a la pista
    public $direccionCiudad; //Campo ciudad de la dirección asociada a la pista
    public $direccionPais; //Campo pais de la dirección asociada a la pista
    public $busquedaGlobal; //Parametro usado durante las busqueda por termino generales

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'direccion_id', 'disciplina_id'], 'integer'],
            [['nombre', 'descripcion', 'direccionCompleta', 'disciplinaNombre', 'busquedaGlobal', 'direccionProvincia', 'direccionCiudad', 'direccionPais'], 'safe'],
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

        //Ordenar en función del nombre de la disciplina asociada
        $orden->attributes['disciplinaNombre'] = [
            'asc' => ['disciplina.nombre' => SORT_ASC],
            'desc' => ['disciplina.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }


        //Realizar el join con la tabla Direccion en caso de ser necesario
        if(isset($orden->attributeOrders['direccionCompleta']) || !empty($this->direccionCompleta) || !empty($this->busquedaGlobal || !empty($this->direccionCiudad)
        || !empty($this->direccionProvincia) || !empty($this->direccionPais)))
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
        $query->andFilterWhere(['like', 'pista.nombre', $this->nombre])
            ->andFilterWhere(['like', 'pista.descripcion', $this->descripcion]);



        /* FILTROS DE BUSQUEDA POR DIRECCION COMPLETA */
        
        //Obtener la expresión usada para poder llevar a cabo este filtro
        $expresionDireccionCompleta = $query->porDireccionCompleta($this->direccionCompleta);
        $query->andFilterWhere(['like', $expresionDireccionCompleta , $this->direccionCompleta]);
        $query->andFilterWhere(['like','ciudad',$this->direccionCiudad]);
        $query->andFilterWhere(['like','provincia',$this->direccionProvincia]);
        $query->andFilterWhere(['like','pais',$this->direccionPais]);

        /* FILTROS DE BUSQUEDA POR DISCIPLINA NOMBRE  */
        
        //Obtener la expresión usada para poder llevar a cabo este filtro
        $query->andFilterWhere(['like','disciplina.nombre',$this->disciplinaNombre]);


        /* FILTROS DE BUSQUEDA GLOBAL */
        $query->andFilterWhere(['or',
            ['like', 'pista.nombre', $this->busquedaGlobal],
            ['like', 'pista.descripcion', $this->busquedaGlobal],
            ['like', 'pista.id', $this->busquedaGlobal],
            ['like', 'direccion_id', $this->busquedaGlobal],
            ['like', 'disciplina.nombre', $this->busquedaGlobal],
            ['like', $expresionDireccionCompleta, $this->busquedaGlobal],
        ]);

        return $dataProvider;
    }
}
