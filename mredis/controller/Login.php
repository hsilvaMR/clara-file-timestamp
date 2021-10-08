<?php

namespace App\Http\Controllers\Timestamp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;


use Hash;
use Validator;
use Mail;
use Cookie;

class Login extends Controller
{
	private $dados = [];

	public function index()
	{

		$this->dados['headTitulo'] = 'Login-selos';
		$this->dados['headDescricao'] = 'Login-selos';
		$this->dados['headPagina'] = 'Login';
		$this->dados['faceTipo'] = 'website';


		return view('pages/timestamp/login', $this->dados);
	}



	public function formLogin(Request $request)
	{

		/*
		dados login 
		user:hsilva@mredis.com
		pass:Hkn15d77
		*/

		$email = trim($request->email);
		$password = trim($request->password);


		if (empty($email)) {
			return 'Campo endereço de email vazio.';
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return 'O campo endereço de email inválido. Introduza um endereço de email válido.';
		}
		if (empty($password)) {
			return 'Campo palavra-passe vazio.';
		}

		$client = \DB::table('time_clients')->where('email', $email)->first();

		if (isset($client->id) &&  $client->id != '') {

			if (!Hash::check($password, $client->password)) {
				return 'Dados incorretos. Email ou password incorretos.';
			}
			\DB::table('time_clients')->where('id', $client->id)->update(['ultimo_acesso' => strtotime(date('Y-m-d H:i:s'))]);

			//Criar sessão (cliente) salvar a id_cliente na cookie
			Cookie::queue(Cookie::make('time_user_cookie', $client->id, 43200));

			$resposta = [
				'estado' => 'sucesso',
				'mensagem' => 'Sessão iniciada com sucesso!'
			];
		} else {
			return 'Utilizador inexistente. Registe-se!';
		}

		return json_encode($resposta, true);
	}


	public function formRegister(Request $request)
	{

		$email = trim($request->email);
		$password = trim($request->password);

		if (empty($email)) {
			return 'Campo endereço de email vazio.';
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return 'O campo endereço de email inválido. Introduza um endereço de email válido.';
		}
		if (empty($password)) {
			return 'Campo palavra-passe vazio.';
		}
		if (strlen($password) < 8) {
			return 'Campo palavra-passe é composto no mínimo por 8 caracteres.';
		}



		$client = \DB::table('time_clients')->where('email', $email)->first();



		if (isset($client->id)) {
			return 'Este utilizador já existe. Inicie sessão!';
		} else {

			$token = str_random(12);
			\DB::table('time_clients')->insert([
				'email' => $email,
				'password' => bcrypt($password),
				'token' => $token,
				'data' => strtotime(date('Y-m-d H:i:s')),
				'ultimo_acesso' => strtotime(date('Y-m-d H:i:s')),
				'estado' => 'pendente'
			]);

			//Enviar email para validar a conta:
			$data = ['token' => $token];
			\Mail::send('emails/timestamp/validar_conta', $data, function ($message) use ($request) {
				$message->to($request->email, '')->subject('Ativar conta');
				$message->from(config('mailAccounts.geral')['email'], config('mailAccounts.geral')['nome']);
			});

			$resposta = [
				'estado' => 'sucesso',
				'mensagem' => 'Registado com sucesso!'
			];
		}

		return json_encode($resposta, true);
	}

	public function ativarConta($token)
	{

		$this->dados['headTitulo'] = 'Ativar Conta-selos';
		$this->dados['headDescricao'] = 'Ativar Conta-selos';
		$this->dados['headPagina'] = 'Ativar Conta';
		$this->dados['faceTipo'] = 'website';

		$this->dados['token'] = $token;

		return view('pages/timestamp/ativarConta', $this->dados);
	}

	public function formAtivarConta(Request $request)
	{
		$token = trim($request->token);

		\DB::table('time_clients')
			->where('token', $token)
			->update([
				'estado' => 'ativo'
			]);

		$resposta = [
			'estado' => 'sucesso',
			'mensagem' => 'Conta ativada com sucesso!'
		];

		return json_encode($resposta, true);
	}

	public function logout()
	{
		Cookie::queue(Cookie::forget('time_user_cookie'));
		return redirect()->route('loginTimePage');
	}
}
