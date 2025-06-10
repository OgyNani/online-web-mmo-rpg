# Text-Based MMO RPG Game

[![PHP](https://img.shields.io/badge/PHP-8.1-777BB4.svg?style=flat&logo=php)](https://php.net/)
[![Symfony](https://img.shields.io/badge/Symfony-6.x-000000.svg?style=flat&logo=symfony)](https://symfony.com/)
[![React](https://img.shields.io/badge/React-18.x-61DAFB.svg?style=flat&logo=react)](https://reactjs.org/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15-336791.svg?style=flat&logo=postgresql)](https://www.postgresql.org/)

A text-based MMO RPG game where players can embark on epic adventures, interact with other players, and explore a rich fantasy world through text-based interactions.

## 🎮 Game Features

- **Character Creation & Progression**
  - Unique character creation system
  - Multiple character classes and races
  - Experience and leveling system
  - Skills and abilities development

- **World Exploration**
  - Rich text-based world description
  - Multiple locations to explore
  - Dynamic events and encounters
  - Quest system

- **Social Features**
  - Real-time player interaction
  - Guilds and parties
  - Trading system
  - Chat system

- **Combat System**
  - Turn-based combat mechanics
  - PvE and PvP battles
  - Unique combat abilities
  - Strategic battle decisions

## 🛠 Tech Stack

### Backend
- **Framework**: Symfony 6.x
- **Language**: PHP 8.1
- **Database**: PostgreSQL
- **Authentication**: Session-based auth with role system
- **API**: RESTful API

### Frontend
- **Framework**: React 18.x
- **State Management**: Redux
- **Styling**: Tailwind CSS
- **Real-time Updates**: WebSocket

### Infrastructure
- **Version Control**: Git
- **CI/CD**: GitHub Actions
- **Hosting**: To be determined

## 🚀 Getting Started

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js and npm
- PostgreSQL

### Installation

1. Clone the repository:
```bash
git clone [repository-url]
cd TGGame
```

2. Install backend dependencies:
```bash
cd backend
composer install
```

3. Configure the database:
```bash
# Update .env with your PostgreSQL credentials
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

4. Install frontend dependencies:
```bash
cd ../frontend
npm install
```

5. Start the development servers:
```bash
# Backend (from backend directory)
php -S localhost:8000 -t public

# Frontend (from frontend directory)
npm start
```

## 📝 API Documentation

### Authentication Endpoints

- **POST** `/api/register`
  - Register a new user
  - Required fields: email, password, username

- **POST** `/api/login`
  - Authenticate user
  - Required fields: email, password

*More endpoints will be documented as they are developed*

## 🤝 Contributing

Contributions, issues, and feature requests are welcome! Feel free to check the issues page.

## 📜 License

This project is licensed under the MIT License - see the LICENSE file for details.
