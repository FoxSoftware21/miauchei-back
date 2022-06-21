<?php

namespace App\Http\Controllers;

use App\Helpers\UploadFileS3;
use App\Models\Pets;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PetsController extends Controller
{
    /**
     * Retorna detalhes do pet
     *
     * @param integer $id
     * @return View|Factory
     */
    public function show(int $id)
    {
        $pet = Pets::findOrFail($id);

        return view('admin.pages.pets.show', compact('pet'));
    }

    /**
     * Retorna formulário de edição
     *
     * @param integer $id
     * @return View|Factory
     */
    public function edit(int $id)
    {
        $pet = Pets::join('avistamentos', 'avistamentos.pet_id', '=', 'pets.id')
            ->select('pets.*', 'avistamentos.ultima_vez_visto')->findOrFail($id);

        return view('admin.pages.pets.edit', compact('pet'));
    }

    /**
     * Editar pet
     *
     * @param Request $request
     * @param integer $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $dados = $request->all();

        $validator = Validator::make($dados, [
            'nome' => ['required'],
            'sexo' => ['required'],
            'foto' => ['required', 'mimes:jpg,png,jpeg'],
            'especie' => ['required'],
            'raca' => ['required'],
            'tamanho' => ['required'],
            'cor_predominante' => ['required'],
            'data_desaparecimento' => ['required'],
            'ultima_vez_visto' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all())->withInput();
        }

        $pet = Pets::findOrFail($id);

        $dados['foto'] = UploadFileS3::upload($request, 2);

        $pet->update($dados);

        return redirect()->route('pets.lost.index')->with('toast_success', 'Atualizado com sucesso!');
    }

    /**
     * Deletar pet
     *
     * @param integer $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $pet = Pets::findOrFail($id);

        $pet->delete();

        return redirect()->route('pets.lost.index')->with('toast_success', 'Deletado com sucesso!');
    }
}
