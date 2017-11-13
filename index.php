<?php
namespace marko\Kungfu;
require_once "vendor/autoload.php";
use HTL3R\KungFuMovies\AbstractKungFuMovie as kungfumovie;
use HTL3R\KungFuMovies\IKungFuMovie as kungfui;
use endroid\qrcode as QrCode;
class Film extends kungfumovie implements kungfui{
    public function __construct(string $name, int $rating, string $movieURI){
        parent::__construct($name, $rating, $movieURI);
    }
    public function getMovieInfoAsJSON(): string{
        header('Content-Type:application/json');
        $json = "{\n".
            '"name":"'.$this->getName().'",'."\n".
            '"rating":"'.$this->getRating().'",'."\n".
            '"movieURL":"'.$this->getMovieURI().'"'."\n".
            "}\n";
        return $json;
    }
    public function getMovieQRCodeForBrowser(): string{
        $qrCode=new QrCode($this->getMovieURI());
        header('Content-Type: '.$qrCode->getContentType());
        return $qrCode->writeString();
    }
}
$myFilm=new Film("Bruce Lee - Der Mann mit der Todekralle",5,"https://www.youtube.com/watch?v=80wXmIcyZwk");
if(isset($_GET['format'])){
    if($_GET['format']=='json'){
        echo $myFilm->getMovieInfoAsJSON();
    }else if($_GET['format']=='qr'){
        echo $myFilm->getMovieQRCodeForBrowser();
    }
}else{
    echo"<h1>".$myFilm->getName()."</h1>";
    echo"<a href='index.php/?format=json'>Filminfo als JSON</a><br>";
    echo"<a href='index.php/?format=qr'>Filminfo als QR-Code</a>";
}


