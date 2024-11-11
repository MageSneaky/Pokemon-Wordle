CREATE DATABASE IF NOT EXISTS `pokemonwordle` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `pokemonwordle`;

CREATE TABLE `games` (
  `id` int NOT NULL,
  `gameid` varchar(10) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `pokemon` json NOT NULL,
  `finished` int DEFAULT '0',
  `guessesCount` int NOT NULL DEFAULT '0',
  `hints` int DEFAULT '0',
  `ranked` int NOT NULL DEFAULT '0',
  `startDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `pokemons` (
  `id` int NOT NULL,
  `pokedex` int NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `generation` varchar(100) NOT NULL,
  `sprite` varchar(255) NOT NULL,
  `types` json NOT NULL,
  `color` varchar(100) NOT NULL,
  `habitat` varchar(100) DEFAULT NULL,
  `shape` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `users` (
  `id` int NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `username` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_avatar` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gameid` (`gameid`);

ALTER TABLE `pokemons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `user_name` (`username`);

ALTER TABLE `games`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

ALTER TABLE `pokemons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2032;

ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;