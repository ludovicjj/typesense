Typesense:

La recette flex semble tout caser. Voir peut etre un probleme entre la valeur de la key d'api dans le docker-compose et la valeur donnée par la recette..?

Install:
```bash
composer require acseo/typesense-bundle
```

Register bundle:
```php
// config/bundles.php
return [
    ...
    ACSEO\TypesenseBundle\ACSEOTypesenseBundle::class => ['all' => true]
];
```

Add env vars :
```bash
#.env
TYPESENSE_URL=http://localhost:8108
TYPESENSE_KEY=123
```

Création du fichier de configuration:
```yaml
acseo_typesense:
    # Typesense host settings
    typesense:
        url: '%env(resolve:TYPESENSE_URL)%'
        key: '%env(resolve:TYPESENSE_KEY)%'

    # Collection settings
    collections:
        data:
            entity: 'App\Entity\Data'                   # Doctrine Entity class
            fields:
                id:                                     # Entity attribute name
                    name: id                            # Typesense attribute name
                    type: primary                       # Attribute type
                sortable_id:
                    entity_attribute: id                # Entity attribute name forced
                    name: sortable_id                   # Typesense field name
                    type: int32
                title:
                    name: title
                    type: string
                content:
                    name: content
                    type: string
                words:
                    name: words
                    type: string
            default_sorting_field: sortable_id          # Default sorting field. Must be int32 or float
```

La commande permet la connexion entre symfony et le server typesense (a besoin d'une mise à jour)
(Si rien ne fonctionne renomer acseo_typesense.yml en acseo_typesense.yaml , voir https://github.com/acseo/TypesenseBundle/issues/32)
```bash
# Creation collections structure
symfony console typesense:create
```

Creation de données pour ``entity: 'App\Entity\Data'`` dans la BDD
```bash
# load fixture
symfony console d:f:l
```

Import les data dans le server typesense
```bash
# Creation collections structure
symfony console typesense:import
```

Recuperer le "finder" dans le controller
```yaml
# config/services.yaml
services:
    App\Controller\SearchController:
        arguments:
            $dataFinder: '@typesense.finder.data' 
```