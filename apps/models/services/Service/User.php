<?php
namespace Modules\Models\Services\Service;

use Modules\Models\Entities\User as EntityUser;

class User
{
    public function getLast()
    {
    	$users = new EntityUser();
    	return $users->find(
    			array(
    				'order' => 'email DESC, phone',
    				'limit' => 1
    			)
    		);
    }
}
