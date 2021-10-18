<?php

namespace App\Http\Controllers\Timestamp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;


use Hash;
use Validator;
use Mail;
use Cookie;

class FicheiroController extends Controller
{

    //Função - data OAL - Observatório Astronómico de Lisboa 

    public function createDateOAL()
    {
        $get = file('http://oal.ul.pt/HoraLegalOAL/gettime_new.php', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return $get;
    }

    // ler o ficheiro 
    public function ficheiro(Request $requestFile)
    {

        $ficheiro = $requestFile->fileClient;
        $hora = self::createDateOAL();
    }
    //validar o ficheiro
    public function validarFicheiro()
    {
    }


    // salvar o selo e ficheiro numa pasta
    public function salavarFicheiro()
    {

        //basename() --> Retorna o nome do arquivo de um dado path.  
        //$files[] = ['file' => $value];
        $nomeDocSelo = 'selotestHS-' . str_random(3) . '-' . basename($value);
        $pastaDestino  = '../public_html/selos_testHs/' . $nomeDocSelo;
    }

    // download do ficheiro 
    public function downloadFicheiro()
    {
    }
}
