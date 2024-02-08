<?php

interface IZvladacOznameni {
    function zvladnout_cenzurovany_php_token(PhpToken $token) ;
    function zvladnout_vyrazeny_token(PhpToken $token, string $nahradni_token) ;
}
