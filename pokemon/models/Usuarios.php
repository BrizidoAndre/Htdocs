<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nomeusuario
 * @property string $senha
 */
class Usuarios extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomeusuario', 'senha'], 'required'],
            [['nomeusuario', 'senha'], 'string', 'max' => 255],
            [['nomeusuario'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomeusuario' => 'Nomeusuario',
            'senha' => 'Senha',
        ];
    }


    /**
     *{@inheritDoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    /**
     *{@inheritDoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     *{@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *{@inheritDoc}
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     *{@inheritDoc}
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    /**
     *{@inheritDoc}
     */
    public static function findByUsername($username)
    {
        return self::findOne(['nomeusuario' => $username]);
    }

    /**
     *{@inheritDoc}
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->senha);
    }

    /**
     *{@inheritDoc}
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->senha = Yii::$app->security->generatePasswordHash($this->senha);
            return true;
        } else {
            return false;
        }
    }
}
