<?php

namespace Modules\Models\Entities;

use Phalcon\Validation,
    Phalcon\Validation\Validator\Uniqueness as UniquenessValidator,
    Phalcon\Validation\Validator\Email as EmailValidator,
    Phalcon\Validation\Validator\StringLength as StringLengthValidator,
    Phalcon\Validation\Validator\PresenceOf as PresenceOfValidator;

class User extends BaseModel
{
    public function initialize() {
        parent::initialize();

        $this->hasMany(
            'id',
            '\Modules\Models\Entities\InterphoneConnectionHistory',
            'userId',
            array(
                'alias' => 'InterphoneConnectionHistory'
            )
        );
    }
    /**
     * Validations and business logic
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email',
            new PresenceOfValidator()
        );
        $validator->add(
            'email',
            new EmailValidator()
        );
        $validator->add(
            'email',
            new UniquenessValidator()
        );
        $validator->add(
            'email',
            new StringLengthValidator([
                 'max' => 255
            ])
        );

        $validator->add(
            'address',
            new PresenceOfValidator()
        );
        $validator->add(
            'address',
            new StringLengthValidator([
                 'max' => 300
            ])
        );

        $validator->add(
            'kakaoId',
            new PresenceOfValidator()
        );
        $validator->add(
            'kakaoId',
            new UniquenessValidator()
        );
        $validator->add(
            'kakaoId',
            new StringLengthValidator([
                 'max' => 100
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
                'kakao_id' => 'kakaoId',
                'address' => 'address',
                'created' => 'created',
                'modified' => 'modified'
            );
    }

    public function getSource()
    {
        return 'user';
    }
}
