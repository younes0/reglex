# Reglex

Extracteur de normes juridiques depuis une chaîne de caractères

## Introduction

Librairie PHP developpée dans le cadre de la thèse d'[Emma Grego](mailto:grego.emma@yahoo.fr)

Les expressions regulières sont générées grâce à [RegExpBuilder](https://github.com/gherkins/regexpbuilderphp) qui permet de réutiliser plus facilement certaines règles et surtout, sont beaucoup plus lisibles pour les non-développeurs. Une [version Javascript](https://github.com/thebinarysearchtree/regexpbuilderjs) de la librairie existe aussi.

**En cours de développement, BC fortement possibles**

## Exemples

```php
// avis
// ---------------------------
$a = (new Base)->avis('
    l\'avis de la Assemblée territoriale de la Polynésie française en date du 25 novembre 1993 
    l\'avis de la Commission nationale de l\'informatique et des libertés inséré au Journal officiel de la République française 
');

echo($a['institution'][0]); // 'Assemblée territoriale de la Polynésie française'
echo($a['date'][1]); // '25 novembre 1993'

echo($a['institution'][1]); // 'Commission nationale de l\'informatique et des libertés);

// directives européennes
// ---------------------------
$a = (new Base)->directiveUe('
    la directive 2003/54/CE 
    la directive 23/54/CE 
');

echo($a['numero'][0]); // '2003/54/CE'
echo($a['numero'][1]); // '23/54/CE'
```

Plus d'exemples dans les Tests.

## Installation

ajout repo composer.json:
```json
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:younes0/regexpbuilderphp.git"
    }
],
```
puis `composer require younes0/reglex`

## TODO

- [ ] Commentaires
- [ ] Gérer articles (art. 8 de la loi machin-truc)
- [ ] Gérer déclinaison numéros multiples (nos 14, 15 et 18)
- [ ] Formater differement la sortie des méthodes (`$array[0]['numero']` au lieu de `$array['numero'][0]`)
- [ ] Plus de déclinaisons concernant les conventions, traités etc.
