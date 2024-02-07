<?php

function projit_slozku(string $cesta): array {
    $cesta = realpath($cesta) ;
    if ($cesta === false)
        die("složka v zadané cestě neexistuje\n") ;
    
    $frontaSlozek = array($cesta) ;
    $soubory = array() ;

    while (count($frontaSlozek) > 0) {
        $cesta = array_shift($frontaSlozek) ;

        $drzakSlozky = opendir($cesta) ;
        while (($predmet = readdir($drzakSlozky)) !== false) {
            if ($predmet === "." || $predmet === "..")
                continue ;

            $cestaKPredmetu = $cesta . "/" . $predmet ;
            if (is_file($cestaKPredmetu))
                array_push($soubory, $cestaKPredmetu) ;
            else if (is_dir($cestaKPredmetu))
                array_push($frontaSlozek, $cestaKPredmetu) ;
        }
        closedir($drzakSlozky) ;
    }

    return $soubory ;
}

// TODO: tohle není ideální implementace
function normalizovat_cestu(string $cesta): string | false {
    if (str_starts_with($cesta, "/"))
        return rtrim($cesta, "/") ;
    else
        return rtrim(getcwd() . "/" . $cesta, "/") ;
}

function nahradit_koncovku(string $cesta, string $puvodni_koncovka, string $nova_koncovka): string {
    return mb_substr($cesta, 0, mb_strlen($cesta) - mb_strlen($puvodni_koncovka)) . $nova_koncovka ;
}
