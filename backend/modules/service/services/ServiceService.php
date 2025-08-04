<?php

namespace backend\modules\service\services;

use backend\modules\service\models\Service;
use backend\modules\service\repositories\ServiceRepository;
use backend\modules\service\forms\ServiceForm;
use DomainException;

class ServiceService
{
    private ServiceRepository $repository;

    public function __construct(ServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(ServiceForm $form): Service
    {
        $exists = $this->repository->findByName($form->name);

        if ($exists) {
            throw new DomainException('Услуга с таким названием уже существует');
        }

        $service = new Service();
        $service->name = $form->name;
        $this->repository->save($service);

        return $service;
    }

    public function update($id, ServiceForm $form): Service
    {
        $service = $this->repository->findById($id);

        if (!$service) {
            throw new DomainException('Услуга не найдена');
        }

        if ($service->name === $form->name) {
            throw new DomainException('Услуга с таким названием уже существует');
        }

        $service->name = $form->name;
        $this->repository->save($service);

        return $service;
    }

    public function delete($id): void
    {
        $service = $this->repository->findById($id);

        if (!$service) {
            throw new DomainException('Услуга не найдена');
        }

        $this->repository->delete($service);
    }
}
