<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required'],
            'password' => ['required', 'confirmed'],
        ]);

        if ($request['current_password'] == Auth::user()['password']){
            $request->user()->update([
                'password' => $validated['password'],
            ]);
            return back()->with('status', 'password-updated');
        }
        return back()->with('error', 'password-notupdated');
    }

    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Введите номер телефона'], 400);
        }

            $user = User::query()->select('city')->where('login', $request->input('login'))
                ->first();
            if(!$user){
                return response()->json(['message' => 'Такой пользователь не найден, проверьте введённый номер телефона']);
            }
            $moderator = User::query()->select('whatsapp')->where('type', 'moderator')->where('city', $user->city)->first();

            if (!$moderator){
                $restoreNumber = (Configuration::query()->select('whats_app')->first())->whats_app;
            }else{
                $restoreNumber = $moderator->whatsapp;
            }

            $externalUrl = "https://api.whatsapp.com/send?phone={{$restoreNumber}}&text=Здравствуйте! Напомните, пожалуйста, мой пароль";


        return response()->json(['redirect_url' => $externalUrl]);
    }
}
