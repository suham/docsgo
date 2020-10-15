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
-- Table structure for table `docsgo-cybersecurity`
--

CREATE TABLE `docsgo-cybersecurity` (
  `id` int(11) NOT NULL,
  `project_id` int(10) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `control` varchar(100) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Open','Close') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Table structure for table `docsgo-issues`
--

CREATE TABLE `docsgo-issues` (
  `id` int(11) NOT NULL,
  `project_id` varchar(50) NOT NULL,
  `issue` varchar(50) NOT NULL,
  `issue_description` varchar(200) NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `source` enum('Ticket','Observation') NOT NULL,
  `status` enum('Open','Close') NOT NULL
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
  `type` enum('System','Subsystem','CNCR') NOT NULL,
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
-- Table structure for table `docsgo-risk-assessment`
--

CREATE TABLE `docsgo-risk-assessment` (
  `id` int(11) NOT NULL,
  `risk_type` enum('open-issue','soup','cybersecurity') NOT NULL,
  `severity` int(11) NOT NULL,
  `occurrence` int(11) NOT NULL,
  `detectability` int(11) NOT NULL,
  `rpn` int(11) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp(),
  `issue_id` int(11) DEFAULT NULL,
  `cybersecurity_id` int(11) DEFAULT NULL,
  `soup_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `docsgo-soup`
--

CREATE TABLE `docsgo-soup` (
  `id` int(11) NOT NULL,
  `project_id` int(10) NOT NULL,
  `soup` varchar(50) NOT NULL,
  `version` varchar(50) NOT NULL,
  `purpose` varchar(200) NOT NULL,
  `validation` varchar(200) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Open','Close') NOT NULL
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
  `cncr` varchar(100) NOT NULL,
  `sysreq` varchar(100) NOT NULL,
  `subsysreq` varchar(100) NOT NULL,
  `design` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `testcase` varchar(100) NOT NULL,
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
-- Indexes for dumped tables
--

--
-- Indexes for table `docsgo-cybersecurity`
--
ALTER TABLE `docsgo-cybersecurity`
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
-- Indexes for table `docsgo-issues`
--
ALTER TABLE `docsgo-issues`
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
-- Indexes for table `docsgo-soup`
--
ALTER TABLE `docsgo-soup`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `docsgo-cybersecurity`
--
ALTER TABLE `docsgo-cybersecurity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `docsgo-issues`
--
ALTER TABLE `docsgo-issues`
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
-- AUTO_INCREMENT for table `docsgo-risk-assessment`
--
ALTER TABLE `docsgo-risk-assessment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `docsgo-soup`
--
ALTER TABLE `docsgo-soup`
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

ALTER TABLE `docsgo-risk-assessment` CHANGE `risk_type` `risk_type` ENUM('Open-issue','SOUP','Cybersecurity') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

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
