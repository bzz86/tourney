-- ---
-- Table 'tourney'
-- 
-- ---

DROP TABLE IF EXISTS `tourney`;
		
CREATE TABLE `tourney` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` MEDIUMTEXT NOT NULL,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update` TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `start_date` DATETIME NULL DEFAULT NOW(),
  `status` TINYINT(2) NOT NULL DEFAULT 0,
  `type` TINYINT NOT NULL,
  `registration_start` DATETIME NOT NULL DEFAULT NOW(),
  `registration_end` DATETIME NOT NULL,
  `creator_id` INTEGER NOT NULL,
  PRIMARY KEY (`id`)
);


-- ---
-- Table 'participant'
-- 
-- ---

DROP TABLE IF EXISTS `participant`;
		
CREATE TABLE `participant` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` VARCHAR(1000) NULL DEFAULT NULL,
  `type` TINYINT(2) NOT NULL DEFAULT 1,
  `banned` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'torney_participant'
-- 
-- ---

DROP TABLE `tourney_participant`;
		
CREATE TABLE `tourney_participant` (
  `tourney_id` INTEGER NOT NULL,
  `participant_id` INTEGER NOT NULL,
	PRIMARY KEY (`tourney_id`, `participant_id`),
	FOREIGN KEY (tourney_id) REFERENCES tourney(id) ON UPDATE CASCADE,  
	FOREIGN KEY (participant_id) REFERENCES participant(id) ON UPDATE CASCADE);
);