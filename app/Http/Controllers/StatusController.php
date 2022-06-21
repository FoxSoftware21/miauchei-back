<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatusController extends Controller
{
    /**
     * Lista de status
     *
     * @return View|Factory
     */
    public function index()
    {
        $status = Status::paginate(10);

        return view('admin.pages.status.index', ['status' => $status]);
    }

    /**
     * Retorna formulário de criação
     *
     * @return View|Factory
     */
    public function create()
    {
        return view('admin.pages.status.create');
    }

    /**
     * Retorna detalhes do status
     *
     * @param integer $id
     * @return View|Factory
     */
    public function show(int $id)
    {
        $status = Status::findOrFail($id);

        return view('admin.pages.status.show', compact('status'));
    }

    /**
     * Retorna formulário de edição
     *
     * @param integer $id
     * @return View|Factory
     */
    public function edit(int $id)
    {
        $status = Status::findOrFail($id);

        return view('admin.pages.status.edit', compact('status'));
    }

    /**
     * Criação de status
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $dados = $request->all();

        $validator = Validator::make($dados, [
            'name' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all())->withInput();
        }

        Status::create($dados);

        return redirect()->route('status.index')->with('toast_success', 'Cadastrado com sucesso!');
    }

    /**
     * Edição de status
     *
     * @param Request $request
     * @param integer $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $dados = $request->all();

        $validator = Validator::make($dados, [
            'name' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all())->withInput();
        }

        $status = Status::findOrFail($id);

        $status->update($dados);

        return redirect()->route('status.index')->with('toast_success', 'Atualizado com sucesso!');
    }

    /**
     * Deletar status
     *
     * @param integer $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $status = Status::findOrFail($id);

        $status->delete();

        return redirect()->route('status.index')->with('toast_success', 'Deletado com sucesso!');
    }

    /**
     * Buscar status
     *
     * @param Request $request
     * @return View|Factory
     */
    public function search(Request $request)
    {
        $request->only('filter');

        $status = Status::where('name', 'LIKE', "%$request->filter%")
            ->latest()
            ->paginate();

        return view('admin.pages.status.index', compact('status'));
    }
}
