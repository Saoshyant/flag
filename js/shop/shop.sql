-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2022 at 05:37 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(40) NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `parent_id`) VALUES
(1, 'Sofás', 0),
(2, 'Sofás modulares', 1),
(3, 'Sofás-cama', 1),
(4, 'Camas e colchões', 0),
(5, 'Colchões', 4),
(6, 'Camas', 4),
(7, 'Bebés e crianças', 0),
(8, 'Crianças', 7);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `code` char(2) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`code`, `name`) VALUES
('ao', 'Angola'),
('br', 'Brasil'),
('de', 'Alemanha'),
('es', 'Espanha'),
('fr', 'França'),
('pt', 'Portugal');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` smallint(5) UNSIGNED NOT NULL,
  `price_each` decimal(12,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`order_id`, `product_id`, `quantity`, `price_each`) VALUES
(1, 3, 3, '109.00'),
(1, 4, 2, '579.00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_date` timestamp NULL DEFAULT NULL,
  `shipment_date` timestamp NULL DEFAULT NULL,
  `is_canceled` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `payment_date`, `shipment_date`, `is_canceled`) VALUES
(1, 2, '2021-10-15 19:05:22', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(12,2) UNSIGNED NOT NULL,
  `stock` smallint(6) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `stock`, `image`, `category_id`) VALUES
(1, 'HAUGA', '<p>Estrutura de cama acolchoada, Vissle cinz160x200 cm</p>\n<p>Esta estrutura de cama acolchoada leva aconchego e suavidade para o seu quarto. O tecido duradouro em dois tons, a cabeceira ligeiramente curva e os rebordos com vivos criam uma expressão clássica que vai apreciar durante muitos anos.</p>', '179.00', 5, 'hauga-estrutura-de-cama-acolchoada-vissle-cinz__0789232_pe764315_s5.webp', 6),
(2, 'MALM', '<p>Estr. cama alta c/2 cx arrumação, branco/Luröy140x200 cm</p>\r\n<p>Tem um design simples e bonito de todos os lados, para poder ser colocada de forma independente ou com uma cabeceira de cama, contra uma parede. Também inclui caixas de arrumação espaçosas que deslizam suavemente sobre rodízios.</p>', '226.00', 20, 'malm-estr-cama-alta-c-2-cx-arrumacao-branco-luroey__0638626_pe699044_s5.webp', 6),
(3, 'HAFSLO', '<p>Colchão de molas, firme/bege140x200 cm</p>\r\n<p>Uma boa escolha para quem gosta da sensação de dormir sobre o colchão sem afundar. O peso é distribuído uniformemente, proporcionando apoio a todo o corpo.</p>', '109.00', 7, 'hafslo-colchao-de-molas-firme-bege__0210689_pe364271_s5.webp', 5),
(4, 'KIVIK', '<p>Sofá 4 lugares, c/chaise longue/Orrsta cinz clr</p>\r\n<p>Aconchegue-se no confortável sofá KIVIK. O tamanho generoso, os braços rebaixados e a espuma memory que se adapta aos contornos do seu corpo convidam a muitas horas de sestas, convívio e descontração.</p>', '579.00', 18, 'kivik-sofa-4-lugares-c-chaise-longue-orrsta-cinz-clr__0249488_pe387760_s5.webp', 2),
(5, 'FRIHETEN', '<p>Sofá-cama de canto c/arrumação, Skiftebo azul</p>\r\n<p>Depois de uma boa noite de sono, facilmente transforma novamente o seu quarto ou o quarto de hóspedes na sala. A acessível arrumação integrada tem espaço suficiente para guardar roupa de cama, livros e pijamas.</p>', '379.00', 89, 'friheten-sofa-cama-de-canto-c-arrumacao-skiftebo-azul__0690243_pe723167_s5.webp', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(252) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(120) NOT NULL,
  `city` varchar(40) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `country` char(2) NOT NULL,
  `vat_code` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `address`, `city`, `postal_code`, `country`, `vat_code`) VALUES
(2, 'Ivo', 'just@ivo.fyi', '$2y$10$DnLXlHtuaC6lJJkTosxMpuHQTNKP9S3mcSj7lfJ61LtQzj9oRiTQK', 'Rua aqui e acolá e tal', 'Algures', '9389', 'pt', '123456789');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`order_id`,`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
