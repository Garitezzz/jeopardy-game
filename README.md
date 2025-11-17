# 🎮 Jeopardy Game Management System

A full-featured, professional Jeopardy game application built with Laravel 11 and PHP. This system provides both an administrative dashboard for content management and an interactive game board for playing Jeopardy-style trivia games.

![Laravel](https://img.shields.io/badge/Laravel-11.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

## ✨ Features

### 🎯 Admin Panel (`/admin`)

- **Category Management**
  - Create, edit, delete, and reorder categories
  - Drag-and-drop functionality for custom ordering
  - Final Jeopardy category support
  
- **Question Management**
  - Full CRUD operations for questions
  - Rich media support:
    - Image uploads for questions and answers
    - Video attachments
    - Audio files
  - Point value customization
  - Category assignment
  
- **Data Management**
  - JSON export/import for easy backup
  - Bulk data operations
  - Statistics and overview dashboard

### 🎲 Game Board (`/`)

- **Authentic Jeopardy Design**
  - Classic blue tiles (#0200D4) with yellow text (#FFDD55)
  - Navy background with professional styling
  - Smooth animations and transitions
  
- **Interactive Gameplay**
  - Dynamic 6-column board generation
  - Modal-based question/answer system
  - Multimedia question support (images, videos, audio)
  - Sound effects (click and reveal sounds)
  - Persistent game state using LocalStorage

### 👥 4-Player Scoreboard

- Editable player names with persistence
- Live score tracking with manual +/- controls
- Active player highlighting
- Individual score management
- Reset functionality for scores and board

### 🎛️ Gameplay Controls

- Reset board to start new game
- Reset all player scores
- Overtime/Final Jeopardy button
- Quick access to admin panel
- Built-in rules display

## 🛠️ Technical Stack

- **Framework:** Laravel 11.x
- **Language:** PHP 8.2+
- **Database:** SQLite (easily switchable to MySQL/PostgreSQL)
- **Frontend:** Blade templates with vanilla JavaScript
- **Styling:** Custom CSS with responsive design
- **Storage:** File storage for media uploads
- **State Management:** Browser LocalStorage

## 📋 Requirements

- PHP >= 8.2
- Composer
- SQLite (or MySQL/PostgreSQL)
- Node.js & NPM (optional, for asset compilation)

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Garitezzz/jeopardy-game.git
   cd jeopardy-game
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   ```

5. **Create storage link**
   ```bash
   php artisan storage:link
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

7. **Access the application**
   - Game Board: http://localhost:8000
   - Admin Panel: http://localhost:8000/admin

## 📁 Project Structure

```
jeopardy-game/
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminController.php
│   │   ├── GameController.php
│   │   ├── CategoryController.php
│   │   └── QuestionController.php
│   └── Models/
│       ├── Category.php
│       ├── Question.php
│       ├── Game.php
│       ├── GameResponse.php
│       └── Settings.php
├── database/
│   └── migrations/
│       ├── 2024_01_01_000001_create_categories_table.php
│       ├── 2024_01_01_000002_create_questions_table.php
│       ├── 2024_01_01_000003_create_games_table.php
│       └── ...
├── resources/
│   └── views/
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── categories/
│       │   └── questions/
│       ├── game/
│       │   └── board.blade.php
│       └── layouts/
├── public/
│   └── sounds/
│       ├── click.wav
│       └── reveal.wav
└── routes/
    └── web.php
```

## 🎮 Usage

### Admin Panel

1. Navigate to `/admin`
2. Create categories for your game
3. Add questions with points, answers, and optional media
4. Reorder categories by dragging and dropping
5. Export your data as JSON for backup

### Playing the Game

1. Navigate to `/`
2. Edit player names by clicking on them
3. Click on any question tile to view the question
4. Click "Reveal Answer" to show the answer
5. Use +/- buttons to adjust player scores
6. Reset board or scores as needed

## 🎯 Perfect For

- Trivia nights and game shows
- Educational quiz games
- Corporate team building events
- Classroom learning activities
- Family game nights
- Virtual trivia competitions

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👤 Author

**Garitezzz**
- GitHub: [@Garitezzz](https://github.com/Garitezzz)
- Repository: [jeopardy-game](https://github.com/Garitezzz/jeopardy-game)

## 🙏 Acknowledgments

- Built with [Laravel](https://laravel.com) - The PHP Framework for Web Artisans
- Inspired by the classic Jeopardy! game show
- Sound effects for enhanced gameplay experience

---

