<?php

namespace app\modules\user\controllers;

use app\modules\user\application\usecases\CreateUser;
use app\modules\user\contracts\repositories\UserRepository;
use Yii;
use yii\rest\Controller;

class UserController extends Controller
{

    private UserRepository $userRepository;

    public function __construct($id, $module, UserRepository $userRepository, $config = [])
    {
        $this->userRepository = $userRepository;
        parent::__construct($id, $module, $config);
    }

    public function actionCreate()
    {
        $data = Yii::$app->request->post();
        $useCase = new CreateUser($this->userRepository);

        try {
            $user = $useCase->execute(
                $data['username'],
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $data['plain_password']
            );

            return ['status' => 'success', 'id' => $user->getId()];
        } catch (\DomainException $e) {
            Yii::$app->response->statusCode = 422;
            return ['error' => $e->getMessage()];
        }
    }
}