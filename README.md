# Challenge CTF - Le Système d'Authentification Abandonné

Ce dépôt contient un challenge CTF pour débutants axé sur l'exploitation d'une faille de logique dans un système d'authentification.

## Description du Challenge

Vous êtes face à un "Système d'Administration Sécurisé" qui a récemment mis à jour son protocole d'authentification. Votre mission est de trouver une façon de contourner ce système pour accéder au panneau d'administration et récupérer le flag.

**Difficulté**: Débutant à Intermédiaire

**Catégorie**: Web - Authentification

**Objectif**: Trouver une faille dans le système d'authentification qui vous permettra d'accéder au panneau d'administration sans connaître les identifiants valides.

## Indices

- Examinez attentivement le code source de la page
- Les commentaires peuvent contenir des informations importantes
- Les systèmes qui conservent d'anciennes méthodes d'authentification pour "compatibilité" sont souvent vulnérables

## Configuration et Déploiement

### Prérequis

- Docker et Docker Compose installés sur votre machine

### Installation

1. Clonez ce dépôt :
   ```bash
   git clone [url-du-repo]
   cd makhal-auth-bypass-challenge
   ```

2. Démarrez l'application :
   ```bash
   docker-compose up -d
   ```

3. Accédez au challenge à l'URL : http://localhost:8080

## Solution

Ne regardez pas cette section si vous souhaitez résoudre le challenge par vous-même !

<details>
  <summary>Cliquez pour révéler la solution</summary>
  
  La vulnérabilité réside dans l'utilisation d'une ancienne méthode d'authentification ("legacy") qui est encore présente dans le code mais n'est pas exposée dans l'interface utilisateur.
  
  Pour exploiter cette vulnérabilité :
  1. Examinez le code source de la page pour découvrir des commentaires mentionnant "legacy"
  2. Modifiez votre requête pour inclure un paramètre `auth_method=legacy`
  3. Utilisez le nom d'utilisateur "admin" (seule vérification effectuée par la méthode legacy)
  
  Exemple d'exploitation :
  ```
  POST /login.php HTTP/1.1
  Host: localhost:8080
  
  username=admin&auth_method=legacy
  ```
  
  Ou simplement modifier le formulaire dans la console du navigateur pour ajouter un champ caché :
  ```html
  <input type="hidden" name="auth_method" value="legacy">
  ```
  
  Puis se connecter avec le nom d'utilisateur "admin" (le mot de passe peut être n'importe quoi).
</details>

## Contenu du Challenge

Ce challenge CTF se concentre sur l'exploitation d'anciennes méthodes d'authentification laissées dans le code. Le code source est disponible dans le dossier `src/`.

**Note** : Ce challenge est conçu à des fins éducatives uniquement. Le code contient des vulnérabilités intentionnelles.
