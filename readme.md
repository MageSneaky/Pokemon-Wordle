
# Pokémon Wordle
<p align="center">
  <a href="https://sneaky.pink">
    <img src="https://sneaky.pink/images/pokemonwordlebanner.png"></a>
</p>
<p align="center">
<a href="https://github.com/MageSneaky/pokemon-wordle"><img alt="Pokémon Wordle" src="https://img.shields.io/github/repo-size/MageSneaky/pokemon-wordle?color=pink&label=Repo%20Size&logo=github&style=flat-square"></a>
<a href="https://sneaky.pink"><img alt="Website" src="https://img.shields.io/website?down_color=pink down_message=sneaky.pink&label=Website&up_color=pink&up_message=sneaky.pink&url=https%3A%2F%2Fsneaky.pink"></a>
</p>

<details>
  <summary>Table of Contents</summary>
  <ol>
    <li><a href="#about">About</a></li>
    <li><a href="#demo">Demo</a></li>
    <li><a href="#self-host">Self-Host</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#technologies-used">Technologies Used</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>

## About
Welcome to [Pokémon Wordle](https://pokemon.sneaky.pink), a web-based word-guessing game where players try to guess the name of a Pokémon. Inspired by the popular Wordle game, this version adds a fun Pokémon twist. Pokémon Wordle is built with HTML, CSS, JavaScript, jQuery, and PHP.

### Demo
[Live Demo](https://pokemon.sneaky.pink)

### Self-Host
#### Prerequisites
To run Pokémon Wordle locally, you will need:
- A local server setup (e.g., XAMPP, MAMP, nginx, or WAMP) to support PHP.
- MySQL server
- Basic knowledge of HTML, CSS, JavaScript, Node.js, and PHP.

#### Installation
1. Clone the repository:
```
git clone https://github.com/MageSneaky/pokemon-wordle.git
```

2. Configuration
- Rename ``.env.example`` to ``.env``.
- Rename ``config.sample.php`` to ``config.php``.

3. Create Discord Application
- Go to [Discord's Developer Portal](https://discord.com/developers/applications) to create a new Application (or use an existing one).
- Copy client ID and client secret into ``config.php``.
- Set up a redirect URI to ``http://locahost/login`` (or adjust based on your server setup).

4. Database setup:
- Import ``database.sql`` from the project folder into your MySQL database.
- Update the database credentials in ``config.php`` and ``.env`` to match your database setup.

5. Set up backend server:
- Navigate to the ``backend`` folder and run ```node .``` to start the backend server and populate necessary database entries.

6. Set up local server:
- Place the ``web`` folder inside your server's root directory.
- Start your server.

7. Run the Game:
- Access the game at ``http://localhost`` (or the corresponding URL based on your server setup).

### Roadmap
- [ ] Minor features/fixes
   - [ ] Tab auto-complete
   - [ ] Support for Japanese Pokémon names
- [ ] Replay system
- [ ] User profile page
- [ ] "How to play" guide
- [ ] Weekly challenges/Events

### Contributing
Contributions are welcome! Please follow these steps:
1. Fork the project.
2. Create your feature branch: git checkout -b feature/new-feature.
3. Commit your changes: git commit -m 'Add new feature'.
4. Push to the branch: git push origin feature/new-feature.
5. Open a pull request.
For simpler issues or suggestions, create an issue [here](https://github.com/MageSneaky/pokemon-wordle/issues).

### Technologies Used
- Frontend: HTML, CSS, JavaScript, jQuery
- Backend: PHP, MySQL, Node.js (for managing Pokémon data, users, and leaderboards)
- Other: AJAX for asynchronous data fetching, nginx as the web server
- Font: [Montserrat](https://fonts.google.com/specimen/Montserrat)

### Acknowledgments
- Thanks to [PokeAPI](https://pokeapi.co/) for providing Pokémon data.
- [Discord OAuth](https://github.com/MarkisDev/discordoauth) for OAuth setup examples.
- Inspired by the original Wordle game concept.