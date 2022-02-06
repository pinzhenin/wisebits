<?php

namespace models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 */
class Users extends ActiveRecord implements IdentityInterface
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'users';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            ['name', 'required', 'message' => 'Name required'],
            ['name', 'trim'],
            ['name', 'string', 'length' => [8, 64], 'message' => 'The name must be between 8 and 64 characters long'],
            ['name', 'match', 'pattern' => '/^[a-z0-9]+$/', 'message' => 'The name must contain only the characters a-z, 0-9'],
            ['email', 'required', 'message' => 'Email required'],
            ['email', 'trim'],
            ['email', 'email', 'message' => 'This email is incorrect'],
            ['email', 'unique', 'message' => 'This email is already in use'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'User id',
            'name' => 'Name',
            'email' => 'Email',
        ];
    }
}
