<?php

namespace Src\Helpers;

class Validate {

    const PASSWORD_LENGTH = 5;

    public static function isString($data)
    {
        return is_string($data);
    }

    public static function isPasswd($passwd, $size = Validate::PASSWORD_LENGTH)
    {
        return self::isPlaintextPassword($passwd, $size);
    }

    public static function isPlaintextPassword($plaintextPasswd, $size = Validate::PASSWORD_LENGTH)
    {
        // The password lenght is limited by `password_hash()`
        return strlen($plaintextPasswd) >= $size && strlen($plaintextPasswd) <= 72;
    }

    public static function isEmail($email): bool
    {
        return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function isBool($bool)
    {
        return $bool === null || is_bool($bool) || preg_match('/^(0|1)$/', $bool);
    }

    public static function isDate($date)
    {
        if (!preg_match('/^([0-9]{4})-((?:0?[0-9])|(?:1[0-2]))-((?:0?[0-9])|(?:[1-2][0-9])|(?:3[01]))( [0-9]{2}:[0-9]{2}:[0-9]{2})?$/', $date, $matches)) {
            return false;
        }

        return checkdate((int) $matches[2], (int) $matches[3], (int) $matches[1]);
    }

}