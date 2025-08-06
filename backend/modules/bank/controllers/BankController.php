<?php

namespace backend\modules\bank\controllers;

use backend\modules\bank\readModel\BankReadRepository;
use Yii;
use yii\rest\Controller;
use backend\modules\bank\forms\BankForm;
use backend\modules\bank\dto\BankDto;
use backend\modules\bank\services\BankService;
use backend\modules\bank\repositories\BankRepository;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;

class BankController extends Controller
{
    private BankService $service;
    private BankRepository $repository;
    private BankReadRepository $readRepository;

    public function __construct(
        $id,
        $module,
        BankService $service,
        BankRepository $repository,
        BankReadRepository $readRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->repository = $repository;
        $this->readRepository = $readRepository;
    }

    public function actionIndex(): array
    {
        $provider = $this->readRepository->getList([
            'country' => Yii::$app->request->get('country'),
            'city' => Yii::$app->request->get('city'),
            'service' => Yii::$app->request->get('service'),
            'name' => Yii::$app->request->get('name'),
            'per-page' => Yii::$app->request->get('per-page', 10),
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
        Yii::$app->response->statusCode = 200;

        return ['message' => 'Банк удален'];
    }
}
