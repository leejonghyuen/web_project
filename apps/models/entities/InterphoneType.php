<?php

namespace Modules\Models\Entities;

use Phalcon\Validation,
    Phalcon\Validation\Validator\Uniqueness as UniquenessValidator,
    Phalcon\Validation\Validator\Email as EmailValidator,
    Phalcon\Validation\Validator\StringLength as StringLengthValidator;

class InterphoneType extends BaseModel
{
    /**
     * Validations and business logic
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'title', // your field name
            new StringLengthValidator([
                 'max' => 20
            ])
        );

        return $this->validate( $validator);
    }

    public function columnMap()
    {
        return
            array(
                'id' => 'id',
                'title' => 'title',
                'created' => 'created',
                'modified' => 'modified'
            );
    }

    public function getSource()
    {
        return 'interphone_type';
    }
}
