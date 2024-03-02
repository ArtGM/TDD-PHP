# UberTop SAAS!

L'application Uber-Like qui permet de réserver un Driver instantanément !

## Réservation de Course :
### Règles Générales :
Un Rider peut réserver une course à tout moment pour n'importe quelle destination.
La réservation est confirmée une fois qu'un Driver libre est assigné par le système.

## Tarification :
### Structure de prix :

- Prix de base :
    - Paris -> Paris : 2 euros
    - Extérieur de Paris -> Paris : 0 euro
    - Paris -> Extérieur de Paris : 10 euros
- Prix par kilomètre : 0.5 euro.
- Supplément UberX : +5 euros au total, mais offert le jour de l'anniversaire du Rider peu importe le nombre de courses.
- Jour (ou soirée) de Noël : Double du montant total.
- Offre de bienvenue : Avoir de 20 euros de réduction.

## Conditions de Réservation :
### Règles de Réservation :
- Le Rider doit avoir suffisamment de fonds sur son compte pour réserver une course.
- Si le Rider annule une course alors que le Driver est déjà en chemin, cela coûtera 5 euros de pénalité.
- Un ride déjà annulé ne peut être annulé à nouveau
- Si c'est l'anniversaire du Rider, alors l'annulation est offerte quelle que soit la raison.
- Tant qu'un Driver n'est pas assigné à une réservation en cours, le Rider ne peut pas effectuer une autre réservation.
  Si le Rider souhaite faire une autre réservation, il doit d'abord annuler la précédente.

# User Story - Réserver une course

En tant que **Rider**,

Je souhaite **réserver une course** pouvant m'amener à ma destination

De sorte à assurer une alternative efficace aux transports en commun.

# User Story - Annuler une course

En tant que **Rider**,

Je souhaite **annuler ma course**

Car le **Driver** met trop de temps à venir.

# User Story - Lister toutes mes courses passées

En tant que **Rider**,

Je souhaite **lister tout l'historique de mes courses avec mention des Drivers respectifs**

De sorte à pouvoir me figurer la fréquence de mon utilisation.
