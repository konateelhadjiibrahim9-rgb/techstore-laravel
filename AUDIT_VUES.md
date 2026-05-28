# Audit Vues - Séparation Admin/Client

## 📋 Règles Architecturales

**Backend & Administration (Laravel)** : 100% PHP/Laravel
- Interfaces d'administration (Dashboard admin, gestion des devis, gestion des utilisateurs, logs)
- Code frontend Blade/HTML SEULEMENT pour besoins d'administration

**Frontend Client (Django)** : 100% Python/Django
- Interface client finale uniquement
- Communication avec backend Laravel pour récupérer les données

---

## 🔍 AUDIT VUES LARAVEL

### ✅ VUES ADMIN (À GARDER dans Laravel)

#### Dashboard Admin
- `resources/views/dashboard/admins.blade.php` → Gestion des administrateurs
- `resources/views/dashboard/deliveries.blade.php` → Gestion des livraisons
- `resources/views/dashboard/quotes.blade.php` → Gestion des devis (admin)

#### Livewire Admin
- `resources/views/livewire/admin/order-list.blade.php` → Liste commandes admin
- `resources/views/livewire/admin/product-form.blade.php` → Formulaire produit admin
- `resources/views/livewire/admin/product-list.blade.php` → Liste produits admin
- `resources/views/livewire/admin/quote-list.blade.php` → Liste devis admin

#### Layouts Admin
- `resources/views/layouts/admin.blade.php` → Layout admin
- `resources/views/layouts/sidebar.blade.php` → Sidebar admin

---

### ❌ VUES CLIENTS (À MIGRER vers Django)

#### Dashboard Client
- `resources/views/dashboard/index.blade.php` → Espace client (catégories, devis récents)

#### Pages Client
- `resources/views/cart.blade.php` → Panier
- `resources/views/profile.blade.php` → Profil utilisateur
- `resources/views/welcome.blade.php` → Page d'accueil
- `resources/views/order-confirmation.blade.php` → Confirmation commande

#### Livewire Client
- `resources/views/livewire/add-to-cart.blade.php` → Ajout panier
- `resources/views/livewire/cart-counter.blade.php` → Compteur panier
- `resources/views/livewire/checkout.blade.php` → Paiement
- `resources/views/livewire/order-history.blade.php` → Historique commandes
- `resources/views/livewire/shopping-cart.blade.php` → Panier
- `resources/views/livewire/toast-notification.blade.php` → Notifications

#### Livewire Auth (Client)
- `resources/views/livewire/pages/auth/login.blade.php` → Connexion
- `resources/views/livewire/pages/auth/register.blade.php` → Inscription
- `resources/views/livewire/pages/auth/forgot-password.blade.php` → Mot de passe oublié
- `resources/views/livewire/pages/auth/reset-password.blade.php` → Réinitialisation mot de passe
- `resources/views/livewire/pages/auth/verify-email.blade.php` → Vérification email
- `resources/views/livewire/pages/auth/confirm-password.blade.php` → Confirmation mot de passe

#### Livewire Profile (Client)
- `resources/views/livewire/profile/delete-user-form.blade.php` → Suppression compte
- `resources/views/livewire/profile/update-password-form.blade.php` → Mise à jour mot de passe

#### Layouts Client
- `resources/views/layouts/techstore.blade.php` → Layout client
- `resources/views/layouts/header.blade.php` → Header client
- `resources/views/layouts/footer.blade.php` → Footer client
- `resources/views/layouts/app.blade.php` → Layout application
- `resources/views/layouts/guest.blade.php` → Layout invité

#### Components Client
- `resources/views/components/product-card.blade.php` → Carte produit
- `resources/views/components/whatsapp-float.blade.php` → WhatsApp float
- `resources/views/components/quote-form.blade.php` → Formulaire devis
- `resources/views/components/category-filters.blade.php` → Filtres catégories
- `resources/views/components/action-message.blade.php` → Messages action
- `resources/views/components/application-logo.blade.php` → Logo application
- `resources/views/components/auth-session-status.blade.php` → Status session
- `resources/views/components/danger-button.blade.php` → Bouton danger
- `resources/views/components/dropdown-link.blade.php` → Lien dropdown
- `resources/views/components/dropdown.blade.php` → Dropdown
- `resources/views/components/input-error.blade.php` → Erreur input
- `resources/views/components/input-label.blade.php` → Label input
- `resources/views/components/modal.blade.php` → Modal
- `resources/views/components/nav-link.blade.php` → Lien navigation
- `resources/views/components/primary-button.blade.php` → Bouton primaire
- `resources/views/components/responsive-nav-link.blade.php` → Lien navigation responsive
- `resources/views/components/secondary-button.blade.php` → Bouton secondaire
- `resources/views/components/text-input.blade.php` → Input texte

---

## 🔍 AUDIT VUES DJANGO

### ✅ VUES CLIENT (À GARDER dans Django)

#### Pages Client
- `frontend/templates/shop/base.html` → Layout base
- `frontend/templates/shop/home.html` → Page d'accueil
- `frontend/templates/shop/products.html` → Liste produits
- `frontend/templates/shop/product_detail.html` → Détail produit
- `frontend/templates/shop/cart.html` → Panier
- `frontend/templates/shop/order_success.html` → Confirmation commande
- `frontend/templates/shop/quote_form.html` → Formulaire devis
- `frontend/templates/shop/quote_success.html` → Confirmation devis

---

### ❌ INTERFACES ADMIN (À MIGRER vers Laravel)

**Aucune interface admin détectée dans Django** ✅

---

## 📊 RÉSUMÉ MIGRATION

### Laravel → Django (Vues Clients)
**Total** : ~40 fichiers à migrer

### Django → Laravel (Interfaces Admin)
**Total** : 0 fichiers (déjà correct)

---

## 🎯 PLAN D'ACTION

### Phase 1 : Séparation Layouts Laravel
1. Créer layout admin spécifique (déjà existe : `layouts/admin.blade.php`)
2. Supprimer layout client de Laravel (`layouts/techstore.blade.php`)
3. Migrer layout client vers Django

### Phase 2 : Migration Vues Clients vers Django
1. Migrer pages principales (home, products, cart, profile)
2. Migrer composants réutilisables (product-card, whatsapp-float)
3. Migrer composants auth (login, register)
4. Migrer composants livewire client

### Phase 3 : Nettoyage Laravel
1. Supprimer toutes les vues clientes de Laravel
2. Ne garder que les vues admin
3. Mettre à jour routes pour pointer vers Django

### Phase 4 : Configuration Django
1. Configurer Django pour consommer APIs Laravel
2. Implémenter authentification via Laravel API
3. Tester communication Django ↔ Laravel

---

## 📝 NOTES

- Les vues admin Laravel sont déjà bien structurées
- Les vues Django sont déjà orientées client (correct)
- La migration principale concerne les vues clientes de Laravel vers Django
- Les composants Blade devront être convertis en Django template tags
