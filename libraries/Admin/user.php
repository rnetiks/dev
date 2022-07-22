<?php
final class User{
    var $Id, $Name, $Email;
    public static function Get($id){
        $user = new User();
        $user->Id = $id;
        return $user;
    }
}