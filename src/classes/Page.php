<?php

class Page extends Model{

    public function getTable(): string
    {
        return 'page';
    }

    public function getUser($user_id)
    {

        // $db = self::connect();

        // $stmt = $db->prepare('SELECT id, email,type, token FROM ' . self::$table . ' WHERE id = "' . $user_id . '" LIMIT 1');

        // $stmt->execute();

        // $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // if (isset($user)) {

        //     return $user;
        // } else {

        //     return false;
        // }
    }

}