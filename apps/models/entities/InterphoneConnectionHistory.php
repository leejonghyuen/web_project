<?php

namespace Modules\Models\Entities;

use Phalcon\Validation,
    Phalcon\Validation\Validator\PresenceOf as PresenceOfValidator;

class InterphoneConnectionHistory extends BaseModel
{
    public function initialize() {
        parent::initialize();
    }

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'userId',
            new PresenceOfValidator()
        );

        $validator->add(
            'visitorIp',
            new PresenceOfValidator()
        );

        return $this->validate( $validator);
    }

    public function columnMap()
    {
        return
            array(
                'id' => 'id',
                'user_id' => 'userId',
                'visitor_ip' => 'visitorIp',
                'created' => 'created'
            );
    }

    public function getSource()
    {
        return 'interphone_connection_history';
    }
}
