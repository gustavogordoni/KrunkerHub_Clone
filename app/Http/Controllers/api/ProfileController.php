<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class ProfileController extends Controller
{
    public function show($nickname)
    {
        if (!is_string($nickname) || strlen($nickname) > 50) {
            abort(404, 'Perfil não encontrado.');
        }

        $user = User::where('name', $nickname)->firstOrFail();

        return new UserResource($user);
    }
}
