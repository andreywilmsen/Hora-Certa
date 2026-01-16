<?php

namespace app\modules\user\infrastructure\controllers;

use app\modules\user\application\dtos\UserResponseDTO;
use app\modules\user\application\usecases\CreateUser;
use app\modules\user\application\usecases\DeleteUser;
use app\modules\user\application\usecases\GetAllUsers;
use app\modules\user\application\usecases\GetUser;
use app\modules\user\application\usecases\UpdateProfilePhoto;
use app\modules\user\application\usecases\UpdateUser;
use app\modules\user\domain\contracts\repositories\UserRepository;
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
        $tenantId = isset($data['tenant_id']) ? (int)$data['tenant_id'] : 1;
        try {
            $user = $useCase->execute(
                $tenantId,
                $data['username'],
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $data['phone'] ?? null,
                $data['profile_photo'] ?? null,
                $data['plain_password']
            );

            return ['status' => 'success', 'id' => $user->getId()];
        } catch (\DomainException $e) {
            Yii::$app->response->statusCode = 422;
            return ['error' => $e->getMessage()];
        }
    }

    public function actionDelete($id)
    {
        $data =  Yii::$app->request->post();
        $useCase = new DeleteUser($this->userRepository);

        try {
            $useCase->execute((int)$id);
            return ['status' => 'success', 'message' => 'User deleted successfully.'];
        } catch (\DomainException $e) {
            Yii::$app->response->statusCode = 404;
            return ['error' => $e->getMessage()];
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 500;
            return ['error' => 'Internal server error.'];
        }
    }

    public function actionUpdate($id)
    {
        $data = Yii::$app->request->getBodyParams();
        $useCase = new UpdateUser($this->userRepository);

        try {
            $useCase->execute(
                (int) $id,
                $data['username'],
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $data['phone'] ?? null
            );

            return ['status' => 'success', 'message' => 'User updated successfully.'];
        } catch (\DomainException $e) {
            Yii::$app->response->statusCode = 422;
            return ['error' => $e->getMessage()];
        }
    }

    public function actionGet($id)
    {
        $useCase = new GetUser($this->userRepository);

        try {
            $user = $useCase->execute((int)$id);

            return ['status' => 'success', 'user' => UserResponseDTO::fromEntity($user)];
        } catch (\DomainException $e) {
            Yii::$app->response->statusCode = 404;
            return ['error' => $e->getMessage()];
        }
    }

    public function actionGetAll()
    {
        $useCase = new GetAllUsers($this->userRepository);

        try {
            $users = $useCase->execute();

            return ['status' => 'success', 'users' => UserResponseDTO::fromEntityList($users)];
        } catch (\DomainException $e) {
            Yii::$app->response->statusCode = 404;
            return ['error' => $e->getMessage()];
        }
    }

    public function actionUploadPhoto($id)
    {
        $useCase = new UpdateProfilePhoto($this->userRepository);
        $file = \yii\web\UploadedFile::getInstanceByName('profile_photo');

        if ($file) {
            $fileName = 'profile_' . $id . '-' . time() . '.' . $file->extension;

            $uploadDir = \Yii::getAlias('@webroot/uploads/profiles/');
            $absolutePath = $uploadDir . $fileName;

            $dbPath = '/uploads/profiles/' . $fileName;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if ($file->saveAs($absolutePath)) {
                $user = $useCase->execute((int)$id, $dbPath);
                return UserResponseDTO::fromEntity($user);
            }
        }
        throw new \yii\web\BadRequestHttpException("Failed to load image.");
    }
}
