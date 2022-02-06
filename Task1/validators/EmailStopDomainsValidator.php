<?php

namespace validators;

use yii\validators\Validator;

class EmailStopDomainsValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if (in_array(strtolower(explode('@', $model->$attribute, 2)[1]), $this->getStopDomains())) {
            $this->addError($model, $attribute, 'This email cannot be used');
        }
    }

    /**
     * @return string[]
     */
    private function getStopDomains(): array
    {
        return [
            // stop domains
        ];
    }
}
