<?php

namespace frontend\models;

use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form of `common\models\User`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          [['id', 'location_id', 'show_contacts_for_customer', 'hide_profile', 'count_orders', 'popularity', 'now_free', 'has_reviews', 'is_executor', 'count_reviews', 'rating', 'status', 'created_at', 'updated_at'], 'integer'],
          [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'birthday', 'info', 'phone', 'skype', 'another_messenger', 'last_visit_time', 'verification_token'], 'safe'],
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
        $query = User::find();

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
          'location_id' => $this->location_id,
          'birthday' => $this->birthday,
          'show_contacts_for_customer' => $this->show_contacts_for_customer,
          'hide_profile' => $this->hide_profile,
          'last_visit_time' => $this->last_visit_time,
          'count_orders' => $this->count_orders,
          'popularity' => $this->popularity,
          'now_free' => $this->now_free,
          'has_reviews' => $this->has_reviews,
          'is_executor' => $this->is_executor,
          'count_reviews' => $this->count_reviews,
          'rating' => $this->rating,
          'status' => $this->status,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
          ->andFilterWhere(['like', 'auth_key', $this->auth_key])
          ->andFilterWhere(['like', 'password_hash', $this->password_hash])
          ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
          ->andFilterWhere(['like', 'email', $this->email])
          ->andFilterWhere(['like', 'info', $this->info])
          ->andFilterWhere(['like', 'phone', $this->phone])
          ->andFilterWhere(['like', 'skype', $this->skype])
          ->andFilterWhere(['like', 'another_messenger', $this->another_messenger])
          ->andFilterWhere(['like', 'verification_token', $this->verification_token]);

        return $dataProvider;
    }
}
