<?php

require_once "nastroje.php" ;

class MapovanyToken {
    public string $ostraphp_token ;
    public string $php_token ;
    public string | null $nahradni_token ; // pouze pokud je token vyřazený

    function __construct(string $ostraphp_token, string $php_token, string | null $nahradni_token) {
        $this->ostraphp_token = $ostraphp_token ;
        $this->php_token = $php_token ;
        $this->nahradni_token = $nahradni_token ;
    }
}

function zpracuj_csv(string $text): array {
    $mapa_tokenu = array() ;

    foreach (explode("\n", $text) as $line) {
        if (str_starts_with($line, "//") || strlen($line) === 0)
            continue ;

        $komponenty = explode(",", $line) ;
        $php_token = trim($komponenty[0]) ;
        $ostraphp_token = trim($komponenty[1]) ;
        $nahradni_token = null ;
        if (count($komponenty) > 2)
            $nahradni_token = trim($komponenty[2]) ;

        $mapa_tokenu[$php_token] = new MapovanyToken($php_token, $ostraphp_token, $nahradni_token) ;
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

    private function nahrad_token_ve_vystupu(int $pozice, string $puvodni_token, string $novy_token): void {
        global $odsazeni_ve_vystupu ;
        global $vystupny_php_kod ;

        $token_offset_in_vystupny_php_kod = $pozice + $this->odsazeni_ve_vystupu ;
        $this->vystupny_php_kod = substr_replace($this->vystupny_php_kod, $novy_token, $token_offset_in_vystupny_php_kod, mb_strlen($puvodni_token)) ;
        $this->odsazeni_ve_vystupu += strlen($novy_token) - strlen($puvodni_token) ;
    }

    function __construct(string $ostraphp_kod) {
        $this->tokeny = PhpToken::tokenize($ostraphp_kod) ;
        $this->odsazeni_ve_vystupu = 0 ;
        $this->vystupny_php_kod = $ostraphp_kod ;
    }

    function transpilovat(IZvladacOznameni $zvladac_php_tokenu): string {
        global $mapa_tokenu ;

        foreach ($this->tokeny as $token) {
            if (in_array($token->id, ID_IGNOROVANYCH_TOKENU))
                continue ;

            if (array_key_exists($token->text, $mapa_tokenu)) {
                $mapovany_token = $mapa_tokenu[$token->text] ;

                if ($mapovany_token->nahradni_token !== null)
                    $zvladac_php_tokenu->zvladnout_vyrazeny_token($token, $mapovany_token->nahradni_token) ;

                $this->nahrad_token_ve_vystupu(
                    $token->pos,
                    $token->text,
                    $mapovany_token->php_token
                ) ;
            } else if (najit_na_poli($mapa_tokenu, function($prvek) use ($token) { return $prvek->php_token === $token->text ; })) {
                $zvladac_php_tokenu->zvladnout_cenzurovany_php_token($token) ;
            }
        }

        return $this->vystupny_php_kod ;
    }
}
