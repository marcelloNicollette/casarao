<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Mail;
use App\Mail\UserMail;
use App\Models\User;
use Alert;
use App\Mail\ActiveUserMail;

class MailController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $mailData = [
            'title' => 'Usuário Novo',
            'body' => 'Teste de envio de emails do novo usuário.',
            'username' =>"",
            'email' => 'test'
        ];
         
        Mail::to('marcello@waba.com.br')->send(new UserMail($mailData));
           
        dd("Email is sent successfully.");
    }

    public function active_user(Request $request){
        
        $user = User::where('id', $request['token'])->where('email', $request['email'])->first();
        //dd($user);
        $user->status = 'active';
        $user->save();
        
        $mailData = [
            'title' => 'Usuário Ativo',
            'body' => 'Seu cadastro foi ativo com sucesso.',
            'email' => $user->email
        ];
        
        Mail::to($user->email)->send(new ActiveUserMail($mailData));

        //Alert::success('OK', 'Usuário ativo com sucesso');
        //dd('aqui');
        return redirect('/login')->with('message', 'Usuário Ativo com sucesso!');
        
    }
}
