<?php
/**
 * Created by PhpStorm.
 * User: raimo
 * Date: 8/17/2018
 * Time: 9:44 AM
 */

namespace Quiz\Controllers;

use Quiz\Repositories\UserDataBaseRepository;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $repo = new UserDataBaseRepository();
        $repo->getById(2);

        return $this->render('index', compact('user'));
    }


}