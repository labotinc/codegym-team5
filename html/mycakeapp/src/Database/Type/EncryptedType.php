<?php

namespace App\Database\Type;

use Cake\Database\Driver;
use Cake\Database\Type;
use Cake\Utility\Security;
use Cake\Core\Configure;

class EncryptedType extends Type
{
    public function toDatabase($value, Driver $driver)
    { //DBに入れる際に暗号化
        $securityKey = Configure::read('key');
        $securitySalt = Configure::read('salt');
        return Security::encrypt($value, $securityKey, $securitySalt);
    }

    public function toPHP($value, Driver $driver)
    { //DBから取り出す際に復号化
        if ($value === null) {
            return null;
        }
        $securityKey = Configure::read('key');
        $securitySalt = Configure::read('salt');
        return Security::decrypt($value, $securityKey, $securitySalt);
    }
}
