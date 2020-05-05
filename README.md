# Content Tools Manager

![GitHub issues](https://img.shields.io/github/issues/antoinebonin/ContentToolsManager?style=for-the-badge)
![GitHub All Releases](https://img.shields.io/github/downloads/antoinebonin/ContentToolsManager/total?style=for-the-badge)

## Utilisation

Pour rendre un élément editable, vous devez **absoluement** encadrer l'élément dans une div ou un span.

```html
<div class="wrapper" data-editable data-name="text">
    <p> Lorem ipsum </p>
</div>
```

Afin de rendre vraiment éditable et dynamique notre contenu, ajouter ces deux lignes de `php`.

_Cela rendera editable l'élément quand vous serez en mode édition sinon l'affichera simplement_

```php
<div <?php editable("text") ?>>
    <?php echo($fields['text']) ?>
</div>
```

## Roadmap

1.0 :  
- ✅ : Ajouter Content Tools  
- ✅ : Possibilité de changer d'image  
- [] : Ajouter un router
- 🚧 : Back-office 
    - [] : Sécurisation
    - [] : Modules :
        - [] : Gestion des pages
        - [] : Gestion des utilisateurs

2.0 :  
_Si vous avez des suggestions vous pouvez créer une issue avec votre demande_


## Auteurs

+ [Antoine Bonin](https://github.com/antoinebonin)
+ [Robin Oger](https://github.com/theBatKwak)

## Dépendance

+ [Content Tools](https://github.com/GetmeUK/ContentTools)


