-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 05, 2023 at 05:57 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_book_store_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `full_name`, `email`, `password`, `role`) VALUES
(1, 'Việt Vũ', 'vietvu5555s@gmail.com', '$2y$10$un61Fygb6OmxOMr7kr4QcuJ9fbsA/zm1AdYzJw0qHtolq.Bt6yS22', 'admin'),
(2, 'Băng', 'icecraft2004@gmail.com', '$2y$10$IBgQp9eRS2Y7Su9lyrXOXOpD1vI966qcao0zSoa1l0N7tGfQIvob6', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL,
  `author_bio` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `name`, `user_id`, `author_bio`) VALUES
(1, 'Terry Pratchett', 1, 'Sir Terence David John Pratchett OBE (28 April 1948 – 12 March 2015) was an English author, humorist, and satirist, best known for his 41 comic fantasy novels set on the Discworld, and for the apocalyptic comedy novel Good Omens (1990) which he wrote with Neil Gaiman.'),
(5, 'Douglas Adams', 1, 'Douglas Noël Adams (11 March 1952 – 11 May 2001) was an English author, humorist, and screenwriter, best known for The Hitchhiker\'s Guide to the Galaxy (HHGTTG). Originally a 1978 BBC radio comedy, The Hitchhiker\'s Guide to the Galaxy developed into a \"trilogy\" of five books that sold more than 15 million copies in his lifetime. It was further developed into a television series, several stage plays, comics, a video game, and a 2005 feature film. Adams\'s contribution to UK radio is commemorated i');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author_id`, `description`, `category_id`, `cover`, `file`, `user_id`) VALUES
(3, 'The Colour of Magic', 1, 'In a world supported on the back of a giant turtle (sex unknown), a gleeful, explosive, wickedly eccentric expedition sets out. There\'s an avaricious but inept wizard, a naive tourist whose luggage moves on hundreds of dear little legs, dragons who only exist if you believe in them, and of course THE EDGE of the planet...', 1, '65564486381654.17696264.jpg', '65564486383066.03405039.pdf', 1),
(4, 'Guards! Guards!', 1, 'This is where the dragons went. They lie... not dead, not asleep, but... dormant. And although the space they occupy isn\'t like normal space, nevertheless they are packed in tightly. They could put you in mind of a can of sardines, if you thought sardines were huge and scaly. And presumably, somewhere, there\'s a key...', 1, '655644e9b54ce1.30419103.jpg', '655644e9b56ff6.51719572.pdf', 2);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Fantasy'),
(2, 'Science Fiction');

-- --------------------------------------------------------

--
-- Table structure for table `favorite_author`
--

CREATE TABLE `favorite_author` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorite_book`
--

CREATE TABLE `favorite_book` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorite_author`
--
ALTER TABLE `favorite_author`
  ADD PRIMARY KEY (`id`,`user_id`,`author_id`),
  ADD KEY `user_id` (`user_id`,`author_id`),
  ADD KEY `userlibrary_ibkf_6` (`author_id`);

--
-- Indexes for table `favorite_book`
--
ALTER TABLE `favorite_book`
  ADD PRIMARY KEY (`id`,`user_id`,`book_id`),
  ADD KEY `user_id` (`user_id`,`book_id`),
  ADD KEY `userlibrary_ibkf_4` (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `favorite_author`
--
ALTER TABLE `favorite_author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorite_book`
--
ALTER TABLE `favorite_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `authors`
--
ALTER TABLE `authors`
  ADD CONSTRAINT `userlibrary_ibkf_2` FOREIGN KEY (`user_id`) REFERENCES `admin` (`id`);

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `userlibrary_ibkf_7` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `userlibrary_ibkf_8` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`);

--
-- Constraints for table `favorite_author`
--
ALTER TABLE `favorite_author`
  ADD CONSTRAINT `userlibrary_ibkf_5` FOREIGN KEY (`user_id`) REFERENCES `admin` (`id`),
  ADD CONSTRAINT `userlibrary_ibkf_6` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`);

--
-- Constraints for table `favorite_book`
--
ALTER TABLE `favorite_book`
  ADD CONSTRAINT `userlibrary_ibkf_3` FOREIGN KEY (`user_id`) REFERENCES `admin` (`id`),
  ADD CONSTRAINT `userlibrary_ibkf_4` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
