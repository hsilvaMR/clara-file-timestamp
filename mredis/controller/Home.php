<?php

namespace App\Http\Controllers\Timestamp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;


use Hash;
use Validator;
use Mail;
use Cookie;

class Home extends Controller
{
	private $dados = [];

	public function index()
	{

		$this->dados['headTitulo'] = 'selos';
		$this->dados['headDescricao'] = 'selos';
		$this->dados['headPagina'] = 'Home';
		$this->dados['faceTipo'] = 'website';


		return view('pages/timestamp/home', $this->dados);
	}

	public function formCompra(Request $request)
	{

		$id_cliente = Cookie::get('time_user_cookie');
		$conta = \DB::table('time_clients_conta')->where('id_cliente', $id_cliente)->first();

		$invoiceEmail = trim($request->invoiceEmail);
		$nome_entidade = trim($request->nome_entidade);
		$nif_entidade = trim($request->nif_entidade);
		$contacto_entidade = trim($request->contacto_entidade);
		$email_entidade = trim($request->email_entidade);
		$morada_entidade = trim($request->morada_entidade);
		$morada_cont_entidade = trim($request->morada_cont_entidade);
		$codigo_postal_entidade = trim($request->codigo_postal_entidade);
		$localidade_entidade = trim($request->localidade_entidade);
		$pais_entidade = trim($request->pais_entidade);
		$pacote = trim($request->pacote);

		$message = "";

		if (empty($invoiceEmail)) {
			return 'Campo email de recepção da fatura vazio.';
		}
		if (!filter_var($invoiceEmail, FILTER_VALIDATE_EMAIL)) {
			return 'O campo email de recepção da fatura inválido. Introduza um email válido.';
		}
		if (empty($nome_entidade)) {
			return 'Campo nome da entidade vazio.';
		}
		if (empty($nif_entidade)) {
			return 'Campo NIF vazio.';
		}
		if (empty($contacto_entidade)) {
			return 'Campo contacto vazio.';
		}
		if (empty($email_entidade)) {
			return 'Campo endereço de email vazio.';
		}
		if (!filter_var($invoiceEmail, FILTER_VALIDATE_EMAIL)) {
			return 'O campo endereço de email inválido. Introduza um email válido.';
		}
		if (empty($morada_entidade)) {
			return 'Campo morada vazio.';
		}
		if (empty($codigo_postal_entidade)) {
			return 'Campo código postal vazio.';
		}
		if (empty($localidade_entidade)) {
			return 'Campo localidade vazio.';
		}
		if (empty($pais_entidade)) {
			return 'Campo país vazio.';
		}

		// $check = \DB::table('time_compra')

		\DB::table('time_compra')
			->insert([
				'id_cliente' => $id_cliente,
				'id_conta' => $conta->id,
				//'id_pacote' => $pacote,
				'tipo_fatura' => 'eletronica',
				'email_fatura' => $invoiceEmail,
				'nome_entidade' => $nome_entidade,
				'nif_entidade' => $nif_entidade,
				'contacto_entidade' => $contacto_entidade,
				'email_entidade' => $email_entidade,
				'morada_entidade' => $morada_entidade,
				'morada_cont_entidade' => $morada_cont_entidade,
				'codigo_postal_entidade' => $codigo_postal_entidade,
				'localidade_entidade' => $localidade_entidade,
				'pais_entidade' => $pais_entidade,
				//https://www.epochconverter.com/ conversao de timestamp  1633535238
				// 'data' => \Carbon\Carbon::now()->timestamp
				'data' => strtotime(date('Y-m-d H:i:s'))
			]);

		$message = 'Dados guardados com sucesso. Procedemos ao pagamento.';

		// if ($check) {
		// 	$message = 'Dados guardados com sucesso. Procedemos ao pagamento.';
		// } else {
		// 	return "Erro na insercao de dados. Por favor tenta de novo.";
		// }

		$resposta = [
			'estado' => 'sucesso',
			'mensagem' => $message   // mensagem
		];

		return json_encode($resposta, true);
	}
}
