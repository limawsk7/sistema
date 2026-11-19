<?php
namespace App\Controllers;

use App\Models\ConteudoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ConteudoController extends BaseController
{
    public function index(): string
    {
        return view('home', ['conteudo' => (new ConteudoModel())->find(1)]);
    }

    public function contato(): string
    {
        return view('contato', ['conteudo' => (new ConteudoModel())->find(4)]);
    }

    public function listar(): string
    {
        return view('conteudo/listar', [
            'conteudos' => (new ConteudoModel())->findAll(),
            'area' => 'conteudos',
        ]);
    }

    public function editar(int $id): string
    {
        $conteudo = (new ConteudoModel())->find($id);
        if ($conteudo === null) {
            throw PageNotFoundException::forPageNotFound('O conteúdo solicitado não foi encontrado.');
        }

        return view('conteudo/editar', ['conteudo' => $conteudo, 'area' => 'conteudos']);
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
            return view('conteudo/editar', [
                'conteudo' => array_merge(['Id' => $id], $dados),
                'area' => 'conteudos',
                'erros' => $this->validator->getErrors(),
            ]);
        }

        $model->update($id, $dados);
        return redirect()->to(site_url('conteudos'))->with('mensagem', 'Conteúdo atualizado com sucesso.');
    }
}