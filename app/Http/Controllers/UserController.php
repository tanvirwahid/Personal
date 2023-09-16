<?php

namespace App\Http\Controllers;

use App\Enums\UserTypeEnums;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'same:password_confirmation',
            ],
            'password_confirmation' => [
                'required',
                'string',
            ],
            'account_type' => ['required', 'string', 'in:individual,business'],
        ]);

        $accountType = UserTypeEnums::individual();
        if($request->get('account_type') == 'business')
        {
            $accountType = UserTypeEnums::business();
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'remember_token' => Str::random(10),
            'account_type' => $accountType
        ]);

        return response()->json($user);
    }
}
