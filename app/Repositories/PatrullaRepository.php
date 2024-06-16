<?php

namespace App\Repositories;

use App\Models\Patrulla;

class PatrullaRepository
{
    protected Patrulla $model;

    public function __construct(Patrulla $patrulla)
    {
        $this->model = $patrulla;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function insertarPatrulla(array $patrulla): void
    {
        $this->model->create([
            'matricula' => $patrulla["matricula"],
            'vehiculo' => $patrulla["vehiculo"],
        ]);
    }

    public function create()
    {
        // Lógica de creación si es necesario.
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function show($matricula)
    {
        return $this->model->findOrFail($matricula);
    }

    public function edit($matricula)
    {
        return $this->model->findOrFail($matricula);
    }

    public function update($matricula, array $data)
    {
        $patrulla = $this->model->findOrFail($matricula);
        $patrulla->update($data);

        return $patrulla;
    }

    public function destroy($matricula)
    {
        $patrulla = $this->model->findOrFail($matricula);
        $patrulla->delete();

        return $patrulla;
    }
}