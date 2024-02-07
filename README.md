# OstraPHP

> Bo neni cas pyco

Inspirováno [OSTRAJavou](https://github.com/tkohout/OSTRAJava), v prestižnějším
jazyce.

## Použití

Pro instalaci je zapotřebí mít správce balíčků
[composer](https://getcomposer.org/), pak stačí z terminálu spustit:

```bash
composer global require "vfosnar/ostraphp=* @dev"
```

Tím nainstalujete OstraPHP transpilátor do `~/.composer/vendor/bin/ophp`. Pro
přímé použití z terminálu přidejte cestu `~/.composer/vendor/bin` do `PATH`.

## Přispívání překladů

Existující překlady si můžete prohlédnout
[zde](https://gitlab.com/vfosnar/ostraphp/-/blob/main/php/tokeny.csv). Dalším
překladům a případným opravám jsme otevřeni. Stačí vytvořit novou issue, PR,
nebo mě návrh [jakkoliv pošlete](https://vfosnar.cz/) ;)

## Vývoj

Transpilátor jako takový je jen pár řádků OstraPHP, zdrojový kód se nachází ve
složce `ostrava/`. Pro sestavení projektu slouží script `sestavit.sh`.
