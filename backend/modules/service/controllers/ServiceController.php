<?php

namespace backend\modules\service\controllers;

use backend\modules\service\readModel\ServiceReadRepository;
use Yii;
use yii\rest\Controller;
use backend\modules\service\forms\ServiceForm;
use backend\modules\service\dto\ServiceDto;
use backend\modules\service\services\ServiceService;
use backend\modules\service\repositories\ServiceRepository;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;

class ServiceController extends Controller
{
    private ServiceService $service;
    private ServiceRepository $repository;
    private ServiceReadRepository $readRepository;

    public function __construct(
        $id,
        $module,
        ServiceService $service,
        ServiceRepository $repository,
        ServiceReadRepository $readRepository,
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
            'per-page' => Yii::$app->request->get('per-page', 10),
            'name' => Yii::$app->request->get('name'),
        ]);

        return array_map(fn($c) => new ServiceDto($c), $provider->getModels());
    }

    public function actionView(int $id): ServiceDto
    {
        $service = $this->repository->findById($id);

        if (!$service) {
            throw new NotFoundHttpException('Услуга не найдена');
        }

        return new ServiceDto($service);
    }

    public function actionCreate(): ServiceDto
    {
        $form = new ServiceForm();
        $form->load(Yii::$app->request->post(), '');

        if (!$form->validate()) {
            throw new BadRequestHttpException(json_encode($form->getErrors()));
        }

        $service = $this->service->create($form);
        Yii::$app->response->statusCode = 201;

        return new ServiceDto($service);
    }

    public function actionUpdate($id): ServiceDto
    {
        $form = new ServiceForm();
        $form->load(Yii::$app->request->bodyParams, '');

        if (!$form->validate()) {
            throw new BadRequestHttpException(json_encode($form->getErrors()));
        }

        $service = $this->service->update($id, $form);

        return new ServiceDto($service);
    }

    public function actionDelete($id): array
    {
        $this->service->delete($id);
        Yii::$app->response->statusCode = 204;

        return ['message' => 'Услуга удалена'];
    }
}
