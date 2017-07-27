# Reglex

Extracteur de normes juridiques situées dans un texte pour le droit français

## Introduction

Les expressions regulières sont générées grâce à [RegExpBuilder](https://github.com/gherkins/regexpbuilderphp) qui permet de réutiliser plus facilement certaines règles et surtout, sont beaucoup plus lisibles pour les non-développeurs. Une [version Javascript](https://github.com/thebinarysearchtree/regexpbuilderjs) de la librairie existe aussi.

**En cours de développement, BC fortement possibles**

## Exemples

```php
// avis
// ---------------------------
$base = new Base('
    l\'avis de la Assemblée territoriale de la Polynésie française en date du 25 novembre 1993 
    l\'avis de la Commission nationale de l\'informatique et des libertés inséré au Journal officiel de la République française 
');

$r = $base->avis();

echo($r[0]['institution']); // 'Assemblée territoriale de la Polynésie française'
echo($r[1]['date']); // '25 novembre 1993'
echo($r[1]['institution']); // 'Commission nationale de l\'informatique et des libertés);

// directives européennes
// ---------------------------
$base = new Base('
    la directive 2003/54/CE 
    la directive 23/54/CE 
');

$r = $base->directiveUe();

echo($r[0]['numero']); // '2003/54/CE'
echo($r[1]['id']); // '23/54/CE' , identifiant unique
```

Plus d'exemples dans les Tests.

## Installation

`composer require younes0/reglex`

## TODO

- [ ] Commentaires
- [ ] Gérer articles (art. 8 de la loi machin-truc)
- [ ] Gérer déclinaison numéros multiples (nos 14, 15 et 18)
- [ ] Plus de déclinaisons concernant les conventions, traités etc.
