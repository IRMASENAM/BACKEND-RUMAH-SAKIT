<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Pasien extends ResourceController
{
    protected $modelName = 'App\\Models\\PasienModel';
    protected $format    = 'json';

    // GET /pasien
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // POST /pasien
    public function create()
    {
        $data = $this->request->getJSON(true);
        if (!$data) {
            return $this->fail('Body JSON kosong atau salah format', 400);
        }

        $this->model->insert($data);
        return $this->respondCreated($data);
    }

    // PUT /pasien/{id}
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if (!$data) {
            return $this->fail('Body JSON kosong atau salah format', 400);
        }

        $pasien = $this->model->find($id);
        if (!$pasien) {
            return $this->failNotFound("Pasien dengan ID $id tidak ditemukan.");
        }

        $this->model->update($id, $data);
        return $this->respond(['message' => 'Data pasien berhasil diupdate', 'data' => $data]);
    }

    // DELETE /pasien/{id}
    public function delete($id = null)
    {
        $pasien = $this->model->find($id);
        if (!$pasien) {
            return $this->failNotFound("Pasien dengan ID $id tidak ditemukan.");
        }

        $this->model->delete($id);
        return $this->respondDeleted(['message' => "Pasien dengan ID $id berhasil dihapus."]);
    }
}