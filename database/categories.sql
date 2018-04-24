-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

TRUNCATE `categories`;
INSERT INTO `categories` (`id`, `slug`, `name`, `description`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'language', 'Language', NULL, NULL, 1,  NULL, NULL),
(2, 'business', 'Business', NULL, NULL, 1,  NULL, NULL),
(3, 'development',  'Development',  NULL, NULL, 1,  NULL, NULL),
(4, 'design', 'Design', NULL, NULL, 1,  NULL, NULL),
(5, 'marketing',  'Marketing',  NULL, NULL, 1,  NULL, NULL),
(9, 'music',  'Music',  NULL, NULL, 1,  NULL, NULL),
(10,  'test-prep',  'Test Prep',  NULL, NULL, 1,  NULL, NULL),
(11,  'academics',  'Academics',  NULL, NULL, 1,  NULL, NULL),
(12,  'personal-development', 'Personal Development', NULL, NULL, 1,  NULL, NULL),
(13,  'health-and-fitness', 'Health & Fitness', NULL, NULL, 1,  NULL, NULL),
(14,  'lifestyle',  'Lifestyle',  NULL, NULL, 1,  NULL, NULL),
(15,  'finance',  'Finance',  NULL, NULL, 1,  NULL, NULL);

-- 2017-12-10 02:59:37