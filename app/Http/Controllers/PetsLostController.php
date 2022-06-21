<?php

namespace App\Http\Controllers;

use App\Helpers\UploadFileS3;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Pets;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PetsLostController extends Controller
{
    private $pet_model;

    public function __construct(Pets $pets)
    {
        $this->pet_model = $pets;
    }

    // uploadFileS3
    /**
     * Lista de pets perdidos
     *
     * @return View|Factory
     */
    public function lostIndex()
    {
        $pets = Pets::where('status_id', 1)->orderBy('updated_at', 'DESC')->paginate(5);

        return view('admin.pages.pets.pets_lost.index', compact('pets'));
    }

    /**
     * Formulário de criação de pet
     *
     * @return View|Factory
     */
    public function lostCreate()
    {
        return view('admin.pages.pets.pets_lost.create');
    }

    /**
     * Criação de pet
     *
     * @param Request $request
     * @return Redirector|RedirectResponse
     */
    public function lostStore(Request $request): RedirectResponse
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

        $dados['foto'] = UploadFileS3::upload($request, 2);
        $dados['user_id'] = Auth::user()->id;
        $dados['status_id'] = 1;

        $pet = $this->pet_model::create($dados);

        $pet->avistamentos()->create([
            'ultima_vez_visto' => $dados['ultima_vez_visto'],
            'data_avistamento' => $dados['data_desaparecimento'],
            'esta_com_pet' => 0,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('pets.lost.index')->with('toast_success', 'Cadastrado com sucesso!');
    }

    /**
     * Buscar pet
     *
     * @param Request $request
     * @return View|Factory
     */
    public function lostSearch(Request $request)
    {
        $request->only('filter');

        $pets = $this->pet_model::where('status_id', 1)
            ->where('name', 'LIKE', "%$request->filter%")
            ->orWhere('breed', $request->filter)
            ->latest()
            ->paginate();

        return view('admin.pages.pets.pets_lost.index', compact('pets'));
    }

    /**
     * Atualizar pet para encontrado
     *
     * @param integer $id
     * @return RedirectResponse
     */
    public function foundPet(int $id): RedirectResponse
    {
        $pet = $this->pet_model::FindOrFail($id);

        $pet->update(['status_id' => 2]);

        return redirect()->route('pets.lost.index')->with('toast_success', 'Atualizado com sucesso!');
    }
}
