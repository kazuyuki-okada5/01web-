<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/stamp';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // メール送信
        event(new Registered($user));


    // ここにメール送信のコードを追加する
    // VerifyEmailクラスを使ってメールをインスタンス化し、ユーザーオブジェクトを渡す
    $mail = new VerifyEmail($user);

    // Mailファサードを使ってメールを送信する
    Mail::to($user->email)->send($mail);

        return $user;
    }
}
