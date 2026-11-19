<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConteudoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Painel extends BaseController
{
    public function index(): string
    {
        return view('admin/painel');
    }

    public function conteudos(): string
    {
        return view('admin/conteudo/listar', [
            'conteudos' => (new ConteudoModel())->findAll(),
        ]);
    }

    public function editar(int $id): string
    {
        $conteudo = (new ConteudoModel())->find($id);
        if ($conteudo === null) {
            throw PageNotFoundException::forPageNotFound('O conteúdo solicitado não foi encontrado.');
        }

        return view('admin/conteudo/editar', ['conteudo' => $conteudo, 'erros' => []]);
    }

    public function atualizar(int $id)
    {
        $model = new ConteudoModel();
        if ($model->find($id) === null) {
            throw PageNotFoundException::forPageNotFound('O conteúdo solicitado não foi encontrado.');
        }

        $dados = [
            'Titulo' => trim((string) $this->request->getPost('Titulo')),
            'Texto' => trim((string) $this->request->getPost('Texto')),
        ];

        if (!$this->validate([
            'Titulo' => 'required|max_length[255]',
            'Texto' => 'required',
        ])) {
            return view('admin/conteudo/editar', [
                'conteudo' => array_merge(['Id' => $id], $dados),
                'erros' => $this->validator->getErrors(),
            ]);
        }

        $model->update($id, $dados);
        return redirect()->to(site_url('admin/conteudos'))->with('mensagem', 'Conteúdo atualizado com sucesso.');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->to(site_url('login'));
    }
}