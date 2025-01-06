<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pagos;
use App\Models\Documents;
use App\Models\User;
use App\Models\Roles;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Mail\NewUserMail;


class UsuarioController extends Controller
{
    public function show()
    {
        $data['documentos'] = Documents::where('status', 1)->get();

        if (auth()->user()->hasRole('superadministrador')) {
            $data['roles'] = Roles::get();
        } else if (auth()->user()->hasRole('administrador')){
            $data['roles'] = Roles::whereIn('id', [2,4,5])->get();
        }else{
            //$data['roles'] = Roles::whereIn('id', [1, 2, 3])->get();
            $data['roles']=array();
        }

        return view('superadmin.usuarios', $data);
    }

    public function list()
    {
         $usuarios = User::orderBy('created_at', 'desc');
         if (auth()->user()->hasRole('superadministrador')) {
             $usuarios = $usuarios->get();

         } elseif (auth()->user()->hasRole('administrador')) {
            // El administrador ve todos excepto los superadministradores y clientes
            $usuarios = User::whereDoesntHave('roles', function ($query) {
                $query->whereIn('name', ['superadministrador', 'cliente']);
            })->orderBy('created_at', 'desc')->get();

         } elseif (auth()->user()->hasRole('cliente')) {
            $usuarios = User::whereDoesntHave('roles', function ($query) {
                $query->whereIn('name', ['superadministrador', 'administrador', 'marketing']);
            })->orderBy('created_at', 'desc')->get();
         } else {
            $usuarios = User::whereDoesntHave('roles', function ($query) {
                $query->whereIn('name', ['superadministrador', 'administrador', 'cliente']);
            })->orderBy('created_at', 'desc')->get();
         }

        return ['data' => $usuarios];

    }

    public function edit(Request $request, $id)
    {
        $usuario = User::with('roles')->findOrFail($id);

        return response()->json([
            'usuario' => $usuario,
        ]);
    }

    public function save(Request $request)
    {
        try {

            if ($request->has('id_edit')) {
                $usuario = User::find($request->id_edit);
                if (!$usuario) {
                    return response()->json(
                        [
                            'success' => false,
                            'message' => 'Usuario no encontrado.',
                        ],
                        404,
                    );
                }
                $request->validate([
                    'nombres_edit' => 'nullable|string|max:255',
                    'apellidos_edit' => 'nullable|string|max:255',
                    'email_edit' => [
                        'required',
                        'email',
                        Rule::unique('users', 'email')->ignore($usuario->id, 'id'), // Asegúrate de usar $usuario->id
                    ],
                    'telefono_edit' => 'required|numeric',
                    'direccion_edit' => 'required|string|max:255',
                    'tipo_documento_edit' => 'required|integer',
                    'documento_edit' => 'required|string',
                ]);

                $usuarioData = [
                    'name' => $request->nombres_edit,
                    'last_name' => $request->apellidos_edit,
                    'document_id' => $request->tipo_documento_edit,
                    'document_number' => $request->documento_edit,
                    'telefono' => $request->telefono_edit,
                    'direccion' => $request->direccion_edit,
                    'email' => $request->email_edit,
                ];

                if ($request->has('contrasena')) {
                    $usuarioData['password'] = bcrypt($request->contrasena);
                }

                $usuario->update($usuarioData);

                if ($request->has('rol_edit_usuario')) {

                    $usuario->removeRole($usuario->getRoleNames()->first());

                    switch ($request->rol_edit_usuario) {
                        case 1:
                            $usuario->assignRole('superadministrador');
                            break;
                        case 2:
                            $usuario->assignRole('administrador');
                            break;
                        case 3:
                            $usuario->assignRole('cliente');
                            break;
                        default:
                            $usuario->assignRole('marketing');
                            break;
                    }
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Usuario actualizado correctamente',
                    'data' => $usuario,
                ]);
            } else {
                $request->validate([
                    'nombres' => 'required|string|max:255',
                    'apellidos' => 'required|string|max:255',
                    'email' => 'required|email|max:255|unique:users,email',
                    'telefono' => 'required|numeric',
                    'direccion' => 'required|string|max:255',
                    'tipo_documento' => 'required|integer',
                    'documento' => 'required|string',
                ]);

                $usuarioData = [
                    'name' => $request->nombres,
                    'last_name' => $request->apellidos,
                    'document_id' => $request->tipo_documento,
                    'document_number' => $request->documento,
                    'telefono' => $request->telefono,
                    'direccion' => $request->direccion,
                    'email' => $request->email,
                    'password' => bcrypt($request->contrasena),
                ];

                $randomPass='';
                $randomPass = Str::random(10);
                $usuarioData['password'] = bcrypt($randomPass);

                $usuario = User::create($usuarioData);

                if ($request->has('rol_usuario')) {
                    switch ($request->rol_usuario) {
                        case 1:
                            $usuario->assignRole('superadministrador');
                            break;
                        case 2:
                            $usuario->assignRole('administrador');
                            break;
                        case 3:
                            $usuario->assignRole('cliente');
                            break;
                        default:
                            $usuario->assignRole('marketing');
                            break;
                    }
                }

                Mail::to($request->email)->send(new NewUserMail($usuario->name, $usuario->last_name, $usuario->telefono, $usuario->email, $randomPass));

                return response()->json([
                    'success' => true,
                    'message' => 'Usuario creado correctamente',
                    'data' => $usuario,
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error en la validación, por favor intente de nuevo.',
                    'errors' => $e->errors(),
                ],
                422,
            );
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Este correo ya está registrado. Por favor, utilice uno diferente.',
                    ],
                    409,
                );
            }
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Ocurrió un error al guardar los datos. Intente de nuevo.',
                ],
                500,
            );
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|', // Asegúrate de que la contraseña sea fuerte
        ]);

        $user = auth()->user(); // Obtén el usuario autenticado
        $user->password = bcrypt($request->password); // Encripta la nueva contraseña
        $user->save(); // Guarda los cambios

        return response()->json([
            'success' => true,
            'message' => 'Contraseña cambiada correctamente.',
        ]);
    }

}
