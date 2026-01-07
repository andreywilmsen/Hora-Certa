<?php

namespace app\modules\user\infrastructure\controllers;

use app\modules\user\application\usecases\AuthenticateUser;
use app\modules\user\domain\contracts\repositories\UserRepository;
use app\modules\user\domain\entities\User;
use Yii;
use yii\rest\Controller;

class AuthController extends Controller
{
    private UserRepository $userRepository;

    public function __construct($id, $module, UserRepository $userRepository, $config = [])
    {
        $this->userRepository = $userRepository;
        parent::__construct($id, $module, $config);
    }

    public function actionLogin()
    {
        /** @var User $user */
        
        $request = Yii::$app->request->getBodyParams();

        if (!$request['email'] || !$request['password']) {
            Yii::$app->response->statusCode = 400;
            return ['error' => 'Email and Password are required.'];
        }

        $useCase = new AuthenticateUser($this->userRepository);

        try {

            $user = $useCase->execute($request['email'], $request['password']);

            return [
                'message' => 'Login successful',
                'auth' => [
                    'user_id' => $user->getId(),
                ],
                'user_data' => $user->toArray()
            ];
        } catch (\DomainException $e) {
            Yii::$app->response->statusCode = 401;
            return ['error' => $e->getMessage()];
        }
    }
}
