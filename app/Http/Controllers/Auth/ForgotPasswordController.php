<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Exibe o formulário para solicitar a redefinição de senha.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Envia um link de redefinição de senha para o usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validação do email
        $this->validateEmail($request);

        // Envia o link de redefinição de senha
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        // Redireciona com mensagem de status
        return $response == Password::RESET_LINK_SENT
            ? Redirect::back()->with('status', __($response))
            : Redirect::back()->withErrors(
                ['email' => __($response)]
            );
    }

    /**
     * Valida o email da solicitação de redefinição de senha.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
    }
}
