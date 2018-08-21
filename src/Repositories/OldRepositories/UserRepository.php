<?php
/**
 * Created by PhpStorm.
 * User: raimo
 * Date: 8/14/2018
 * Time: 11:11 AM
 */

namespace Quiz\Repositories;

use Quiz\Models\UserModel;

class UserRepository
{
    /** @var UserModel[] */
    private $users = [];

    private $idCounter = 0;

    /** @var UserModel[] */
    private $id = [];
    /** @var UserModel[] */
    private $name = [];


    public function saveOrCreate(UserModel $user): UserModel
    {
        $existingUser = $user;

        if (!$user->id) {
            $this->idCounter += 1;
            $user->id = $this->idCounter;
        }

        $existingUser->name = $user->name;
        $existingUser->id = $user->id;
        $this->users[$existingUser->id] = $existingUser;
        return $existingUser;
    }


    public function getById(int $userId): UserModel
    {
        if (isset($this->users[$userId])) {
            return $this->users[$userId];
        }
        return new UserModel;
    }

    /**
     * @return UserModel[]
     */
    public function getAll(): array
    {
        return $this->users;
    }


}