<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Pets;

class PetsFoundController extends Controller
{
    /**
     * Lista de pets encontrados
     *
     * @return View|Factory
     */
    public function foundIndex()
    {
        $pets = Pets::where('status_id', 2)->orderBy('data_desaparecimento', 'DESC')->paginate(3);

        return view('admin.pages.pets.pets_found.index', compact('pets'));
    }

    /**
     * Buscar pet
     *
     * @param Request $request
     * @return View|Factory
     */
    public function foundSearch(Request $request)
    {
        $request->only('filter');

        $pets = Pets::where('status_id', 2)
            ->where('nome', 'LIKE', "%$request->filter%")
            ->orWhere('raca', 'LIKE', "%$request->filter%")
            ->latest()
            ->paginate();

        return view('admin.pages.pets.pets_found.index', compact('pets'));
    }

    /**
     * Atualizar pet para perdido
     *
     * @param integer $id
     * @return RedirectResponse
     */
    public function lostPet(int $id): RedirectResponse
    {
        $pet = Pets::FindOrFail($id);

        $pet->update(['status_id' => 1]);

        return redirect()->route('pets.found.index')->with('toast_success', 'Atualizado com sucesso!');
    }
}
