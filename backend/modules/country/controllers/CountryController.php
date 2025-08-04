<?php

namespace backend\modules\country\controllers;

use Yii;
use yii\rest\Controller;
use backend\modules\country\forms\CountryForm;
use backend\modules\country\dto\CountryDto;
use backend\modules\country\services\CountryService;
use backend\modules\country\repositories\CountryRepository;
use yii\data\ActiveDataProvider;
use backend\modules\country\models\Country;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;

class CountryController extends Controller
{
    private CountryService $service;
    private CountryRepository $repository;

    public function __construct($id, $module, CountryService $service, CountryRepository $repository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->repository = $repository;
    }

    public function actionIndex(): array
    {
        $provider = new ActiveDataProvider([
            'query' => Country::find(),
            'pagination' => ['pageSize' => Yii::$app->request->get('per-page', 10)],
        ]);

        return array_map(fn($c) => new CountryDto($c), $provider->getModels());
    }

    public function actionView($id): CountryDto
    {
        $country = $this->repository->findById($id);

        if (!$country) {
            throw new NotFoundHttpException('Страна не найдена');
        }

        return new CountryDto($country);
    }

    public function actionCreate(): CountryDto
    {
        $form = new CountryForm();
        $form->load(Yii::$app->request->post(), '');

        if (!$form->validate()) {
            throw new BadRequestHttpException(json_encode($form->getErrors()));
        }

        $country = $this->service->create($form);
        Yii::$app->response->statusCode = 201;

        return new CountryDto($country);
    }

    public function actionUpdate($id): CountryDto
    {
        $form = new CountryForm();
        $form->load(Yii::$app->request->bodyParams, '');

        if (!$form->validate()) {
            throw new BadRequestHttpException(json_encode($form->getErrors()));
        }

        $country = $this->service->update($id, $form);

        return new CountryDto($country);
    }

    public function actionDelete($id): array
    {
        $this->service->delete($id);
        Yii::$app->response->statusCode = 204;

        return ['message' => 'Страна удалена'];
    }
}
