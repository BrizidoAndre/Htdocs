<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Animais;

/**
 * AnimaisSearch represents the model behind the search form of `app\models\Animais`.
 */
class AnimaisSearch extends Animais
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'npata', 'carnivoro'], 'integer'],
            [['nome', 'rugido'], 'safe'],
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
        $query = Animais::find();

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
            'npata' => $this->npata,
            'carnivoro' => $this->carnivoro,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'rugido', $this->rugido]);

        return $dataProvider;
    }
}
