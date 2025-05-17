# Challenge CTF - Bypass d'Authentification

Ce dépôt contient un challenge CTF simple axé sur le bypass d'authentification.

## Configuration et Déploiement

### Prérequis

- Docker et Docker Compose installés sur votre machine
- Traefik configuré comme reverse proxy (avec résolution DNS pour `*.makhal.fr`)
- Un réseau Docker nommé `traefik-network`

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

4. Accédez au challenge à l'URL : https://ctf.makhal.fr

### Sécurité

Cette configuration inclut plusieurs mesures de sécurité (hardening) :

#### Docker
- Principe du moindre privilège (drop all capabilities sauf NET_BIND_SERVICE)
- Container en mode lecture seule (read-only)
- Montage temporaire pour les fichiers volatils (/tmp, /var/run/apache2)
- Option no-new-privileges pour empêcher l'escalade de privilèges
- Montage des sources en lecture seule (ro)

#### PHP/Apache
- Paramètres PHP sécurisés (expose_php=Off, etc.)
- En-têtes de sécurité HTTP configurés
- Permissions de fichiers restreintes
- Exécution en tant qu'utilisateur non-root (www-data)

#### Traefik
- Redirection HTTP vers HTTPS
- En-têtes de sécurité (HSTS, XSS Protection, etc.)
- Limitation de débit (rate limiting) pour prévenir les attaques par force brute
- TLS avec Cloudflare comme résolveur de certificat

## Maintenance

Pour mettre à jour le challenge ou appliquer des modifications :

```bash
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

## Contenu du Challenge

Ce challenge CTF se concentre sur un bypass d'authentification simple. Le code source est disponible dans le dossier `src/`.

**Note** : Ce challenge est conçu à des fins éducatives uniquement. Le code contient des vulnérabilités intentionnelles.
