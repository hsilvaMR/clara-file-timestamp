<?php namespace App\Http\Controllers\Timestamp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;


use Hash;
use Validator;
use Mail;
use Cookie;

class Time extends Controller
{
  	private $dados=[];

	public function chama(){

		$username = 'cvieira@mredis.com';
		$password = '!610?[bg%tP-';

	    $postfields = array('username' => 'cvieira@mredis.com', 'password' => '!610?[bg%tP-'); 

	    $tsa_url_get = 'http://www.mredis.com/timestampLogin';
	    $tsa_url_post = 'http://www.mredis.com/timestamp-login-form';


		//$postfields = array('field1'=>'value1', 'field2'=>'value2');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $tsa_url_post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		// Edit: prior variable $postFields should be $postfields;
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // On dev server only!
		$result = curl_exec($ch);

		
	    //echo $result;
		
		

		$resp = json_decode($result,true);

	    if ($resp['message'] == 'sucesso') {

	    
	    	self::enviarDoc($resp['client']);
	    	//echo $result;
	    }
		
	}



	//Função para enviar documento para marcação de data/hora
	public function enviarDoc($id_client){


		//SEND DOCUMENTOS POR CURL POST

		$tsa_url_post = 'http://www.mredis.com/timestamp-receive';
		//$postfields = $array_docs;


		//Criar Array com od documentos
		$array_docs = array('https://gaivota.pt/img/pdf/255_bonfim.pdf','https://gaivota.pt/img/pdf/n101-apresentacaosucinta.pdf');

		$postfields = array('file' => $array_docs,'id_client' => $id_client); 

		$fields_string = http_build_query($postfields);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $tsa_url_post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		// Edit: prior variable $postFields should be $postfields;
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // On dev server only!
		$result = curl_exec($ch);

		//echo $result;

	    $resposta_doc = json_decode($result,true);

	    if ($resposta_doc['message'] == 'sucesso_doc') {

	    	foreach ($resposta_doc['docs'] as $value) {
	    		

	    		$nome = 'file'.str_random(3).'-'.basename($value['doc']);
	    		$saveTo = '../public_html/save_selo/'.$nome;

	    		$fp = fopen($saveTo, 'w+');

				if($fp === false){
				    throw new Exception('Could not open: ' . $saveTo);
				}

				$url = 'http://www.mredis.com/'.$value['doc'];
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_FILE, $fp);
				curl_setopt($ch, CURLOPT_TIMEOUT, 20);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_exec($ch);

				if(curl_errno($ch)){
				    throw new Exception(curl_error($ch));
				}

				$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				fclose($fp);

				if($statusCode == 200){ echo 'Downloaded!'; } 
				else{ echo "Status Code: " . $statusCode; }


	    	}
	    	
	    }
		
	}


	public function downloadTimeStamp(Request $request){

		$url = $request->d.$request->f;
		$dominio = $request->d;
		$nome = $request->n;

	 	$saveTo = '../public_html/save_selo/'.$nome;


		$fp = fopen($saveTo, 'w+');

		if($fp === false){
		    throw new Exception('Could not open: ' . $saveTo);
		}

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_exec($ch);

		if(curl_errno($ch)){
		    throw new Exception(curl_error($ch));
		}

		$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		fclose($fp);

		if($statusCode == 200){ echo 'Downloaded!'; } 
		else{ echo "Status Code: " . $statusCode; }
	}

	

 
}