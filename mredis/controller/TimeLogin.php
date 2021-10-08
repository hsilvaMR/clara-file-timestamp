<?php

namespace App\Http\Controllers\Timestamp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use Hash;
use Cookie;

class TimeLogin extends Controller
{
  private $dados = [];

  public function index()
  {
    $this->dados['headTitulo'] = '';
    $this->dados['headDescricao'] = '';
    $this->dados['headFoto'] = '';
    $this->dados['separador'] = 'time';

    return view('pages/timestamp/time-login', $this->dados);
  }

  public function loginPost(Request $request)
  {

    /*
         ----- dados de acesso-----
          email : hsilva@mredis.com
          password : Hkn15d77
      */

    $email = trim($request->username);
    $password = trim($request->password);

    if (empty($email)) {
      return 'Deve preencher o campo. Email';
    }

    if (empty($password)) {
      return 'Deve preencher o campo. Password';
    }

    $client = \DB::table('time_clients')->where('email', $email)->where('password', $password)->first();

    if (empty($client->id)) {
      return 'Este utilizador não existe';
    }
    \DB::table('time_clients')->where('id', $client->id)->update(['ultimo_acesso' => strtotime(date('Y-m-d H:i:s'))]);

    $resposta = [
      'estado' => 'sucesso',
      'message' => 'Login Efectuado Com Sucesso.'
    ];
    return  json_encode($resposta, true);
  }
}
