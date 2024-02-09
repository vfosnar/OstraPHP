<?php

require_once "i_zvladac_oznameni.php" ;

class ZvladacOznameni implements IZvladacOznameni {
    private $striktni ;
    private $prefix ;

    function __construct(bool $striktni, string $prefix) {
        $this->striktni = $striktni ;
        $this->prefix = $prefix ;
    }

    function zvladnout_cenzurovany_php_token(PhpToken $token) {
        $zprava = "Použití zakázaného PHP tokenu \"$token->text\" na řádku $token->line\n" ;

        if ($this->striktni) {
            $this->vypsat_chybu_a_ukoncit($zprava) ;
        } else {
            $this->vypsat_upozorneni($zprava) ;
        }
    }

    function zvladnout_vyrazeny_token(PhpToken $token, string $nahradni_token) {
        $zprava = "Použití vyřazeného tokenu \"$token->text\" na řádku $token->line, nahrazuje ho \"$nahradni_token\"\n" ;

        if ($this->striktni) {
            $this->vypsat_chybu_a_ukoncit($zprava) ;
        } else {
            $this->vypsat_upozorneni($zprava) ;
        }
    }

    private function vypsat_upozorneni($zprava) {
        file_put_contents("php://stderr", "$this->prefix$zprava", FILE_APPEND) ;
    }

    private function vypsat_chybu_a_ukoncit($zprava) {
        die("$this->prefix[Chyba] $zprava") ;
    }
}
