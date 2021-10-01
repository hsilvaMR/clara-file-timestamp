<?php namespace App\Http\Controllers\Timestamp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use Hash;
use Cookie;

class TimeLogin extends Controller
{
  private $dados=[];
  
  public function index(){
    $this->dados['headTitulo']='';
    $this->dados['headDescricao']='';
    $this->dados['headFoto']='';
    $this->dados['separador']='time';

  	return view('pages/timestamp/time-login', $this->dados);
  } 

  public function loginPost(Request $request){


    /*$email = trim($request->email);
    $password = Hash::make($request->password);
    $token = str_random(12);
        

    $user = \DB::table('time_clients')->where('email', $email)->first();
    if(empty($user)){ return 'Este utilizador não está registado'; }
    if(!Hash::check($request->password, $user->password)){ return 'Password inválida!'; }

    if (isset($user->id)) {
 
      \DB::table('time_clients')
                ->where('email',$email)
                ->update(['ultimo_acesso' => strtotime(date('Y-m-d H:i:s'))]);
    }*/



    /*$email = 'teste@mail.com';
    $password = '123456';*/
    $token = str_random(12);

    $email = $request->username;
    $password = $request->password;

    $client = \DB::table('time_clients')->where('email',$email)->where('password',$password)->first();

    if($client->id){
      \DB::table('time_clients')->where('id',$client->id)->update([ 'ultimo_acesso' => strtotime(date('Y-m-d H:i:s')) ]);

      //$values = $client->id;
      //setcookie("log", $values, time()+3600);

      $resposta = [
        'client' => $client->id,
        'message' => 'sucesso'
      ];
      
      echo json_encode($resposta,true);
   
    }else{
      return 'Este utilizador não existe';
    } 
  }
}