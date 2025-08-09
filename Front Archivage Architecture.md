# 📁 Projet Front PHP — Plateforme d’Archivage Électronique

## 📖 Description du projet
Développer une application web de gestion du processus d’archivage électronique pour le Secrétariat Général aux Infrastructures et Travaux Publics (SGITP) de la République Démocratique du Congo, plus précisément pour la Direction des Archives et des Nouvelles Technologies de l’Information et de la Communication (DANTIC).

Ce projet correspond à l’interface utilisateur **(Front-end)** d’une plateforme d’archivage électronique, développée **en PHP/CSS/JS simple** (sans backend intégré pour l’instant).  
Il doit permettre à différentes catégories d’utilisateurs (administrateurs, archivistes, contributeurs, lecteurs) de **consulter, rechercher, importer et gérer des documents numériques** de manière intuitive et sécurisée.

L’objectif est de fournir :
- Une **structure claire de pages PHP** prêtes à connecter à une API backend ultérieurement.
- Un **design responsive et accessible** compatible desktop et mobile.
- Des **gabarits réutilisables** pour faciliter la maintenance.

Le projet est pensé **full statique** pour le moment (PHP/CSS/JS) avec possibilité d’ajouter un backend API plus tard.

---

## 🗂 Architecture des pages Front PHP

### Pages principales
| Page | Objectif | Composants clés |
|------|----------|-----------------|
| `index.php` | Tableau de bord (statistiques, derniers documents, alertes) | KPI cards, liste récente, actions rapides |
| `login.php` | Authentification utilisateur | Formulaire login |
| `upload.php` | Import de documents avec métadonnées | Dropzone drag & drop, formulaire métadonnées |
| `inbox.php` | File d’ingestion en attente de validation | Table filtrable |
| `validate.php` | Validation de documents par archiviste | Viewer + formulaire éditable |
| `documents.php` | Liste paginée des documents archivés | Table + actions |
| `document.php` | Détails et prévisualisation d’un document | Viewer PDF, métadonnées, audit |
| `collections.php` | Liste des dossiers/collections | Table ou vignettes |
| `collection.php` | Vue contenu d’un dossier | Arborescence + liste |
| `search.php` | Recherche avancée + filtres | Searchbar + facettes |
| `workflows.php` | Tableau des tâches/workflows | Kanban |
| `admin/users.php` | Gestion des utilisateurs | CRUD table |
| `admin/roles.php` | Gestion des rôles et permissions | CRUD table |
| `settings.php` | Paramètres et politiques de conservation | Formulaires |
| `reports.php` | Rapports et exports | Graphiques, tableaux |
| `help.php` | Documentation interne | Texte statique |
| `404.php` | Page non trouvée | Message erreur |
| `500.php` | Erreur serveur | Message erreur |

---

## 📁 Structure recommandée
```
/front/
  /assets/
    /css/
      main.css
      theme.css
    /js/
      app.js
    /img/
      logo.png
  index.php
  login.php
  upload.php
  inbox.php
  validate.php
  documents.php
  document.php
  collections.php
  collection.php
  search.php
  workflows.php
  admin/
    users.php
    roles.php
  settings.php
  reports.php
  help.php
  404.php
  500.php
```

---

## 🖌 Design & Accessibilité
- **Responsive** (Tailwind CSS)
- **Accessibilité WCAG** : labels sur formulaires, contrastes, navigation clavier
- **Layout commun** : header, sidebar, footer
- **Composants réutilisables** : cartes KPI, tableaux, formulaires, modals

---

## 🚀 Prochaines étapes
1. Création des fichiers PHP statiques selon cette architecture.
2. Application du style (Tailwind CSS).
3. Connexion future à une API REST pour rendre les pages dynamiques.
