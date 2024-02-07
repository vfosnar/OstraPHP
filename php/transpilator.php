<?php

function zpracuj_csv(string $text): array {
    $mapa_tokenu = array() ;

    foreach (explode("\n", $text) as $line) {
        if (str_starts_with($line, "//") || strlen($line) === 0)
            continue ;

        $komponenty = explode(",", $line) ;
        $mapa_tokenu[trim($komponenty[0])] = trim($komponenty[1]) ;
    }

    return $mapa_tokenu ;
}

$csv_text_tokeny = file_get_contents(__DIR__ . "/tokeny.csv") ;
$mapa_tokenu = zpracuj_csv($csv_text_tokeny) ;

define("ID_IGNOROVANYCH_TOKENU", array(
    T_DOC_COMMENT,
    T_END_HEREDOC,
    T_INLINE_HTML,
)) ;

class Transpilator {
    private array $tokeny ;
    private int $odsazeni_ve_vystupu ;
    private string $vystupny_php_kod ;

    private function nahrad_token_ve_vystupu($pozice, $puvodni_token, $finalni_token) {
        global $odsazeni_ve_vystupu ;
        global $vystupny_php_kod ;

        $token_offset_in_vystupny_php_kod = $pozice + $this->odsazeni_ve_vystupu ;
        $this->vystupny_php_kod = substr_replace($this->vystupny_php_kod, $finalni_token, $token_offset_in_vystupny_php_kod, mb_strlen($puvodni_token)) ;
        $this->odsazeni_ve_vystupu += strlen($finalni_token) - strlen($puvodni_token) ;
    }

    function __construct(string $ostraphp_kod) {
        $this->tokeny = PhpToken::tokenize($ostraphp_kod) ;
        $this->odsazeni_ve_vystupu = 0 ;
        $this->vystupny_php_kod = $ostraphp_kod ;
    }

    function transpilovat() {
        global $mapa_tokenu ;

        foreach ($this->tokeny as $token) {
            if (in_array($token->id, ID_IGNOROVANYCH_TOKENU))
                continue ;

            if (array_key_exists($token->text, $mapa_tokenu)) {
                $this->nahrad_token_ve_vystupu(
                    $token->pos,
                    $token->text,
                    $mapa_tokenu[$token->text]
                ) ;
            } else if (in_array($token->text, $mapa_tokenu)) {
                $this->nahrad_token_ve_vystupu(
                    $token->pos,
                    $token->text,
                    "/* tohle je OstraPHP -_- */"
                ) ;
            }
        }

        return $this->vystupny_php_kod ;
    }
}
