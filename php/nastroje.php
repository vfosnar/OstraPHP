<?php

function projit_slozku(string $cesta): array {
    $cesta = realpath($cesta) ;
    if ($cesta === false)
        die("složka v zadané cestě neexistuje\n") ;
    
    $fronta_slozek = array($cesta) ;
    $soubory = array() ;

    while (count($fronta_slozek) > 0) {
        $cesta = array_shift($fronta_slozek) ;

        $drzak_slozky = opendir($cesta) ;
        while (($predmet = readdir($drzak_slozky)) !== false) {
            if ($predmet === "." || $predmet === "..")
                continue ;

            $cesta_predmetu = $cesta . "/" . $predmet ;
            if (is_file($cesta_predmetu))
                array_push($soubory, $cesta_predmetu) ;
            else if (is_dir($cesta_predmetu))
                array_push($fronta_slozek, $cesta_predmetu) ;
        }
        closedir($drzak_slozky) ;
    }

    return $soubory ;
}

function normalizovat_cestu(string $cesta): string | false {
    $komponenty = array() ;
    if (!str_starts_with($cesta, "/"))
        $komponenty = explode("/", getcwd()) ;
    
    $cesta = rtrim($cesta, "/") ;
    $komponenty_cesty = explode("/", $cesta) ;
    foreach ($komponenty_cesty as $komponent) {
        if ($komponent === "..")
            array_pop($komponenty) ;
        else if ($komponent !== ".")
            array_push($komponenty, $komponent) ;
    }

    return implode("/", $komponenty) ;
}

function nahradit_koncovku(string $cesta, string $puvodni_koncovka, string $nova_koncovka): string {
    return mb_substr($cesta, 0, mb_strlen($cesta) - mb_strlen($puvodni_koncovka)) . $nova_koncovka ;
}

function najit_na_poli($pole, $makacenko) {
    foreach ($pole as $prvek) {
        if (call_user_func($makacenko, $prvek) === true)
            return $prvek ;
    }
    return null ;
}
