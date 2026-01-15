<?php

namespace app\modules\user\infrastructure\controllers;

use app\modules\user\application\usecases\AuthenticateUser;
use app\modules\user\application\usecases\RequestTokenRecoveryPassword;
use app\modules\user\application\usecases\ResetPassword;
use app\modules\user\domain\contracts\repositories\UserRepository;
use app\modules\user\domain\entities\User;
use app\modules\user\infrastructure\services\JwtService;
use Yii;
use yii\rest\Controller;

class AuthController extends Controller
{
    private UserRepository $userRepository;
    private JwtService $jwtService;
    private RequestTokenRecoveryPassword $recoverPasswordUseCase;
    private ResetPassword $resetPasswordUseCase;

    public function __construct($id, $module, JwtService $jwtService, UserRepository $userRepository, RequestTokenRecoveryPassword $recoverPasswordUseCase, ResetPassword $resetPasswordUseCase, $config = [])
    {
        $this->jwtService = $jwtService;
        $this->userRepository = $userRepository;
        $this->recoverPasswordUseCase = $recoverPasswordUseCase;
        $this->resetPasswordUseCase = $resetPasswordUseCase;
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

            $token = $this->jwtService->generateToken($user);

            return [
                'message' => 'Login successful',
                'token' => $token,
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

    public function actionAuth()
    {
        $authHeader = Yii::$app->request->getHeaders()->get('Authorization');

        if (!$authHeader || !preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            Yii::$app->response->statusCode = 401;
            return ['error' => 'Token não fornecido.'];
        }

        $token = $matches[1];
        $decoded = $this->jwtService->validateToken($token);

        if (!$decoded) {
            Yii::$app->response->statusCode = 401;
            return ['error' => 'Token inválido ou expirado.'];
        }

        $user = $this->userRepository->findById($decoded->uid);

        if (!$user) {
            Yii::$app->response->statusCode = 401;
            return ['error' => 'Usuário não encontrado.'];
        }

        return [
            'status' => 'valid',
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
            ]
        ];
    }

    public function actionRequestPasswordReset()
    {
        $request =  Yii::$app->request->getBodyParams();
        $email = $request['email'];

        if (!$email) {
            Yii::$app->response->statusCode = 400;
            return ['error' => 'The email field is required.'];
        }

        try {
            $this->recoverPasswordUseCase->execute($email);
            return [
                'message' => 'If this email address is in our database, you will receive a recovery link shortly.'
            ];
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 500;
            return ['error' => $e->getMessage()];
        }
    }

    public function actionResetPassword()
    {
        $request = Yii::$app->request->getBodyParams();
        $token = $request['token'] ?? null;
        $password = $request['password'] ?? null;

        if (!$token || !$password) {
            Yii::$app->response->statusCode = 400;
            return ['error' => 'Token and password are required.'];
        }

        try {
            $this->resetPasswordUseCase->execute($token, $password);

            return ['message' => 'Password changed successfully!'];
        } catch (\DomainException $e) {
            Yii::$app->response->statusCode = 500;
            return ['error' => $e->getMessage()];
        }
    }
}