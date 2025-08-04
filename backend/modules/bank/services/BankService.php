<?php

namespace backend\modules\bank\services;

use Exception;
use RuntimeException;
use Yii;
use backend\modules\bank\models\Bank;
use backend\modules\bank\repositories\BankRepository;
use backend\modules\bank\forms\BankForm;

class BankService
{
    private BankRepository $repository;

    public function __construct(BankRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(BankForm $form): Bank
    {
        $exists = $this->repository->findByName($form->name);

        if ($exists) {
            throw new Exception('Банк с таким названием уже существует');
        }

        $bank = new Bank();
        $bank->name = $form->name;
        $bank->description = $form->description;
        $bank->country_id = $form->country_id;

        if (!$form->validate()) {
            throw new \DomainException(json_encode($form->getErrors()));

        }

        $cityIds = $form->city_ids ?: [];
        $serviceIds = $form->service_ids ?: [];

        Yii::$app->db->transaction(function () use ($bank, $cityIds, $serviceIds) {
            $this->repository->save($bank);
            $this->repository->updateCities($bank->id, $cityIds);
            $this->repository->updateServices($bank->id, $serviceIds);
        });

        return $bank;
    }

    public function update($id, BankForm $form): Bank
    {

        $bank = $this->repository->findByNotDeletedById($id);

        if (!$bank) {
            throw new Exception('Банк не найден');
        }

        if ($bank->name === $form->name) {
            throw new Exception('Банк с таким названием уже существует');
        }

        $bank->name = $form->name;
        $bank->description = $form->description;
        $bank->country_id = $form->country_id;

        if (!$form->validate()) {
            throw new Exception(json_encode($form->getErrors()));
        }

        $cityIds = $form->city_ids ?: [];
        $serviceIds = $form->service_ids ?: [];

        Yii::$app->db->transaction(function () use ($bank, $cityIds, $serviceIds) {
            $this->repository->save($bank);
            $this->repository->updateCities($bank->id, $cityIds);
            $this->repository->updateServices($bank->id, $serviceIds);
        });

        return $bank;
    }

    public function delete($id)
    {
        $bank = $this->repository->findByNotDeleted($id);

        if (!$bank) {
            throw new Exception('Банк не найден');

        }

        $bank->is_deleted = 1;

        if (!$bank->save(false)) {
            throw new RuntimeException('Ошибка удаления');
        }
    }
}
