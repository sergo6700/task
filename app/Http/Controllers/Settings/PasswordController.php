<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     *
     * @param PasswordRequest $request
     * @return void
     */
    public function update(PasswordRequest $request)
    {
        $request->user()->update([
            'password' => bcrypt($request->password),
        ]);
    }
}
