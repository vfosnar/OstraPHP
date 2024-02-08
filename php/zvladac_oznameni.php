<?php

require_once "i_zvladac_oznameni.php" ;

class ZvladacOznameni implements IZvladacOznameni {
    private $slitovani ;
    private $prefix ;

    function __construct(bool $slitovani, string $prefix) {
        $this->slitovani = $slitovani ;
        $this->prefix = $prefix ;
    }

    function zvladnout_cenzurovany_php_token(PhpToken $token) {
        $text = $token->text ;
        $line = $token->line ;
        $zprava = "Použití zakázaného PHP tokenu \"$text\" na řádku $line\n" ;

        if ($this->slitovani) {
            $this->vypsat_upozorneni($zprava) ;
        } else {
            $this->vypsat_chybu_a_ukoncit($zprava) ;
        }
    }

    function zvladnout_vyrazeny_token(PhpToken $token, string $nahradni_token) {
        $text = $token->text ;
        $line = $token->line ;
        $zprava = "Použití vyřazeného tokenu \"$text\" na řádku $line, nahrazuje ho \"$nahradni_token\"\n" ;

        if ($this->slitovani) {
            $this->vypsat_upozorneni($zprava) ;
        } else {
            $this->vypsat_chybu_a_ukoncit($zprava) ;
        }
    }

    private function vypsat_upozorneni($zprava) {
        file_put_contents("php://stderr", "$this->prefix$zprava", FILE_APPEND) ;
    }

    private function vypsat_chybu_a_ukoncit($zprava) {
        die("$this->prefix[Chyba] $zprava") ;
    }
}
