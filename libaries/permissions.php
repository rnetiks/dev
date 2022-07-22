<?php

use Permission as GlobalPermission;

class Permission
{
    /**
     * Get's the value of a permission on a logged in user.
     * @return string|bool Returns the value of the permission, false on failure
     */
    static function Get($permission)
    {
        $key = $_SESSION['permissions'];
        if (session_status() === PHP_SESSION_ACTIVE && isset($key[$permission])) {
            return $key[$permission];
        }
        return false;
    }

    /**
     * This is for API calls only
     * @return bool false if no session is active
     */
    static function Set($permission, $value)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION['permissions'][$permission] = $value;
            return true;
        }
        return false;
    }

    /**
     * Requires Moderator or higher to call
     */
    static function GetGroupByName($group)
    {
        if (!self::Get("moderation")) {
            return false;
        }
        
        $client = new mysqli();
        if ($stm = $client->prepare("SELECT permission FROM groups WHERE `name` = ?")) {
            if ($stm->bind_param("s", $group)) {
                $stm->execute();
                $result = $stm->get_result();
                if ($result->num_rows > 0) {
                    $PermissionSet = array();
                    while ($row = $result->fetch_assoc()) {
                        $PermissionSet[$row['permission']] = true;
                    }
                    return $PermissionSet;
                }
            }
        }
        return null;
    }
}
