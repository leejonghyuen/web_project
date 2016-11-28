<?php

namespace Modules\Models\Entities;

use Phalcon\Validation,
    Phalcon\Validation\Validator\Uniqueness as UniquenessValidator,
    Phalcon\Validation\Validator\Email as EmailValidator,
    Phalcon\Validation\Validator\StringLength as StringLengthValidator;

class Interphone extends BaseModel
{
    public function initialize() {
        parent::initialize();

        $this->hasOne('id', 'Modules\Models\Entities\InterphoneType', 'typeId', array('alias' => 'type'));
    }

    /**
     * Validations and business logic
     */
    public function validation()
    {
        $validator = new Validation();

        return $this->validate( $validator);
    }

    public function columnMap()
    {
        return
            array(
                'id' => 'id',
                'user_id' => 'userId',
                'type_id' => 'typeId',
                'address' => 'address',
                'ip' => 'ip',
                'created' => 'created',
                'modified' => 'modified'
            );
    }

    public function getSource()
    {
        return 'interphone';
    }
}
