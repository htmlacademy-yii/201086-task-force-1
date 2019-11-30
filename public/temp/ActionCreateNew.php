<?php


namespace app\classes;

class ActionCreateNew extends AbstractActions
{
    const NAME = Task::ACTION_CREATE_NEW;
    public static $customer = true;
    public static function name()
    {
        return self::NAME;
    }

    public static function inName()
    {
        $arr = explode("\\", __CLASS__);
        return $arr[count($arr)-1];
    }

    public static function verificationOfRights($userId, $usersId)
    {
        foreach ($usersId as $key=>$user)
        {
            if ($key == $userId)
            {
                if(((self::$customer)and($user=='customer'))or((!self::$customer)and($user!=='customer')))
                {
                    return $userId;
                }
                return false;
            }
        }
    }
}