<?php

namespace backend\modules\bank\controllers;

use Yii;
use yii\rest\Controller;
use backend\modules\bank\forms\BankForm;
use backend\modules\bank\dto\BankDto;
use backend\modules\bank\services\BankService;
use backend\modules\bank\repositories\BankRepository;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;

class BankController extends Controller
{
    private BankService $service;
    private BankRepository $repository;

    public function __construct($id, $module, BankService $service, BankRepository $repository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->repository = $repository;
    }

    public function actionIndex(): array
    {
        $query = $this->repository->findAllNotDeleted();
        $country = Yii::$app->request->get('country');
        $city = Yii::$app->request->get('city');
        $service = Yii::$app->request->get('service');

        if ($country) {
            $query->joinWith('country')->andWhere(['country.name' => $country]);

        }

        if ($city) {
            $query->joinWith('cities')->andWhere(['city.name' => $city]);
        }

        if ($service) {
            $query->joinWith('services')->andWhere(['service.name' => $service]);

        }

        $provider = new ActiveDataProvider([
            'query' => $query->distinct(),
            'pagination' => ['pageSize' => Yii::$app->request->get('per-page', 10)],
        ]);

        return BankDto::many($provider->getModels());
    }

    public function actionView($id): ?BankDto
    {
        $bank = $this->repository->findByNotDeleted($id);

        if (!$bank) {
            throw new NotFoundHttpException("Банк не найден");
        }

        return new BankDto($bank);
    }

    public function actionCreate(): ?BankDto
    {
        $form = new BankForm();
        $form->load(Yii::$app->request->post(), '');

        if (!$form->validate()) {
            throw new BadRequestHttpException(json_encode($form->getErrors()));
        }

        $bank = $this->service->create($form);
        Yii::$app->response->statusCode = 201;

        return new BankDto($bank);
    }

    public function actionUpdate($id): ?BankDto
    {
        $form = new BankForm();
        $form->load(Yii::$app->request->bodyParams, '');

        if (!$form->validate()) {
            throw new BadRequestHttpException(json_encode($form->getErrors()));
        }

        $bank = $this->service->update($id, $form);

        return new BankDto($bank);
    }

    public function actionDelete($id): array
    {

        $this->service->delete($id);
        Yii::$app->response->statusCode = 204;

        return ['message' => 'Банк удален'];
    }
}
