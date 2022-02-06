<?php

namespace models;

use interfaces\LoggerInterface;
use validators\{NameStopWordsValidator, EmailStopDomainsValidator};
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $created
 * @property string|null $deleted
 * @property string|null $notes
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
            ['name', NameStopWordsValidator::class],
            ['name', 'unique', 'message' => 'This name is already in use'],
            ['email', 'required', 'message' => 'Email required'],
            ['email', 'trim'],
            ['email', 'email', 'message' => 'This email is incorrect'],
            ['email', EmailStopDomainsValidator::class],
            ['email', 'unique', 'message' => 'This email is already in use'],
            ['created', 'datetime', 'format' => 'yyyy-MM-dd HH:mm:ss'],
            ['deleted', 'default', 'value' => null],
            ['deleted', 'datetime', 'format' => 'yyyy-MM-dd HH:mm:ss', 'skipOnEmpty' => true],
            ['deleted', 'compare', 'compareAttribute' => 'created', 'operator' => '>=', 'skipOnEmpty' => true],
            ['notes', 'default', 'value' => null],
            ['notes', 'string'],
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
            'created' => 'Created datetime',
            'deleted' => 'Deleted datetime',
            'notes' => 'Notes',
        ];
    }

    /**
     * @return bool
     */
    public function softDelete(): bool
    {
        $this->deleted = date('Y-m-d H:i:s');
        return $this->save(true, ['deleted']);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @return void
     */
    public function afterSave(bool $insert, array $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);

        if (!$insert) {
            Yii::$container->invoke(
                [$this, 'logChanges'],
                [
                    'oldAttributes' => $changedAttributes,
                    'newAttributes' => array_intersect_key((array) $this, $changedAttributes)
                ]
            );
        }
    }

    /**
     * @param array $oldAttributes
     * @param array $newAttributes
     * @param LoggerInterface $logger
     * @return void
     */
    public function logChanges(array $oldAttributes, array $newAttributes, LoggerInterface $logger): void
    {
        $logger->info(
            sprintf('Table %s modified, row id=%d', $this->tableName(), $this->id),
            ['old' => $oldAttributes, 'new' => $newAttributes]
        );
    }
}
