<?php

namespace App\Http\Controllers;

use App\Enums\Career;
use App\Enums\UserType;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userService->getUsers();
        return redirect()->route('student', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'type' => 'required|string',
            'accountId' => 'required|string|unique:users,accountId',
            'career' => 'required|string',
        ]);

        $data = $request->all();

        // Llamar al servicio para crear el usuario
        $this->userService->createUser($data);
        // Devolver la respuesta
        return redirect()->route('login');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email,' . $user->id,
            'password' => 'required|string',
            'career' => 'required|string',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'career' => $request->career,
        ]);

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }

    public function showRegisterForm()
    {
        $userTypes = UserType::getAllowedOptions();
        $userCareers = Career::getOptions();
        return view('register', compact('userTypes', 'userCareers'));
    }
}
