<?php

namespace Modules\Models\Entities;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

class User extends BaseModel
{
    /**
     * Validations and business logic
     */
    // public function validation()
    // {
    //     $validator = new Validation();

    //     $validator->add(
    //         'email', // your field name
    //         new EmailValidator([
    //             'model' => $this,
    //             "message" => 'Please enter a correct email address'
    //         ])
    //     );

    //     return $this->validate($validator);
    // }

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
