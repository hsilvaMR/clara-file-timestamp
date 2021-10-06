<?php

namespace App\Http\Controllers\Timestamp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;


use Hash;
use Validator;
use Mail;
use Cookie;

class Client extends Controller
{
    private $dados = [];

    public function index()
    {

        $this->dados['headTitulo'] = 'Area-selos';
        $this->dados['headDescricao'] = 'Area-selos';
        $this->dados['headPagina'] = 'Area';
        $this->dados['faceTipo'] = 'website';

        $id_user = Cookie::get('time_user_cookie');
        $user_compra = \DB::table('time_compra')->where('id_cliente', $id_user)->first();
        $user_conta = \DB::table('time_clients_conta')->where('id_cliente', $id_user)->get();

        $pacote_array = [];
        // @foreach ($user_conta as $value) {
        foreach ($user_conta as $value) {
            $pacotes = \DB::table('time_compra')->where('id_cliente', $id_user)->where('id_conta', $user_conta->id)->get();
            $pacote_array[] = [
                'id_pacote' => $id_pacote,
                'tipo_fatura' => $tipo_fatura,
                'data' => $data
            ];
        }

        $this->dados['pacote_array'] = $pacote_array;
        $this->dados['user_conta'] = $user_conta;
        $this->dados['user_compra'] = $user_compra;

        return view('pages/timestamp/clientArea', $this->dados);
    }


    public function api()
    {

        $this->dados['headTitulo'] = 'Area-Api-selos';
        $this->dados['headDescricao'] = 'Area-Api-selos';
        $this->dados['headPagina'] = 'Area';
        $this->dados['faceTipo'] = 'website';


        $id_user = Cookie::get('time_user_cookie');
        $user = \DB::table('time_clients')->where('id', $id_user)->first();
        $this->dados['user_conta'] = \DB::table('time_clients_conta')->where('id_cliente', $id_user)->get();
        $this->dados['user'] = $user;

        return view('pages/timestamp/clientAreaApi', $this->dados);
    }


    public function pagamentos()
    {
        $this->dados['headTitulo'] = 'Area-Api-selos-pag';
        $this->dados['headDescricao'] = 'Area-Api-selos-pag';
        $this->dados['headPagina'] = 'Area';
        $this->dados['faceTipo'] = 'website';

        return view('pages/timestamp/clientPagamentos', $this->dados);
    }

    public function formAddConta(Request $request)
    {

        $id_user = Cookie::get('time_user_cookie');
        $id_conta = trim($request->id_conta);

        $nome = trim($request->nome);
        $email = trim($request->email);
        $contacto = trim($request->contacto);
        $morada = trim($request->morada);
        $rua = trim($request->rua);
        $codigo_postal = trim($request->codigo_postal);
        $localidade = trim($request->localidade);
        $pais = trim($request->pais);
        $nif = trim($request->nif);
        $mensagem = '';

        if (empty($nome)) {
            return 'Campo nome da entidade vazio.';
        }
        if (empty($email)) {
            return 'Campo endereço de email vazio.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'O campo endereço de email inválido. Introduza um email válido.';
        }
        if (empty($contacto)) {
            return 'Campo contacto vazio.';
        }
        if (empty($morada)) {
            return 'Campo morada vazio.';
        }
        if (empty($codigo_postal)) {
            return 'Campo código postal vazio.';
        }
        if (empty($localidade)) {
            return 'Campo localidade vazio.';
        }
        if (empty($pais)) {
            return 'Campo país vazio.';
        }
        if (empty($nif)) {
            return 'Campo NIF vazio.';
        }

        if (isset($id_conta)) {

            if ($id_conta != null || $id_conta != '') {

                \DB::table('time_clients_conta')
                    ->where('id', $id_conta)
                    ->update([
                        'nome_conta' => $nome,
                        'email' => $email,
                        'contacto' => $contacto,
                        'morada' => $morada,
                        'rua' => $rua,
                        'codigo_postal' => $codigo_postal,
                        'localidade' => $localidade,
                        'pais' => $pais,
                        'nif' => $nif,
                        'data_alteracao' => \Carbon\Carbon::now()->timestamp
                    ]);

                $mensagem = 'Conta alterada com sucesso.';
            }
        } else {

            if ($id_conta != null || $id_conta != '') {

                \DB::table('time_clients_conta')
                    ->insert([
                        'id_cliente' => $id_user,
                        'nome_conta' => $nome,
                        'email' => $email,
                        'contacto' => $contacto,
                        'morada' => $morada,
                        'rua' => $rua,
                        'codigo_postal' => $codigo_postal,
                        'localidade' => $localidade,
                        'pais' => $pais,
                        'nif' => $nif,
                        'data_criacao' => \Carbon\Carbon::now()->timestamp,
                        'data_alteracao' => \Carbon\Carbon::now()->timestamp
                    ]);

                $mensagem = 'Conta criada com sucesso.';
            } else {

                return  'Id da conta não registado';
            }
        }

        $resposta = [
            'estado' => 'sucesso',
            'mensagem' => $mensagem
            // 'mensagem' => 'Conta criada com sucesso.'
        ];

        return json_encode($resposta, true);
    }
}
