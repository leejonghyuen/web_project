<?php

namespace Modules\Models\Entities;

use Phalcon\Validation,
    Phalcon\Validation\Validator\Uniqueness as UniquenessValidator,
    Phalcon\Validation\Validator\Email as EmailValidator,
    Phalcon\Validation\Validator\StringLength as StringLengthValidator;

class User extends BaseModel
{
    /**
     * Validations and business logic
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email', // your field name
            new EmailValidator()
        );

        $validator->add(
            'email', // your field name
            new UniquenessValidator()
        );

        $validator->add(
            'email', // your field name
            new StringLengthValidator([
                 'max' => 255
            ])
        );

        return $this->validate( $validator);
    }

    public function columnMap()
    {
        return
            array(
                'id' => 'id',
                'email' => 'email',
                'password' => 'password',
                'phone' => 'phone',
                'created' => 'created',
                'modified' => 'modified'
            );
    }

    public function getSource()
    {
        return 'user';
    }
}
