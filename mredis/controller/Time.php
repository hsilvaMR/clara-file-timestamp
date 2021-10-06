<?php

namespace App\Http\Controllers\Timestamp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use Cookie;
use Mail;

class Time extends Controller
{
  private $dados = [];

  public function index()
  {
    return view('pages/timestamp/time', $this->dados);
  }

  //Função - data OAL - Observatório Astronómico de Lisboa 

  public function createDateOAL()
  {
    $get = file('http://oal.ul.pt/HoraLegalOAL/gettime_new.php', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    return $get;
  }

  //Função que recebe o documento que será para marcar de data/hora
  //Guarda o documento
  //Cria o selo temporal

  public function postDocumento(Request $request)
  {

    $post_file = $request->file;
    $id_client = $request->id_client;
    //$hora = $request->hora;

    $cont = count($post_file);

    $client = \DB::table('time_clients')->where('id', $id_client)->first();

    $total_selos = $client->numero_selos - $cont;

    if (($client->data_validade_selos >= \Carbon\Carbon::now()->timestamp)) {
      if (($total_selos >= 0 || $client->numero_selos == 'ilimitado')) {

        $hora = self::createDateOAL();

        $string = str_replace('"', '', $hora); // Replaces all spaces with hyphens.

        $string_nova = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        foreach ($string_nova as $value) {
          $hora = $value;
        }


        $files = [];


        $array_nome = [];
        $array_resposta = [];
        foreach ($post_file as $value) {


          $files[] = ['file' => $value];

          $ch = curl_init($value);
          curl_setopt($ch, CURLOPT_NOBODY, true);
          curl_exec($ch);
          $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          curl_close($ch);

          if ($code == 200) {

            $name_doc = 'timestamp-' . str_random(3) . '-' . basename($value);

            $id = \DB::table('time_clients_pdf')
              ->insertGetId([
                'id_cliente' => $id_client,
                'data_entrada' => $hora
              ]);

            $id_pdf_file = \DB::table('time_clients_pdf_files')
              ->insertGetId([
                'id_pdf' => $id,
              ]);

            $destination = '../public_html/selos_pdf/' . $name_doc;
            //DIGITAL TSA TOKEN
            $code_file = chunk_split(base64_encode(file_get_contents($value)));
            \DB::table('time_clients_pdf_files')
              ->where('id', $id_pdf_file)
              ->update([
                'file' => $destination,
                'tsa_token' => $code_file
              ]);

            //CRIAR PDF DO SELO TEMPORAL
            $this->dados['name_file'] = $name_doc;
            $this->dados['timestamp'] = $hora;

            $code_file = substr($code_file, 0, 200);
            $seconds = $hora / 1000;
            $time = date("Y-m-d H:i:s", $seconds);

            $array_nome[] = ['nome' => $name_doc, 'hora' => $time, 'codigo' => $code_file];
            $array_resposta[] = ['doc' => '/selos_pdf/' . $name_doc];
          }
        }

        $this->dados['array_nome'] = $array_nome;

        if ($client->numero_selos == 'ilimitado') {
          $total_selos = 'ilimitado';
        }

        return self::pdf($name_doc, $hora, $code_file, $array_resposta, $total_selos, $id_client);
      } else {
        //ENVIAR EMAIL AO CLIENTE A INFORMAR QUE NÃO TEM SELOS SUFICIENTES PARA REALIZAR A OPERAÇÃO

        $desc = 'Caro cliente, <br> Não foi possível fazer a sua marcação de selos temporais, uma vez que não tem selos suficientes para a ação.<br> O número de selos na sua conta neste momento é de, ' . $client->numero_selos . ' selos disponíveis.<br> Para continuar a ação terá de renovar o seu serviço.<br><br> Com os melhores cumprimentos, <br> Team Mredis.';

        $data = ['desc' => $desc];
        Mail::send('emails/timestamp/timestamp_aviso', $data, function ($message) use ($client) {
          $message->to($client->email, '')->subject('Erro na marcação se selos temporais');
          $message->from(config('mailAccounts.geral')['email'], config('mailAccounts.geral')['nome']);
        });
      }
    } else {
      //ENVIAR EMAIL AO CLIENTE A INFORMAR QUE OS SELOS EXPIRARAM

      $desc = 'Caro cliente, <br> Não foi possível fazer a sua marcação de selos temporais, uma vez que não tem selos disponíveis para a ação.<br> Os seus selos expiraram no dia ' . date('Y-m-d', $client->data_validade_selos) . '.<br> Para continuar a ação terá de renovar o seu serviço.<br><br> Com os melhores cumprimentos, <br> Team Mredis.';

      $data = ['desc' => $desc];
      Mail::send('emails/timestamp/timestamp_aviso', $data, function ($message) use ($client) {
        $message->to($client->email, '')->subject('Erro na marcação se selos temporais');
        $message->from(config('mailAccounts.geral')['email'], config('mailAccounts.geral')['nome']);
      });
    }
  }

  public function pdf($name_doc, $timestamp, $code_file, $resposta, $cont, $id_client)
  {

    $this->dados['name_file'] = $name_doc;
    $this->dados['timestamp'] = $timestamp;
    $this->dados['code_file'] = $code_file;


    ob_start();
    echo view('pages/timestamp/time-selo-pdf', $this->dados);
    ob_end_clean();

    //ENVIAR SELOS
    echo self::sendDoc($resposta, $cont, $id_client);
  }


  public function sendDoc($resposta, $cont, $id_client)
  {

    \DB::table('time_clients')
      ->where('id', $id_client)
      ->update([
        'numero_selos' => $cont
      ]);

    $resposta_doc = [
      'docs' => $resposta,
      'message' => 'sucesso_doc'
    ];

    return json_encode($resposta_doc, true);
  }
}
