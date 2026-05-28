# Configuration CI/CD - GitHub Actions

## 📋 Secrets GitHub à Configurer

Pour que le pipeline fonctionne, vous devez configurer les secrets suivants dans votre repository GitHub :

1. **SSH_PRIVATE_KEY**
   - Clé privée SSH pour se connecter à votre serveur
   - Génération : `ssh-keygen -t rsa -b 4096 -C "github-actions"`
   - Copiez le contenu de `~/.ssh/id_rsa`

2. **SERVER_HOST**
   - Adresse IP ou nom de domaine de votre serveur
   - Exemple : `192.168.1.100` ou `votre-serveur.com`

3. **SSH_USER**
   - Nom d'utilisateur SSH sur votre serveur
   - Exemple : `root` ou `ubuntu`

4. **APP_URL**
   - URL de votre application déployée
   - Exemple : `https://techstore.ci`

---

## 🔧 Configuration des Secrets GitHub

### Étape 1 : Générer une paire de clés SSH

```bash
# Sur votre machine locale
ssh-keygen -t rsa -b 4096 -C "github-actions" -f ~/.ssh/github_actions_key
```

### Étape 2 : Ajouter la clé publique à votre serveur

```bash
# Copier la clé publique sur le serveur
ssh-copy-id -i ~/.ssh/github_actions_key.pub user@votre-serveur.com

# Ou manuellement :
cat ~/.ssh/github_actions_key.pub | ssh user@votre-serveur.com "mkdir -p ~/.ssh && cat >> ~/.ssh/authorized_keys"
```

### Étape 3 : Configurer les secrets dans GitHub

1. Allez sur votre repository GitHub
2. Cliquez sur **Settings** → **Secrets and variables** → **Actions**
3. Cliquez sur **New repository secret**
4. Ajoutez chaque secret :
   - **Name** : `SSH_PRIVATE_KEY`
   - **Secret** : contenu de `~/.ssh/github_actions_key` (clé privée)
   - **Name** : `SERVER_HOST`
   - **Secret** : adresse IP de votre serveur
   - **Name** : `SSH_USER`
   - **Secret** : nom d'utilisateur SSH
   - **Name** : `APP_URL`
   - **Secret** : URL de votre application

---

## 🚀 Configuration du Serveur

### Étape 1 : Installer Docker et Docker Compose

```bash
# Sur votre serveur
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo usermod -aG docker $USER

# Installer Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
```

### Étape 2 : Cloner le repository sur le serveur

```bash
cd /path/to/your/projects
git clone https://github.com/konateelhadjiibrahim9-rgb/techstore-laravel.git
cd techstore-laravel
```

### Étape 3 : Configurer l'environnement

```bash
cp .env.example .env
nano .env
# Configurez vos variables d'environnement
```

### Étape 4 : Lancer les conteneurs

```bash
docker compose up -d
```

---

## 🔄 Workflow du Pipeline

### Étape CI (Tests) :
1. Checkout du code
2. Setup PHP 8.4
3. Installation Composer
4. Setup Node.js 20
5. Installation NPM
6. Build assets
7. Migrations de base de données
8. Exécution des tests PHPUnit

### Étape CD (Déploiement) :
1. Seulement sur `push` vers `main`
2. Si tests réussis
3. Setup SSH
4. Ajout serveur aux known_hosts
5. Déploiement via SSH :
   - Git pull
   - Composer install (production)
   - NPM install + build
   - Migrations
   - Clear caches
   - Docker compose pull + up -d
6. Health check

---

## 🛡️ Sécurité

- La clé SSH privée est stockée dans les secrets GitHub (jamais exposée)
- Le déploiement ne se fait que sur la branche `main`
- Les tests doivent passer avant déploiement
- Health check après déploiement

---

## 📝 Personnalisation

### Modifier le chemin du projet sur le serveur

Dans le fichier `.github/workflows/deploy.yml`, modifiez :

```yaml
ssh ${{ secrets.SSH_USER }}@${{ secrets.SERVER_HOST }} << 'EOF'
  cd /path/to/techstore  # ← Changez ce chemin
  # ... reste du script
EOF
```

### Modifier les commandes Docker

Si vous utilisez `docker-compose` au lieu de `docker compose` :

```yaml
docker-compose pull
docker-compose up -d
```

---

## 🔍 Débogage

### Voir les logs du workflow

1. Allez sur GitHub → Actions
2. Cliquez sur le workflow en cours
3. Cliquez sur chaque étape pour voir les logs

### Tester localement

```bash
# Activer Actions localement
act push
```

---

## ✅ Vérification

Après configuration, vérifiez :

1. ✅ Secrets GitHub configurés
2. ✅ Clé SSH ajoutée au serveur
3. ✅ Docker installé sur serveur
4. ✅ Repository cloné sur serveur
5. ✅ `.env` configuré sur serveur
6. ✅ Conteneurs Docker fonctionnels

Push sur `main` pour déclencher le pipeline !
