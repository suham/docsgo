-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Oct 24, 2020 at 12:22 PM
-- Server version: 8.0.22
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `docsgo`
--

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-acronyms`
--

CREATE TABLE `docsgo-acronyms` (
  `id` int NOT NULL,
  `acronym` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-document-master`
--

CREATE TABLE `docsgo-document-master` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `category` enum('Requirement','Design','Impact Analysis','Test','Standards','Other') NOT NULL,
  `version` varchar(50) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `ref` varchar(100) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `status` enum('Draft','Approved','Obsolete') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-document-template`
--

CREATE TABLE `docsgo-document-template` (
  `id` int NOT NULL,
  `name` varchar(64) NOT NULL,
  `type` varchar(60) NOT NULL,
  `template-json-object` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-documents`
--

CREATE TABLE `docsgo-documents` (
  `id` int NOT NULL,
  `project-id` int NOT NULL,
  `review-id` int DEFAULT NULL,
  `type` varchar(64) NOT NULL,
  `update-date` datetime NOT NULL,
  `json-object` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `file-name` varchar(50) DEFAULT NULL,
  `author-id` int NOT NULL,
  `author` varchar(50) DEFAULT NULL,
  `status` enum('Draft','Approved','Rejected') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-inventory-master`
--

CREATE TABLE `docsgo-inventory-master` (
  `id` int NOT NULL,
  `item` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `make` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `serial` varchar(50) NOT NULL,
  `entry_date` date NOT NULL,
  `retired_date` date NOT NULL,
  `cal_date` date NOT NULL,
  `cal_due` date NOT NULL,
  `location` varchar(50) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `invoice_date` date NOT NULL,
  `vendor` varchar(50) NOT NULL,
  `status` enum('active','in-active','not-found','cal-overdue') NOT NULL,
  `used_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-projects`
--

CREATE TABLE `docsgo-projects` (
  `project-id` int NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `start-date` date NOT NULL,
  `end-date` date DEFAULT NULL,
  `status` enum('Active','Completed') NOT NULL,
  `manager-id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `version` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-requirements`
--

CREATE TABLE `docsgo-requirements` (
  `id` int NOT NULL,
  `type` enum('User Needs','System','Subsystem') NOT NULL,
  `requirement` varchar(100) NOT NULL,
  `description` varchar(2100) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-reviews`
--

CREATE TABLE `docsgo-reviews` (
  `id` int NOT NULL,
  `project-id` int NOT NULL,
  `review-name` varchar(64) NOT NULL,
  `review-ref` varchar(250) DEFAULT NULL,
  `review-by` varchar(50) NOT NULL,
  `context` varchar(200) DEFAULT NULL,
  `description` varchar(400) DEFAULT NULL,
  `assigned-to` varchar(50) NOT NULL,
  `status` enum('Request Change','Ready For Review','Accepted') NOT NULL,
  `category` varchar(60) NOT NULL,
  `updated-at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-risk-assessment`
--

CREATE TABLE `docsgo-risk-assessment` (
  `id` int NOT NULL,
  `risk_type` enum('open-issue','soup','cybersecurity') NOT NULL,
  `risk_details` varchar(200) NOT NULL,
  `failure` varchar(200) NOT NULL,
  `harm` varchar(200) NOT NULL,
  `mitigation` varchar(200) NOT NULL,
  `severity` int NOT NULL,
  `occurrence` int NOT NULL,
  `detectability` int NOT NULL,
  `rpn` int NOT NULL,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `issue_id` int DEFAULT NULL,
  `cybersecurity_id` int DEFAULT NULL,
  `soup_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-risks`
--

CREATE TABLE `docsgo-risks` (
  `id` int NOT NULL,
  `project_id` int NOT NULL,
  `category` enum('Issue','Observation','Security','SOUP') NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `information` varchar(100) NOT NULL,
  `severity` int NOT NULL,
  `occurrence` int NOT NULL,
  `detectability` int NOT NULL,
  `rpn` int NOT NULL,
  `status` enum('Open','Close') NOT NULL,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-status-options`
--

CREATE TABLE `docsgo-status-options` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` int NOT NULL,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `docsgo-status-options`
--

INSERT INTO `docsgo-status-options` (`id`, `name`, `value`, `update_date`) VALUES
(1, 'Very High', 5, '2020-10-07 18:24:55'),
(2, 'High', 4, '2020-10-07 18:25:08'),
(3, 'Moderate', 3, '2020-10-07 18:25:18'),
(4, 'Low', 2, '2020-10-07 18:25:34'),
(5, 'Minor/Minimal', 1, '2020-10-07 18:25:42');

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-team-master`
--

CREATE TABLE `docsgo-team-master` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `responsibility` varchar(100) DEFAULT NULL,
  `is-manager` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-test-cases`
--

CREATE TABLE `docsgo-test-cases` (
  `id` int NOT NULL,
  `testcase` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-traceability`
--

CREATE TABLE `docsgo-traceability` (
  `id` int NOT NULL,
  `design` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-traceability-options`
--

CREATE TABLE `docsgo-traceability-options` (
  `id` int NOT NULL,
  `traceability_id` int NOT NULL,
  `type` varchar(50) NOT NULL,
  `requirement_id` int NOT NULL,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-users`
--

CREATE TABLE `docsgo-users` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is-admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `docsgo-users`
--

INSERT INTO `docsgo-users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`, `is-admin`) VALUES
(26, 'user', 'user@gmail.com', '$2y$10$WTruHEzlsPDbWSNF/8klguwcX6x2OsN6Iw5F0PLq83f8rd.mD6sSy', '2020-10-24 07:12:12', '2020-10-24 12:12:12', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `docsgo-acronyms`
--
ALTER TABLE `docsgo-acronyms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-document-master`
--
ALTER TABLE `docsgo-document-master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-document-template`
--
ALTER TABLE `docsgo-document-template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-documents`
--
ALTER TABLE `docsgo-documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-inventory-master`
--
ALTER TABLE `docsgo-inventory-master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-projects`
--
ALTER TABLE `docsgo-projects`
  ADD PRIMARY KEY (`project-id`);

--
-- Indexes for table `docsgo-requirements`
--
ALTER TABLE `docsgo-requirements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-reviews`
--
ALTER TABLE `docsgo-reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-risk-assessment`
--
ALTER TABLE `docsgo-risk-assessment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-risks`
--
ALTER TABLE `docsgo-risks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-status-options`
--
ALTER TABLE `docsgo-status-options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-team-master`
--
ALTER TABLE `docsgo-team-master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-test-cases`
--
ALTER TABLE `docsgo-test-cases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-traceability`
--
ALTER TABLE `docsgo-traceability`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-traceability-options`
--
ALTER TABLE `docsgo-traceability-options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-users`
--
ALTER TABLE `docsgo-users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `docsgo-acronyms`
--
ALTER TABLE `docsgo-acronyms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `docsgo-document-master`
--
ALTER TABLE `docsgo-document-master`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `docsgo-document-template`
--
ALTER TABLE `docsgo-document-template`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `docsgo-documents`
--
ALTER TABLE `docsgo-documents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `docsgo-inventory-master`
--
ALTER TABLE `docsgo-inventory-master`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `docsgo-projects`
--
ALTER TABLE `docsgo-projects`
  MODIFY `project-id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `docsgo-requirements`
--
ALTER TABLE `docsgo-requirements`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=412;

--
-- AUTO_INCREMENT for table `docsgo-reviews`
--
ALTER TABLE `docsgo-reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `docsgo-risk-assessment`
--
ALTER TABLE `docsgo-risk-assessment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `docsgo-risks`
--
ALTER TABLE `docsgo-risks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `docsgo-status-options`
--
ALTER TABLE `docsgo-status-options`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `docsgo-team-master`
--
ALTER TABLE `docsgo-team-master`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `docsgo-test-cases`
--
ALTER TABLE `docsgo-test-cases`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1907;

--
-- AUTO_INCREMENT for table `docsgo-traceability`
--
ALTER TABLE `docsgo-traceability`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `docsgo-traceability-options`
--
ALTER TABLE `docsgo-traceability-options`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1298;

--
-- AUTO_INCREMENT for table `docsgo-users`
--
ALTER TABLE `docsgo-users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


ALTER TABLE `docsgo-traceability` ADD `description` LONGTEXT AFTER `code`;
ALTER TABLE `docsgo-traceability` ADD `root_requirement` varchar(100) AFTER `id`;
UPDATE `docsgo-traceability` SET root_requirement = 'User Needs';

ALTER TABLE `docsgo-requirements` MODIFY type varchar (100);
