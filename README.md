# OstraPHP

> OstraPHP má za cíl pozvednout kvalitu (nejen ostravského) programování. Na
> rozdíl od PHP vychází OstraPHP přímo z mluveného jazyka (ostravského nářečí),
> tedy z něčeho, čemu obyčejní lidé rozumějí. Typický ostravský horník pak
> nebude mít problém přejít od těžby uhlí ke klávesnici. Jazyk tak mimo jiné
> řeší i problém nezaměstnanosti na Moravsko-Slezsku.

Inspirováno [OSTRAJavou](https://github.com/tkohout/OSTRAJava), v prestižnějším
jazyce. Předmluva ukradena od nich.

## Instalace

Pro instalaci je zapotřebí mít správce balíčků
[composer](https://getcomposer.org/), pak stačí z terminálu spustit:

```bash
composer global require "vfosnar/ostraphp=^1.0.1"
```

Tím nainstalujete OstraPHP transpilátor do `~/.composer/vendor/bin/ophp`. Pro
přímé použití z terminálu přidejte cestu `~/.composer/vendor/bin` do `PATH`.

## Příklady

### Hello, world

Narozdíl od MarasJavy (OSTRAJavy) nepotřebujete pro pozdrav téměř žádny
boilerplate:

```php
<?php
povedz "Toz vitaj" pyco
```

### Podmínky

```php
<?php

$a pyco
$b pyco

//...

kaj ($a === fajne aj $b === fajne) {
   // ...
} kajtez ($a === nyt ci $b === fajne) {
   // ...
} boinak {
   // ...
}
```

### Cykly

```php
<?php

$i = 0 pyco

rubat ($i < 5) {
    kaj ($i == 4) {
      zdybat pyco 
   }
   //...
   $i++ pyco
}
```

### Dědičnost

```php
<?php

tryda Obdelnik {
    moe cyslo $dylka pyco
    moe cyslo $vyska pyco

    makacenko __rynek(cyslo $dylka, cyslo $vyska) {
        $joch->dylka = $dylka pyco
        $joch->vyska = $vyska pyco
    }
}

tryda Stverec fagan_od Obdelnik {
    makacenko __rynek(cyslo $velikost) {
        forant::__rynek($velikost, $velikost) pyco
    }
}

$s = zrob Stverec(5) pyco
```

### Metody

```php
<?php

tryda Buu {
    makacenko fuu(dryst $text): cyslo {
        davaj rachuj_dryst($text) pyco
    }
}

$b = zrob Buu() pyco
$f = $b->fuu("uwuw") pyco
cotoe($f) pyco
```

## Překlady tokenů

Existující překlady si můžete
[prohlédnout zde](https://gitlab.com/vfosnar/ostraphp/-/blob/main/php/tokeny.csv?plain=1).
Dalším překladům a případným opravám jsme otevřeni. Stačí vytvořit novou issue,
PR, nebo mě návrh [jakkoliv pošlete](https://vfosnar.cz/) ;)

## Vývoj

Transpilátor jako takový je jen pár řádků OstraPHP, zdrojový kód se nachází ve
složce `ostrava/`. Pro sestavení projektu slouží script `sestavit.sh`.
