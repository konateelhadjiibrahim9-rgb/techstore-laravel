# Guide d'Installation CinetPay pour TechStore

## Qu'est-ce que CinetPay ?

CinetPay est une passerelle de paiement africaine qui permet d'accepter les paiements Mobile Money (Wave, Orange Money, MTN Mobile Money) et cartes bancaires dans plusieurs pays africains, y compris la Côte d'Ivoire.

## Étape 1 : Créer un compte CinetPay

1. **Inscription**
   - Rendez-vous sur [https://www.cinetpay.com](https://www.cinetpay.com)
   - Cliquez sur "S'inscrire" ou "Register"
   - Remplissez le formulaire d'inscription avec vos informations professionnelles
   - Validez votre email et votre numéro de téléphone

2. **Vérification du compte**
   - Téléchargez et soumettez les documents requis (pièce d'identité, documents d'entreprise)
   - Attendez la validation de votre compte (peut prendre 24-48h)

## Étape 2 : Obtenir les clés API (Sandbox/Test)

1. **Accéder au Dashboard**
   - Connectez-vous à votre compte CinetPay
   - Accédez au "Dashboard" ou "Tableau de bord"

2. **Créer un site de test**
   - Allez dans la section "Sites" ou "Mes sites"
   - Cliquez sur "Ajouter un site" ou "Add new site"
   - Remplissez les informations :
     - **Nom du site** : TechStore (ou votre nom)
     - **URL du site** : `http://localhost:8000` (pour le développement local)
     - **URL de retour (Return URL)** : `http://localhost:8000/payment/callback`
     - **URL de notification (Notify URL)** : `http://localhost:8000/payment/notify`
     - **Devise** : XOF (Franc CFA)
   - Sélectionnez "Mode Test" ou "Sandbox"

3. **Récupérer les clés API**
   - Une fois le site créé, vous verrez vos clés :
     - **API Key** : Clé secrète pour l'authentification API
     - **Site ID** : Identifiant unique de votre site
   - Copiez ces deux valeurs

## Étape 3 : Configurer le projet Laravel

1. **Ajouter les variables d'environnement**
   - Ouvrez le fichier `.env` dans votre projet Laravel
   - Ajoutez les lignes suivantes :

```env
CINETPAY_API_KEY=votre_api_key_ici
CINETPAY_SITE_ID=votre_site_id_ici
CINETPAY_MODE=sandbox
```

2. **Tester la configuration**
   - Les clés sandbox sont gratuites et permettent de tester les paiements
   - Vous pouvez simuler des paiements Wave, Orange Money, MTN sans argent réel

## Étape 4 : Passer en Production

Une fois votre site prêt pour la production :

1. **Créer un site de production**
   - Dans le dashboard CinetPay, créez un nouveau site en mode "Production"
   - Utilisez l'URL réelle de votre site (ex: `https://votre-site.com`)
   - Mettez à jour les URLs de retour et notification

2. **Mettre à jour les variables d'environnement**
   - Remplacez les clés sandbox par les clés production
   - Changez `CINETPAY_MODE=sandbox` par `CINETPAY_MODE=production`

## Étape 5 : Tester le paiement

1. **Faire un achat de test**
   - Ajoutez des produits au panier
   - Allez à la page de paiement
   - Sélectionnez "Payer avec CinetPay"
   - Vous serez redirigé vers la page de paiement CinetPay

2. **Simuler un paiement**
   - En mode sandbox, vous pouvez simuler différents scénarios :
     - Paiement réussi
     - Paiement échoué
     - Paiement annulé
   - Testez avec différents opérateurs (Wave, Orange Money, MTN)

## Support et Documentation

- **Documentation officielle** : [https://docs.cinetpay.com](https://docs.cinetpay.com)
- **Support client** : support@cinetpay.com
- **Téléphone** : +225 27 22 48 10 10 (Côte d'Ivoire)

## Notes importantes

- Les clés API doivent rester confidentielles
- Ne commitez jamais vos clés API dans GitHub
- Utilisez toujours le mode sandbox pour les tests
- Le mode sandbox ne nécessite pas de fonds réels
- Les commissions CinetPay s'appliquent uniquement en production (environ 1-2% selon le moyen de paiement)

## Méthodes de paiement supportées

- **Wave** : Très populaire en Côte d'Ivoire
- **Orange Money** : Disponible dans plusieurs pays africains
- **MTN Mobile Money** : Large couverture en Afrique
- **Cartes bancaires** : Visa, Mastercard
- **Moov Money** : Disponible en Côte d'Ivoire

## Sécurité

- Utilisez HTTPS en production
- Validez toujours les signatures de notification
- Implémentez des vérifications de sécurité côté serveur
- Surveillez les transactions suspectes
