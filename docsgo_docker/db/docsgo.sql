-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2020 at 02:52 PM
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
-- Table structure for table `docsgo-acronyms`
--

CREATE TABLE `docsgo-acronyms` (
  `id` int(11) NOT NULL,
  `acronym` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-diagrams`
--

CREATE TABLE `docsgo-diagrams` (
  `id` int(11) NOT NULL,
  `diagram_name` varchar(100) NOT NULL,
  `markdown` longtext NOT NULL,
  `author_id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-document-master`
--

CREATE TABLE `docsgo-document-master` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `category` varchar(64) NOT NULL,
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
  `review-id` int(11) DEFAULT NULL,
  `type` varchar(64) NOT NULL,
  `category` varchar(64) NOT NULL,
  `update-date` datetime NOT NULL,
  `json-object` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `file-name` varchar(64) DEFAULT NULL,
  `author-id` int(11) NOT NULL,
  `reviewer-id` int(11) DEFAULT NULL,
  `status` varchar(64) NOT NULL,
  `revision-history` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`revision-history`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

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
  `download-path` varchar(100) DEFAULT NULL,
  `version` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-requirements`
--

CREATE TABLE `docsgo-requirements` (
  `id` int(11) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `requirement` varchar(100) NOT NULL,
  `description` longtext DEFAULT NULL,
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
  `review-ref` text DEFAULT NULL,
  `review-by` varchar(50) NOT NULL,
  `context` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `code-diff` text DEFAULT NULL,
  `assigned-to` varchar(50) NOT NULL,
  `status` varchar(64) NOT NULL,
  `category` varchar(60) NOT NULL,
  `updated-at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-risks`
--

CREATE TABLE `docsgo-risks` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `risk_type` enum('Open-Issue','Vulnerability','SOUP') NOT NULL,
  `risk` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `component` varchar(100) NOT NULL,
  `hazard-analysis` text NOT NULL,
  `assessment` longtext NOT NULL,
  `baseScore_severity` float NOT NULL,
  `status` enum('Open','Close') NOT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-settings`
--

CREATE TABLE `docsgo-settings` (
  `id` int(11) NOT NULL,
  `type` enum('dropdown','url','properties') NOT NULL,
  `identifier` varchar(50) NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `docsgo-settings`
--

INSERT INTO `docsgo-settings` (`id`, `type`, `identifier`, `options`) VALUES
(1, 'dropdown', 'templateCategory', NULL),
(2, 'url', 'third-party', '[{\"key\":\"sonar\",\"url\":\"\",\"apiKey\":\"\"},{\"key\":\"testLink\",\"url\":\"\",\"apiKey\":\"\"}]'),
(3, 'dropdown', 'documentStatus', NULL),
(6, 'dropdown', 'reviewCategory', NULL),
(7, 'dropdown', 'userRole', NULL),
(8, 'dropdown', 'riskCategory', NULL),
(9, 'dropdown', 'referenceCategory', NULL),
(10, 'dropdown', 'requirementsCategory', NULL),
(11, 'dropdown', 'assetsCategory', NULL),
(12, 'properties', 'documentProperties', NULL);

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
-- Table structure for table `docsgo-taskboard`
--

CREATE TABLE `docsgo-taskboard` (
  `id` int(11) NOT NULL,
  `task_column` varchar(20) NOT NULL,
  `task_category` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `project_id` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `assignee` int(11) DEFAULT NULL,
  `verifier` int(11) DEFAULT NULL,
  `comments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`comments`)),
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachments`))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-team-master`
--

CREATE TABLE `docsgo-team-master` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `responsibility` varchar(100) DEFAULT NULL,
  `is-manager` tinyint(1) NOT NULL DEFAULT 0,
  `is-admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `docsgo-team-master`
--

INSERT INTO `docsgo-team-master` (`id`, `name`, `email`, `password`, `role`, `responsibility`, `is-manager`, `is-admin`, `created_at`, `updated_at`) VALUES
(37, 'user', 'user@gmail.com', '$2y$10$QFG0v/fICPHnhHcVWckVcujd0na3M2im/SW6FNhRgcJ0KA3exPD7K', NULL, 'Admin', 1, 1, '2020-12-06 07:47:14', '2020-12-06 19:17:14');

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-test-cases`
--

CREATE TABLE `docsgo-test-cases` (
  `id` int(11) NOT NULL,
  `testcase` varchar(100) NOT NULL,
  `description` longtext DEFAULT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-traceability`
--

CREATE TABLE `docsgo-traceability` (
  `id` int(11) NOT NULL,
  `root_requirement` varchar(100) DEFAULT NULL,
  `design` text NOT NULL,
  `code` text NOT NULL,
  `description` longtext DEFAULT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp()
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
-- Indexes for dumped tables
--

--
-- Indexes for table `docsgo-acronyms`
--
ALTER TABLE `docsgo-acronyms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-diagrams`
--
ALTER TABLE `docsgo-diagrams`
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
-- Indexes for table `docsgo-risks`
--
ALTER TABLE `docsgo-risks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-settings`
--
ALTER TABLE `docsgo-settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-status-options`
--
ALTER TABLE `docsgo-status-options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docsgo-taskboard`
--
ALTER TABLE `docsgo-taskboard`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `docsgo-acronyms`
--
ALTER TABLE `docsgo-acronyms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `docsgo-diagrams`
--
ALTER TABLE `docsgo-diagrams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `docsgo-document-master`
--
ALTER TABLE `docsgo-document-master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `docsgo-document-template`
--
ALTER TABLE `docsgo-document-template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `docsgo-documents`
--
ALTER TABLE `docsgo-documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `docsgo-inventory-master`
--
ALTER TABLE `docsgo-inventory-master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=339;

--
-- AUTO_INCREMENT for table `docsgo-projects`
--
ALTER TABLE `docsgo-projects`
  MODIFY `project-id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `docsgo-requirements`
--
ALTER TABLE `docsgo-requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=422;

--
-- AUTO_INCREMENT for table `docsgo-reviews`
--
ALTER TABLE `docsgo-reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `docsgo-risks`
--
ALTER TABLE `docsgo-risks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `docsgo-settings`
--
ALTER TABLE `docsgo-settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `docsgo-status-options`
--
ALTER TABLE `docsgo-status-options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `docsgo-taskboard`
--
ALTER TABLE `docsgo-taskboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `docsgo-team-master`
--
ALTER TABLE `docsgo-team-master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `docsgo-test-cases`
--
ALTER TABLE `docsgo-test-cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1984;

--
-- AUTO_INCREMENT for table `docsgo-traceability`
--
ALTER TABLE `docsgo-traceability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `docsgo-traceability-options`
--
ALTER TABLE `docsgo-traceability-options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2653;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
