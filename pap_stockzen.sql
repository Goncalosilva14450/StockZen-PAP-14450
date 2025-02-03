-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03-Fev-2025 às 23:43
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `pap_stockzen`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `activity_log`
--

CREATE TABLE `activity_log` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `log` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `alerts`
--

CREATE TABLE `alerts` (
  `alert_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `alert_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `stock_minimum` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `stock_quantity`, `created_at`, `stock_minimum`, `category_id`, `image_path`) VALUES
(6, 'Pano do Marco', 'Pano XXL Marco', 500.00, 0, '2025-01-14 10:07:09', NULL, 3, NULL),
(9, 'Toalha de Mesa ', 'Toalha de Mesa 100x100', 20.00, 0, '2025-01-28 21:07:49', NULL, 7, 'uploads/1738098469_shopping.webp'),
(10, 'Toalha de Mesa ', 'Toalha de Mesa 100x100', 10.00, 0, '2025-01-28 21:10:24', NULL, 7, 'uploads/1738098624_toalha de mesa 100x100.jfif'),
(11, 'Almofada ', 'Almofada Cor ', 5.00, 9, '2025-02-01 09:13:22', NULL, 4, 'uploads/1738401202_almofada.jfif'),
(12, 'Pano turco ', 'Pano ', 10.00, 7, '2025-02-03 21:36:18', NULL, 2, 'uploads/1738618578_transferir.jpg'),
(13, 'Pano turco ', 'Pano ', 10.00, 10, '2025-02-03 22:39:54', NULL, 2, 'uploads/1738622394_transferir.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Edredons', 'Coleção de edredons para cama, com diferentes tamanhos e materiais.', '2024-12-10 11:33:37', '2024-12-10 11:33:37'),
(2, 'Panos Turco', 'Panos de alta qualidade, tipicamente usados para banho e cuidados pessoais.', '2024-12-10 11:33:37', '2024-12-10 11:33:37'),
(3, 'Panos', 'Panos variados para uso doméstico, incluindo panos de prato e limpeza.', '2024-12-10 11:33:37', '2024-12-10 11:33:37'),
(4, 'Almofadas', 'Almofadas para decoração e conforto em ambientes diversos.', '2024-12-10 11:33:37', '2024-12-10 11:33:37'),
(5, 'Toalha de Mesa 140x140', 'Toalha de mesa no tamanho 140x140 cm, adequada para pequenas mesas.', '2024-12-10 11:33:37', '2024-12-10 11:33:37'),
(6, 'Toalha de Mesa 180x180', 'Toalha de mesa no tamanho 180x180 cm, ideal para mesas maiores.', '2024-12-10 11:33:37', '2024-12-10 11:33:37'),
(7, 'Toalha de Mesa 100x100', 'Toalha de mesa no tamanho 100x100 cm, ideal para mesas compactas.', '2024-12-10 11:33:37', '2024-12-10 11:33:37');

-- --------------------------------------------------------

--
-- Estrutura da tabela `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `stock_changes`
--

CREATE TABLE `stock_changes` (
  `change_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `changed_by` int(11) DEFAULT NULL,
  `change_date` datetime DEFAULT current_timestamp(),
  `movement_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `stock_movement`
--

CREATE TABLE `stock_movement` (
  `movement_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `movement_type` enum('entrada','saida') NOT NULL,
  `entry_type` enum('fornecedor','direta') DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `observation` text DEFAULT NULL,
  `date` timestamp NULL DEFAULT current_timestamp(),
  `product_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `stock_movement`
--

INSERT INTO `stock_movement` (`movement_id`, `quantity`, `movement_type`, `entry_type`, `supplier_id`, `observation`, `date`, `product_name`) VALUES
(1, 1, 'entrada', NULL, NULL, 'Venda em loja fisica ', '2025-02-03 21:47:42', 'Pano turco '),
(2, 1, 'entrada', NULL, NULL, 'Venda em loja fisica ', '2025-02-03 21:52:19', 'Almofada ');

-- --------------------------------------------------------

--
-- Estrutura da tabela `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `suppliers_info_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `suppliers_info`
--

CREATE TABLE `suppliers_info` (
  `suppliers_info_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `contact_type` varchar(50) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `supplier_logs`
--

CREATE TABLE `supplier_logs` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `dados_antigos` text DEFAULT NULL,
  `dados_novos` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `created_at`, `updated_at`, `role_id`, `first_name`, `last_name`) VALUES
(3, 'admin', 'admin@gmail.com', '$2y$10$aUX0Wg9A5nMoHwBfSayelOIazFYMvvb3C.fllMvxbuvUe8mT3bO3i', '2025-01-28 20:10:02', '2025-01-28 20:10:02', NULL, 'admin', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`alert_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Índices para tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Índices para tabela `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `stock_changes`
--
ALTER TABLE `stock_changes`
  ADD PRIMARY KEY (`change_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `changed_by` (`changed_by`),
  ADD KEY `stock_changes_2` (`movement_id`),
  ADD KEY `stock_changes_3` (`user_id`);

--
-- Índices para tabela `stock_movement`
--
ALTER TABLE `stock_movement`
  ADD PRIMARY KEY (`movement_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Índices para tabela `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`),
  ADD KEY `suppliers_1` (`suppliers_info_id`);

--
-- Índices para tabela `suppliers_info`
--
ALTER TABLE `suppliers_info`
  ADD PRIMARY KEY (`suppliers_info_id`);

--
-- Índices para tabela `supplier_logs`
--
ALTER TABLE `supplier_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `logs` (`supplier_id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Índices para tabela `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `alerts`
--
ALTER TABLE `alerts`
  MODIFY `alert_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `stock_changes`
--
ALTER TABLE `stock_changes`
  MODIFY `change_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `stock_movement`
--
ALTER TABLE `stock_movement`
  MODIFY `movement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `suppliers_info`
--
ALTER TABLE `suppliers_info`
  MODIFY `suppliers_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `supplier_logs`
--
ALTER TABLE `supplier_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`id`);

--
-- Limitadores para a tabela `stock_changes`
--
ALTER TABLE `stock_changes`
  ADD CONSTRAINT `stock_changes_2` FOREIGN KEY (`movement_id`) REFERENCES `stock_movement` (`movement_id`),
  ADD CONSTRAINT `stock_changes_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `stock_changes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `stock_movement`
--
ALTER TABLE `stock_movement`
  ADD CONSTRAINT `stock_movement_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`);

--
-- Limitadores para a tabela `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_1` FOREIGN KEY (`suppliers_info_id`) REFERENCES `suppliers_info` (`suppliers_info_id`);

--
-- Limitadores para a tabela `supplier_logs`
--
ALTER TABLE `supplier_logs`
  ADD CONSTRAINT `logs` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers_info` (`suppliers_info_id`);

--
-- Limitadores para a tabela `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
