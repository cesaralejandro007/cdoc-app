<?php

namespace App\Controllers;
use App\Models\Home;
use App\Models\Token;
use App\Core\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Core\Responses;

class HomeController extends Controller {
    protected $home;
    protected $responses;
    protected $token;

    public function __construct() {
        $this->responses = new Responses();
        $this->home = new home();
        $this->token = new Token();
    }

    /**
     * consulta el reporte de documentos de cada mes.
     */
    public function consultarReporteDoc() {   
        $this->home->consultarReporteDocAll();
    }

    public function getDoc($id) {   
        $this->home->consultarDocumentos($id);
    }

    public function getDocAll() {   
        $this->home->consultarDocAll();
    }
}
