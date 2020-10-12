ALTER TABLE `docsgo-document-template` CHANGE `type` `type` VARCHAR(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

ALTER TABLE `docsgo-projects` CHANGE `is-active` `status` ENUM('Active','Completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

ALTER TABLE `docsgo-projects` ADD COLUMN `version` VARCHAR(50) AFTER `name`;

ALTER TABLE `docsgo-reviews` CHANGE `status` `status` ENUM('Request Change','Ready For Review','Accepted') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

ALTER TABLE `docsgo-reviews` ADD `category`  enum('Document','Test case','Code','Report') NOT NULL;

ALTER TABLE `docsgo-documents` ADD COLUMN `author` VARCHAR(50) AFTER `file-name`;

CREATE TABLE `docsgo-cybersecurity` (
  `id` int(11) NOT NULL,
  `project_id` int(10) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `control` varchar(100) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Open','Close') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `docsgo-cybersecurity`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `docsgo-cybersecurity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

CREATE TABLE `docsgo-issues` (
  `id` int(11) NOT NULL,
  `project_id` varchar(50) NOT NULL,
  `issue` varchar(50) NOT NULL,
  `issue_description` varchar(200) NOT NULL,
  `update_date` datetime DEFAULT current_timestamp(),
  `source` enum('Ticket','Observation') NOT NULL,
  `status` enum('Open','Close') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `docsgo-issues`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `docsgo-issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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

ALTER TABLE `docsgo-soup`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `docsgo-soup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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

ALTER TABLE `docsgo-risk-assessment`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `docsgo-risk-assessment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

CREATE TABLE `docsgo-requirements` (
  `id` int(11) NOT NULL,
  `type` enum('System','Subsystem','CNCR') NOT NULL,
  `requirement` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `docsgo-requirements`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `docsgo-requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

CREATE TABLE `docsgo-test-cases` (
  `id` int(11) NOT NULL,
  `testcase` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `docsgo-test-cases`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `docsgo-test-cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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

ALTER TABLE `docsgo-traceability`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `docsgo-traceability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

CREATE TABLE `docsgo-status-options` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` int(11) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `docsgo-status-options`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `docsgo-status-options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
  

ALTER TABLE `docsgo-documents` CHANGE `update-date` `update-date` DATETIME NOT NULL;