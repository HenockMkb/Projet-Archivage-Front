# 📁 e-Archive - Plateforme d'Archivage Électronique

## 📖 Description du projet

**e-Archive** est une plateforme web de gestion du processus d'archivage électronique développée pour le **Secrétariat Général aux Infrastructures et Travaux Publics (SGITP)** de la République Démocratique du Congo, plus précisément pour la **Direction des Archives et des Nouvelles Technologies de l'Information et de la Communication (DANTIC)**.

Cette application permet à différentes catégories d'utilisateurs (administrateurs, archivistes, contributeurs, lecteurs) de **consulter, rechercher, importer et gérer des documents numériques** de manière intuitive et sécurisée.

## 🎯 Objectifs

- ✅ **Interface utilisateur moderne** et professionnelle
- ✅ **Design responsive** compatible desktop et mobile
- ✅ **Gestion complète du cycle de vie** des documents
- ✅ **Workflow de validation** automatisé
- ✅ **Recherche avancée** avec filtres multiples
- ✅ **Sécurité et traçabilité** des opérations
- ✅ **Architecture modulaire** pour faciliter la maintenance

## 🛠 Technologies utilisées

- **Frontend** : HTML5, CSS3, JavaScript (ES6+)
- **Framework CSS** : Tailwind CSS
- **Icônes** : Font Awesome 6
- **Police** : Inter (Google Fonts)
- **Architecture** : Modulaire avec composants réutilisables

## 📁 Structure du projet

```
/front/
├── assets/
│   ├── css/
│   │   └── main.css          # Styles principaux avec Tailwind
│   ├── js/
│   │   └── app.js            # Logique JavaScript principale
│   └── img/                  # Images et ressources
├── admin/
│   ├── users.html            # Gestion des utilisateurs
│   └── roles.html            # Gestion des rôles
├── index.html                # Tableau de bord
├── login.html                # Page de connexion
├── upload.html               # Import de documents
├── inbox.html                # File d'attente
├── documents.html            # Liste des documents
├── collections.html          # Gestion des collections
├── search.html               # Recherche avancée
├── workflows.html            # Gestion des workflows
├── reports.html              # Rapports et statistiques
├── settings.html             # Paramètres
├── help.html                 # Documentation
├── 404.html                  # Page d'erreur 404
├── 500.html                  # Page d'erreur 500
└── README.md                 # Documentation du projet
```

## 🚀 Installation et démarrage

### Prérequis

- Un navigateur web moderne (Chrome, Firefox, Safari, Edge)
- Serveur web local (optionnel, pour le développement)

### Installation rapide

1. **Cloner le repository**
   ```bash
   git clone https://github.com/votre-username/Projet-Archivage-Front.git
   cd Projet-Archivage-Front
   ```

2. **Ouvrir le projet**
   - Double-cliquer sur `index.html` pour ouvrir dans le navigateur
   - Ou utiliser un serveur local pour un meilleur développement

### Serveur local (recommandé)

#### Avec Python
```bash
# Python 3
python -m http.server 8000

# Python 2
python -m SimpleHTTPServer 8000
```

#### Avec Node.js
```bash
# Installer serve globalement
npm install -g serve

# Lancer le serveur
serve -s . -p 8000
```

#### Avec PHP
```bash
php -S localhost:8000
```

3. **Accéder à l'application**
   - Ouvrir votre navigateur
   - Aller à `http://localhost:8000`
   - Commencer par la page de connexion : `http://localhost:8000/login.html`

## 👥 Rôles utilisateurs

### 🔐 Administrateur
- Gestion complète des utilisateurs et rôles
- Configuration du système
- Accès à tous les modules

### 📋 Archiviste
- Validation des documents
- Gestion des collections
- Traitement de la file d'attente

### 📤 Contributeur
- Import de documents
- Consultation de ses propres documents
- Recherche dans l'archive

### 👁 Lecteur
- Consultation des documents publics
- Recherche limitée
- Pas d'actions de modification

## 📱 Fonctionnalités principales

### 🔐 Authentification
- Connexion sécurisée avec email/mot de passe
- Support LDAP (pour l'intégration future)
- Gestion des sessions

### 📤 Import de documents
- Interface drag & drop moderne
- Support de multiples formats (PDF, DOC, XLS, images, etc.)
- Métadonnées enrichies
- Validation automatique des formats

### 📋 File d'attente
- Gestion des documents en attente de validation
- Actions en lot (validation/rejet multiple)
- Filtres et recherche avancée
- Notifications en temps réel

### 📁 Gestion des documents
- Consultation et prévisualisation
- Métadonnées complètes
- Historique des modifications
- Export et partage

### 🔍 Recherche avancée
- Recherche plein texte
- Filtres par type, date, collection
- Recherche sémantique
- Sauvegarde des recherches

### 📊 Rapports et statistiques
- Tableaux de bord interactifs
- Statistiques d'utilisation
- Rapports d'audit
- Export des données

## 🎨 Design et UX

### 🎯 Principes de design
- **Interface claire** et intuitive
- **Navigation cohérente** entre les pages
- **Responsive design** pour tous les écrans
- **Accessibilité** conforme aux standards WCAG
- **Performance** optimisée

### 🎨 Palette de couleurs
- **Primaire** : Bleu (#1e40af) - Confiance et professionnalisme
- **Secondaire** : Gris (#64748b) - Neutralité et équilibre
- **Accent** : Orange (#f59e0b) - Attention et action
- **Succès** : Vert (#10b981) - Validation et progression
- **Erreur** : Rouge (#ef4444) - Alertes et erreurs

### 📱 Responsive design
- **Desktop** : Interface complète avec sidebar
- **Tablet** : Adaptation de la navigation
- **Mobile** : Interface optimisée tactile

## 🔧 Configuration

### Variables CSS personnalisées
Le fichier `assets/css/main.css` contient des variables CSS pour personnaliser facilement l'apparence :

```css
:root {
  --primary-color: #1e40af;
  --secondary-color: #64748b;
  --accent-color: #f59e0b;
  --success-color: #10b981;
  --error-color: #ef4444;
  /* ... autres variables */
}
```

### Composants réutilisables
L'application utilise des classes CSS réutilisables :
- `.btn-primary`, `.btn-secondary`, etc.
- `.card`, `.form-input`, `.table`
- `.badge`, `.modal`, `.loading`

## 🔌 Intégration future

### API Backend
L'architecture est conçue pour s'intégrer facilement avec une API backend :

```javascript
// Exemple d'intégration API
class EArchiveAPI {
  async fetchDocuments() {
    const response = await fetch('/api/documents');
    return response.json();
  }
  
  async uploadDocument(formData) {
    const response = await fetch('/api/documents', {
      method: 'POST',
      body: formData
    });
    return response.json();
  }
}
```

### Base de données
- Support pour PostgreSQL, MySQL, MongoDB
- Schéma de données optimisé pour l'archivage
- Indexation pour la recherche rapide

### Sécurité
- Authentification JWT
- Chiffrement des données sensibles
- Audit trail complet
- Gestion des permissions granulaires

## 🧪 Tests

### Tests manuels
1. **Navigation** : Tester tous les liens et menus
2. **Formulaires** : Validation des champs requis
3. **Responsive** : Tester sur différents écrans
4. **Accessibilité** : Navigation au clavier, lecteurs d'écran

### Tests automatisés (à implémenter)
```bash
# Tests unitaires JavaScript
npm test

# Tests d'intégration
npm run test:integration

# Tests de performance
npm run test:performance
```

## 📈 Performance

### Optimisations actuelles
- **CSS optimisé** avec Tailwind
- **JavaScript modulaire** et léger
- **Images optimisées** et lazy loading
- **Cache navigateur** configuré

### Métriques cibles
- **Temps de chargement** < 2 secondes
- **Score Lighthouse** > 90
- **Accessibilité** 100%
- **SEO** optimisé

## 🚀 Déploiement

### Environnement de développement
```bash
# Serveur local
python -m http.server 8000
```

### Environnement de production
```bash
# Serveur web (Apache/Nginx)
# Configuration recommandée dans /docs/deployment.md
```

### Variables d'environnement
```bash
# .env
API_BASE_URL=https://api.e-archive.sgitp.cd
ENVIRONMENT=production
DEBUG=false
```

## 🤝 Contribution

### Guide de contribution
1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/nouvelle-fonctionnalite`)
3. Commit les changements (`git commit -am 'Ajout nouvelle fonctionnalité'`)
4. Push vers la branche (`git push origin feature/nouvelle-fonctionnalite`)
5. Créer une Pull Request

### Standards de code
- **HTML** : Sémantique et accessible
- **CSS** : BEM methodology avec Tailwind
- **JavaScript** : ES6+, modules, documentation JSDoc
- **Git** : Messages de commit conventionnels

## 📄 Licence

Ce projet est développé pour le **SGITP** de la République Démocratique du Congo.

## 📞 Support

### Contact
- **Équipe technique** : tech@sgitp.cd
- **Support utilisateur** : support@sgitp.cd
- **Documentation** : docs.e-archive.sgitp.cd

### Ressources
- **Documentation technique** : `/docs/`
- **Guide utilisateur** : `/docs/user-guide.md`
- **API Reference** : `/docs/api.md`

## 🔄 Changelog

### Version 1.0.0 (Décembre 2023)
- ✅ Interface utilisateur complète
- ✅ Système d'authentification
- ✅ Import et gestion de documents
- ✅ File d'attente et validation
- ✅ Recherche avancée
- ✅ Design responsive

### Prochaines versions
- 🔄 Intégration API backend
- 🔄 Notifications en temps réel
- 🔄 Workflow avancé
- 🔄 Rapports détaillés
- 🔄 Application mobile

---

**e-Archive** - Une solution moderne pour l'archivage électronique du SGITP 🇨🇩
