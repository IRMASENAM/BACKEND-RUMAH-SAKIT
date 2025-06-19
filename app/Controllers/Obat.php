<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Obat extends ResourceController
{
    protected $modelName = 'App\\Models\\ObatModel';
    protected $format    = 'json';

    // GET /obat
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // POST /obat
    public function create()
    {
        $data = $this->request->getJSON(true);
        if (!$data) {
            return $this->fail('Body JSON kosong atau salah format', 400);
        }

        $this->model->insert($data);
        return $this->respondCreated($data);
    }

    // PUT /obat/{id}
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if (!$data) {
            return $this->fail('Body JSON kosong atau salah format', 400);
        }

        $obat = $this->model->find($id);
        if (!$obat) {
            return $this->failNotFound("Obat dengan ID $id tidak ditemukan.");
        }

        $this->model->update($id, $data);
        return $this->respond(['message' => 'Data obat berhasil diupdate', 'data' => $data]);
    }

    // DELETE /obat/{id}
    public function delete($id = null)
    {
        $obat = $this->model->find($id);
        if (!$obat) {
            return $this->failNotFound("Obat dengan ID $id tidak ditemukan.");
        }

        $this->model->delete($id);
        return $this->respondDeleted(['message' => "Obat dengan ID $id berhasil dihapus."]);
    }
}