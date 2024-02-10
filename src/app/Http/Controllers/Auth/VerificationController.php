<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // 追加
use Illuminate\Auth\Events\Verified; // 追加

class VerificationController extends Controller
{
    public function show()
    {
        $user = auth()->user(); // ログインしているユーザーの情報を取得
    return view('emails.verify', ['user' => $user]); // メール認証のビューに$user変数を渡す

    }

    public function verify(Request $request, $id)
    {
        $user = User::find($id); // Userモデルを使用

        if (!$user) {
            return redirect('/'); // ユーザーが存在しない場合はホームにリダイレクト
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/'); // すでに認証済みの場合はホームにリダイレクト
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user)); // メールアドレスを確認し、Verifiedイベントをトリガー
        }

        return redirect('/'); // 認証後はホームにリダイレクト
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/'); // すでに認証済みの場合はホームにリダイレクト
        }

        $request->user()->sendEmailVerificationNotification(); // メールを再送信

        return back()->with('resent', true); // メールが再送信されたことをフラッシュメッセージでユーザーに通知
    }
}