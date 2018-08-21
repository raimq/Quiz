<?php

namespace Quiz\Controllers;

use Quiz\Models\UserModel;
use Quiz\Repositories\UserDataBaseRepository;

class AjaxController extends BaseAjaxController
{
    /** @var UserDataBaseRepository */
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserDataBaseRepository();
    }

    public function saveUserAction()
    {
        $name = $_POST['name'];
        /** @var UserModel $user */
        $user = $this->userRepository->create();
        $user->name = $name;
        $atribute = $this->userRepository->save($user);
        $user->name = $atribute["name"];
        $user->id = $atribute["id"];
        return $user;

    }


}