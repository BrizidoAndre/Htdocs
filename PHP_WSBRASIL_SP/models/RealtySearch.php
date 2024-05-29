<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Realty;

/**
 * RealtySearch represents the model behind the search form of `app\models\Realty`.
 */
class RealtySearch extends Realty
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['realtyid', 'num_rooms', 'rooms_qt', 'toilet_qt', 'parkingspace_qt', 'neighborhoodId', 'categoryid'], 'integer'],
            [['address', 'comment'], 'safe'],
            [['offer_type'], 'boolean'],
            [['value'], 'number'],
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
        $query = Realty::find();

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
            'realtyid' => $this->realtyid,
            'num_rooms' => $this->num_rooms,
            'offer_type' => $this->offer_type,
            'rooms_qt' => $this->rooms_qt,
            'toilet_qt' => $this->toilet_qt,
            'parkingspace_qt' => $this->parkingspace_qt,
            'value' => $this->value,
            'neighborhoodId' => $this->neighborhoodId,
            'categoryid' => $this->categoryid,
        ]);

        $query->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
