<?php

namespace Modules\Models\Entities;

use Phalcon\Mvc\Model;
use Phalcon\Validation;

class BaseModel extends Model
{
    public function initialize(){
        // $this->config = $this->getDI()->get('config');
        // if( $this->getReadConnectionService() !== 'db')
        //     $this->setConnectionService('DBresource');

        // $this->addBehavior(
        //     new \Phalcon\Mvc\Model\Behavior\SoftDelete(array(
        //         'field' => 'deleted',
        //         'value' => $this->DELETED
        //     )
        // ));
        $this->setup(
            array(
                'notNullValidations' => false
            )
        );
        
        $this->addBehavior(
            new \Phalcon\Mvc\Model\Behavior\Timestampable(array(
                'beforeCreate' => array(
                    'field' => 'created',
                    'format' => 'Y-m-d H:i:s'
                ),
                'beforeUpdate' => array(
                    'field' => 'modified',
                    'format' => 'Y-m-d H:i:s'
                )
            )
        ));

        return;
    }
}
