# Reglex

Extracteur de normes juridiques dans un texte.  
Librairie PHP developpée dans le cadre de la thèse d'[Emma Grego](mailto:grego.emma@yahoo.fr)

Les expressions regulières sont générées grâce à [RegExpBuilder](https://github.com/gherkins/regexpbuilderphp) qui permet de réutiliser plus facilement certaines règles et surtout, sont beaucoup plus lisibles pour les non-développeurs.

**En cours de développement, BC fortement possibles**

## Exemples

```php
$v = $this->base->avis('
    l\'avis de la Assemblée territoriale de la Polynésie française en date du 25 novembre 1993 
    l\'avis de la Commission nationale de l\'informatique et des libertés 
    avis du Président de l\'Assemblée nationale inséré au Journal officiel de la République française du 16 mars 2007
');
// ldd($v);
        $this->assertEquals($v['institution'][0], 'Assemblée territoriale de la Polynésie française');
        $this->assertEquals($v['date'][0], '25 novembre 1993');

// directives européennes
$a = $this->base->directiveUe('
    la directive 2003/54/CE 
    la directive 23/54/CE 
');

echo($a['numero'][0]); // '2003/54/CE'
echo($a['numero'][1]); // '23/54/CE'
```

## TODO

- [ ] Gérer articles (art. 8 de la loi machin-truc)
- [ ] Gérer déclinaison numéros multiples (nos 14, 15 et 18)
- [ ] Formater differement la sortie des méthodes (`$array[0]['numero']` au lieu de `$array['numero'][0]`)
- [ ] Plus de déclinaisons concernant les conventions, traités etc.
