<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @param ProfileRequest $request
     * @return
     */
    public function update(ProfileRequest $request)
    {
        $user = $request->user();
        return tap($user)->update($request->only('name', 'email'));
    }
}
