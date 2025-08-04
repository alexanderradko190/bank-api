<?php

namespace backend\modules\city\controllers;

use Yii;
use yii\rest\Controller;
use backend\modules\city\forms\CityForm;
use backend\modules\city\dto\CityDto;
use backend\modules\city\services\CityService;
use backend\modules\city\repositories\CityRepository;
use yii\data\ActiveDataProvider;
use backend\modules\city\models\City;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;

class CityController extends Controller
{
    private CityService $service;
    private CityRepository $repository;

    public function __construct($id, $module, CityService $service, CityRepository $repository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->repository = $repository;
    }

    public function actionIndex(): array
    {
        $provider = new ActiveDataProvider([
            'query' => City::find(),
            'pagination' => ['pageSize' => Yii::$app->request->get('per-page', 10)],
        ]);

        return array_map(fn($c) => new CityDto($c), $provider->getModels());
    }

    public function actionView($id): CityDto
    {
        $city = $this->repository->findById($id);
        if (!$city) {
            throw new NotFoundHttpException('Город не найден');
        }

        return new CityDto($city);
    }

    public function actionCreate(): CityDto
    {
        $form = new CityForm();
        $form->load(Yii::$app->request->bodyParams, '');

        if (!$form->validate()) {
            throw new BadRequestHttpException(json_encode($form->getErrors()));
        }

        $city = $this->service->create($form);
        Yii::$app->response->statusCode = 201;

        return new CityDto($city);
    }

    public function actionUpdate($id): CityDto
    {
        $form = new CityForm();
        $form->load(Yii::$app->request->bodyParams, '');

        if (!$form->validate()) {
            throw new BadRequestHttpException(json_encode($form->getErrors()));
        }

        $city = $this->service->update($id, $form);

        return new CityDto($city);
    }

    public function actionDelete($id)
    {
        $this->service->delete($id);
        Yii::$app->response->statusCode = 204;

        return ['message' => 'Город удален'];
    }
}
