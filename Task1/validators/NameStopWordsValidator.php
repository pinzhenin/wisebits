<?php

namespace validators;

use yii\validators\Validator;

class NameStopWordsValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if (in_array($model->$attribute, $this->getStopWords())) {
            $this->addError($model, $attribute, 'This name cannot be used');
        }
    }

    /**
     * @return string[]
     */
    private function getStopWords(): array
    {
        return [
            // stop words
        ];
    }
}
