-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2020 at 07:26 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Table structure for table `docsgo-document-master`
--

CREATE TABLE `docsgo-document-master` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `category` enum('Requirement','Design','Impact Analysis','Test','Standards','Other') NOT NULL,
  `version` varchar(50) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `ref` varchar(100) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `status` enum('Draft','Approved','Obsolete') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-document-template`
--

CREATE TABLE `docsgo-document-template` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `type` varchar(60) NOT NULL,
  `template-json-object` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-documents`
--

CREATE TABLE `docsgo-documents` (
  `id` int(11) NOT NULL,
  `project-id` int(11) NOT NULL,
  `type` varchar(64) NOT NULL,
  `update-date` datetime NOT NULL,
  `json-object` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `file-name` varchar(50) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  `status` enum('Draft','Approved','Rejected') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-projects`
--

CREATE TABLE `docsgo-projects` (
  `project-id` int(11) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `start-date` date NOT NULL,
  `end-date` date DEFAULT NULL,
  `status` enum('Active','Completed') NOT NULL,
  `manager-id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `version` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-requirements`
--

CREATE TABLE `docsgo-requirements` (
  `id` int(11) NOT NULL,
  `type` enum('System','Subsystem','User Needs') NOT NULL,
  `requirement` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-reviews`
--

CREATE TABLE `docsgo-reviews` (
  `id` int(11) NOT NULL,
  `project-id` int(11) NOT NULL,
  `review-name` varchar(64) NOT NULL,
  `review-ref` varchar(250) DEFAULT NULL,
  `review-by` varchar(50) NOT NULL,
  `context` varchar(200) DEFAULT NULL,
  `description` varchar(400) DEFAULT NULL,
  `assigned-to` varchar(50) NOT NULL,
  `status` enum('Request Change','Ready For Review','Accepted') NOT NULL,
  `category` enum('Document','Test case','Code','Report') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-status-options`
--

CREATE TABLE `docsgo-status-options` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` int(11) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-team-master`
--

CREATE TABLE `docsgo-team-master` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `responsibility` varchar(100) DEFAULT NULL,
  `is-manager` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-test-cases`
--

CREATE TABLE `docsgo-test-cases` (
  `id` int(11) NOT NULL,
  `testcase` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-traceability`
--

CREATE TABLE `docsgo-traceability` (
  `id` int(11) NOT NULL,
  `design` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-users`
--

CREATE TABLE `docsgo-users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is-admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-traceability-options`
--

CREATE TABLE `docsgo-traceability-options` (
  `id` int(11) NOT NULL,
  `traceability_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `requirement_id` int(11) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `docsgo-risks`
--

CREATE TABLE `docsgo-risks` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `category` enum('Issue','Observation','Security','SOUP') NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `information` varchar(100) NOT NULL,
  `severity` int(11) NOT NULL,
  `occurrence` int(11) NOT NULL,
  `detectability` int(11) NOT NULL,
  `rpn` int(11) NOT NULL,
  `status` enum('Open','Close') NOT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


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
-- Indexes for table `docsgo-users`
--
ALTER TABLE `docsgo-users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-traceability-options`
--
ALTER TABLE `docsgo-traceability-options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-risks`
--
ALTER TABLE `docsgo-risks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `docsgo-document-master`
--
ALTER TABLE `docsgo-document-master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `docsgo-document-template`
--
ALTER TABLE `docsgo-document-template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `docsgo-documents`
--
ALTER TABLE `docsgo-documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


--
-- AUTO_INCREMENT for table `docsgo-projects`
--
ALTER TABLE `docsgo-projects`
  MODIFY `project-id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `docsgo-requirements`
--
ALTER TABLE `docsgo-requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `docsgo-reviews`
--
ALTER TABLE `docsgo-reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


--
-- AUTO_INCREMENT for table `docsgo-status-options`
--
ALTER TABLE `docsgo-status-options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `docsgo-team-master`
--
ALTER TABLE `docsgo-team-master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `docsgo-test-cases`
--
ALTER TABLE `docsgo-test-cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `docsgo-traceability`
--
ALTER TABLE `docsgo-traceability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `docsgo-traceability-options`
--
ALTER TABLE `docsgo-traceability-options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

--
-- AUTO_INCREMENT for table `docsgo-users`
--
ALTER TABLE `docsgo-users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- AUTO_INCREMENT for table `docsgo-risks`
--
ALTER TABLE `docsgo-risks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
ALTER TABLE `docsgo-requirements` CHANGE `description` `description` VARCHAR(2100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE `docsgo-test-cases` CHANGE `description` `description` VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

-- New Changes
ALTER TABLE `docsgo-documents` ADD `review-id` INT NULL AFTER `project-id`;
ALTER TABLE `docsgo-documents` ADD `author-id` INT NOT NULL AFTER `file-name`;

--Alter requiremenst table enum values
ALTER TABLE `docsgo-requirements` CHANGE `type` `type` ENUM('User Needs', 'System', 'Subsystem') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

ALTER TABLE `docsgo-reviews` CHANGE `category` `category` VARCHAR(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE `docsgo-reviews` ADD `updated-at` datetime NOT NULL DEFAULT current_timestamp() AFTER `category`;

--
-- Table structure for table `docsgo-inventory-master`
--

CREATE TABLE `docsgo-inventory-master` (
  `id` int(11) NOT NULL,
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
  `used_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for table `docsgo-inventory-master`
--
ALTER TABLE `docsgo-inventory-master`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `docsgo-inventory-master`
--
ALTER TABLE `docsgo-inventory-master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

--
-- Table structure for table `docsgo-acronyms`
--

CREATE TABLE `docsgo-acronyms` (
  `id` int(11) NOT NULL,
  `acronym` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for table `docsgo-acronyms`
--
ALTER TABLE `docsgo-acronyms`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `docsgo-acronyms`
--
ALTER TABLE `docsgo-acronyms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;


ALTER TABLE `docsgo-reviews` CHANGE `description` `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
ALTER TABLE `docsgo-reviews` CHANGE `context` `context` VARCHAR(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
ALTER TABLE `docsgo-reviews` CHANGE `review-ref` `review-ref` VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
