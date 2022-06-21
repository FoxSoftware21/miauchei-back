<?php

namespace App\Http\Controllers;

use App\Helpers\UploadFileS3;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Retorna lista de usuários
     *
     * @return View|Factory
     */
    public function index()
    {
        $users = User::paginate(3);

        return view('admin.pages.users.index', ['users' => $users]);
    }

    /**
     * Retorna formulário de criação
     *
     * @return View|Factory
     */
    public function create()
    {
        return view('admin.pages.users.create');
    }

    /**
     * Retorna detalhes sobre o usuário
     *
     * @param integer $id
     * @return View|Factory
     */
    public function show(int $id)
    {
        $user = User::findOrFail($id);

        return view('admin.pages.users.show', compact('user'));
    }

    /**
     * Retorna formulário de edição
     *
     * @param integer $id
     * @return View|Factory
     */
    public function edit(int $id)
    {
        $user = User::findOrFail($id);

        return view('admin.pages.users.edit', compact('user'));
    }

    /**
     * Criar usuário
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $dados = $request->all();

        $validator  = Validator::make($dados, [
            'name' => ['required'],
            'phone' => ['required', 'unique:users'],
            'photo' => ['required', 'mimes:jpg,png,jpeg'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'max:8'],
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all())->withInput();
        }

        $dados['password'] = bcrypt($request->password);

        $dados['photo'] = UploadFileS3::upload($request, 1);

        User::create($dados);

        return redirect()->route('users.index')->with('toast_success', 'Cadastrado com sucesso!');
    }

    /**
     * Editar usuário
     *
     * @param Request $request
     * @param integer $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $dados = $request->all();

        $user = User::findOrFail($id);

        $dados['password'] = bcrypt($request->password);

        $dados['photo'] = UploadFileS3::upload($request, 1);

        $user->update($dados);

        return redirect()->route('users.index')->with('toast_success', 'Atualizado com sucesso!');
    }

    /**
     * Deletar usuário
     *
     * @param integer $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('users.index')->with('toast_success', 'Deletado com sucesso!');
    }

    /**
     * Buscar usuários
     *
     * @param Request $request
     * @return View|Factory
     */
    public function search(Request $request)
    {
        $request->only('filter');

        $users = User::where('name', 'LIKE', "%$request->filter%")
            ->orWhere('email', $request->filter)
            ->latest()
            ->paginate();

        return view('admin.pages.users.index', compact('users'));
    }
}
