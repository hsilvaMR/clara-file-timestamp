<?php
namespace App\Http\Middleware;

use Closure;
use Cookie;

/* CheckAccount */
class Client {

  public function handle($request, Closure $next){

    
    if(Cookie::get('time_user_cookie')){ 
      $id_user=Cookie::get('time_user_cookie');

      $user = \DB::table('time_clients')->where('id',$id_user)->first();

      $user_compra = \DB::table('time_compra')->where('id_cliente',$id_user)->first();

      if($user) {
        if ($user->estado == 'pendente') { return redirect()->route('ativarContaS',$user->token); }
        else if($user->estado == 'cancelada'){ return redirect()->route('ativarContaS',$user->token); }
        else{
          if(isset($user_compra->id)) {
            Cookie::queue(Cookie::make('time_user_compra_cookie', $user_compra->id, 43200));
          }

          return $next($request);
        }
      }
      else{return redirect()->route('loginTimePage');}
    }
    else{ return redirect()->route('loginTimePage');}    
  }

}