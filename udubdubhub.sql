-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2023 at 01:08 AM
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
-- Database: `udubdubhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`name`) VALUES
('BEINDP 290'),
('BIO 120'),
('BIO 141'),
('BIO 142'),
('BIO 190'),
('BIO 200'),
('BIO 251'),
('BIO 253'),
('BIO 254'),
('BIO 255'),
('BIO 257'),
('BIO 303'),
('BIO 311'),
('BIO 361'),
('BIO 362'),
('BIO 380'),
('BIO 446'),
('BIO 456'),
('CHEM 100'),
('CHEM 101'),
('CHEM 102'),
('CHEM 104'),
('CHEM 260'),
('COMM 110'),
('CORE 110'),
('CORE 120'),
('CORE 130'),
('CORE 140'),
('CORE 390'),
('DevEd 50'),
('DevEd 60');

-- --------------------------------------------------------

--
-- Table structure for table `day`
--

CREATE TABLE `day` (
  `dayName` varchar(25) NOT NULL,
  `facilityName` varchar(255) NOT NULL,
  `hours` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `day`
--

INSERT INTO `day` (`dayName`, `facilityName`, `hours`) VALUES
('Friday', 'Cafe at the Center of the Arts', '8:00am - 1:00pm'),
('Friday', 'Deliotte Cafe', '7:30am - 1:00pm'),
('Friday', 'DLK Gym (Main)', '8: 30 am - Noon'),
('Friday', 'Drumlin C-Store', '8:00am - 10:00pm'),
('Friday', 'Drumlin Dining Hall', '11:00am - 2:00pm'),
('Friday', 'Einstein Bros. Bagels', '8:00am - 2:30pm'),
('Friday', 'Erbert & Gerbert\'s in Drumlin', '11:00am - 10:00pm'),
('Friday', 'Esker C-Store', '11:00am - 10:00pm'),
('Friday', 'Esker Dining Hall', '11:00am - 2:00pm & 4:00pm - 7:30pm'),
('Friday', 'Food for Thought', '8:30am - 2:00pm'),
('Friday', 'h\'EAT & Fire', '11:00am - 10:00pm'),
('Friday', 'Ike Schaffer Commons', '7:30am - 10:30am'),
('Friday', 'Kachel Fieldhouse', '8 am - 2 pm & 7 - 9 pm'),
('Friday', 'Kachel Track', '8 am - 2 pm & 7 - 9 pm'),
('Friday', 'La Pradera', '7:30am - 9:30am & 11:00am - 11:00pm'),
('Friday', 'Pak\'s Sushi & Poke Station', '10:45am - 2:00pm'),
('Friday', 'Pool', '11 am - 1 pm & 7 - 9 pm'),
('Friday', 'Racquetball Courts', '8 am - 9 pm'),
('Friday', 'Russell Volleyball Arena', 'Noon - 1 pm'),
('Friday', 'Sideline Cafe', '7:30am - 2:00pm'),
('Friday', 'University Fitness (Wells Hall)', '7 - 9 am & 12:30 - 7 pm'),
('Friday', 'Weight Room / Cardio Center', '6 am - 9 pm'),
('Friday', 'Willie\'s', '7:00am - 4:00pm'),
('Monday', 'Cafe at the Center of the Arts', '8:00am - 3:00pm'),
('Monday', 'Deliotte Cafe', '7:30am - 2:00pm'),
('Monday', 'DLK Gym (Main)', '8:30 - 10:30 am'),
('Monday', 'Drumlin C-Store', '8:00am - 10:00pm'),
('Monday', 'Drumlin Dining Hall', '11:00am - 2:00pm'),
('Monday', 'Einstein Bros. Bagels', '8:00am - 4:00pm'),
('Monday', 'Erbert & Gerbert\'s in Drumlin', '11:00am - 10:00pm'),
('Monday', 'Esker C-Store', '11:00am - 10:00pm'),
('Monday', 'Esker Dining Hall', '11:00am - 2:00pm & 4:00pm - 7:30pm'),
('Monday', 'Food for Thought', '8:30am - 4:00pm'),
('Monday', 'h\'EAT & Fire', '11:00am - 10:00pm'),
('Monday', 'Ike Schaffer Commons', '7:30am - 10:30am'),
('Monday', 'Kachel Fieldhouse', '8 am - 2 pm & 7 - 11 pm'),
('Monday', 'Kachel Track', '8 am - 2 pm & 7 - 11 pm'),
('Monday', 'La Pradera', '7:30am - 9:30am & 11:00am - 11:00pm'),
('Monday', 'Pak\'s Sushi & Poke Station', '10:45am - 4:00pm'),
('Monday', 'Pool', '11 am - 1 pm & 7 - 9 pm'),
('Monday', 'Racquetball Courts', '8 am - 11 pm'),
('Monday', 'Russell Volleyball Arena', '8 - 10 am & 11 am - 2 pm & 7 - 11 pm'),
('Monday', 'Sideline Cafe', '7:30am - 2:00pm'),
('Monday', 'University Fitness (Wells Hall)', '12:30 - 11 pm'),
('Monday', 'Weight Room / Cardio Center', '6 am - 11 pm'),
('Monday', 'Willie\'s', '7:00am - 5:00pm'),
('Saturday', 'Cafe at the Center of the Arts', 'Closed'),
('Saturday', 'Deliotte Cafe', 'Closed'),
('Saturday', 'DLK Gym (Main)', 'No Open Recreation'),
('Saturday', 'Drumlin C-Store', '11:00am - 10:00pm'),
('Saturday', 'Drumlin Dining Hall', 'Closed'),
('Saturday', 'Einstein Bros. Bagels', 'Closed'),
('Saturday', 'Erbert & Gerbert\'s in Drumlin', '11:00am - 10:00pm'),
('Saturday', 'Esker C-Store', '11:00am - 10:00pm'),
('Saturday', 'Esker Dining Hall', '11:00am - 2:00pm & 4:00pm - 7:30pm'),
('Saturday', 'Food for Thought', 'Closed'),
('Saturday', 'h\'EAT & Fire', '11:00am - 10:00pm'),
('Saturday', 'Ike Schaffer Commons', 'Closed'),
('Saturday', 'Kachel Fieldhouse', '8 am - 5 pm'),
('Saturday', 'Kachel Track', '8 am - 5 pm'),
('Saturday', 'La Pradera', '7:30am - 9:30am & 11:00am - 11:00pm'),
('Saturday', 'Pak\'s Sushi & Poke Station', 'Closed'),
('Saturday', 'Pool', 'No Open Swim'),
('Saturday', 'Racquetball Courts', '8 am - 5 pm'),
('Saturday', 'Russell Volleyball Arena', 'No Open Recreation'),
('Saturday', 'Sideline Cafe', 'Closed'),
('Saturday', 'University Fitness (Wells Hall)', 'CLOSED'),
('Saturday', 'Weight Room / Cardio Center', '8 am -1 pm'),
('Saturday', 'Willie\'s', '9:00am - 4:00pm'),
('Sunday', 'Cafe at the Center of the Arts', 'Closed'),
('Sunday', 'Deliotte Cafe', 'Closed'),
('Sunday', 'DLK Gym (Main)', 'Noon - 11 pm'),
('Sunday', 'Drumlin C-Store', '11:00am - 10:00pm'),
('Sunday', 'Drumlin Dining Hall', '4:00pm - 7:30pm'),
('Sunday', 'Einstein Bros. Bagels', 'Closed'),
('Sunday', 'Erbert & Gerbert\'s in Drumlin', '11:00am - 10:00pm'),
('Sunday', 'Esker C-Store', '11:00am - 10:00pm'),
('Sunday', 'Esker Dining Hall', '11:00am - 2:00pm & 4:00pm - 7:30pm'),
('Sunday', 'Food for Thought', 'Closed'),
('Sunday', 'h\'EAT & Fire', '11:00am - 10:00pm'),
('Sunday', 'Ike Schaffer Commons', 'Closed'),
('Sunday', 'Kachel Fieldhouse', 'Noon - 7 pm & 7 - 11 pm'),
('Sunday', 'Kachel Track', 'Noon - 11 pm'),
('Sunday', 'La Pradera', '7:30am - 9:30am & 11:00am - 11:00pm'),
('Sunday', 'Pak\'s Sushi & Poke Station', 'Closed'),
('Sunday', 'Pool', '7 - 9 pm'),
('Sunday', 'Racquetball Courts', 'Noon - 11 pm'),
('Sunday', 'Russell Volleyball Arena', 'Noon - 6 pm'),
('Sunday', 'Sideline Cafe', 'Closed'),
('Sunday', 'University Fitness (Wells Hall)', '3 - 9 pm'),
('Sunday', 'Weight Room / Cardio Center', 'Noon - 10 pm'),
('Sunday', 'Willie\'s', 'Closed'),
('Thursday', 'Cafe at the Center of the Arts', '8:00am - 3:00pm'),
('Thursday', 'Deliotte Cafe', '7:30am - 2:00pm'),
('Thursday', 'DLK Gym (Main)', '8:30 - 9:30 am & 10:30 am - 2 pm & 6:30 - 11 pm'),
('Thursday', 'Drumlin C-Store', '8:00am - 10:00pm'),
('Thursday', 'Drumlin Dining Hall', '11:00am - 2:00pm'),
('Thursday', 'Einstein Bros. Bagels', '8:00am - 4:00pm'),
('Thursday', 'Erbert & Gerbert\'s in Drumlin', '11:00am - 10:00pm'),
('Thursday', 'Esker C-Store', '11:00am - 10:00pm'),
('Thursday', 'Esker Dining Hall', '11:00am - 2:00pm & 4:00pm - 7:30pm'),
('Thursday', 'Food for Thought', '8:30am - 4:00pm'),
('Thursday', 'h\'EAT & Fire', '11:00am - 10:00pm'),
('Thursday', 'Ike Schaffer Commons', '7:30am - 10:30am'),
('Thursday', 'Kachel Fieldhouse', '8 am - 2 pm & 7 - 11 pm'),
('Thursday', 'Kachel Track', '8 am - 2 pm & 7 - 11 pm'),
('Thursday', 'La Pradera', '7:30am - 9:30am & 11:00am - 11:00pm'),
('Thursday', 'Pak\'s Sushi & Poke Station', '10:45am - 4:00pm'),
('Thursday', 'Pool', '7:45 - 8:45am & 11 am - 1 pm & 7 - 9 pm'),
('Thursday', 'Racquetball Courts', '8 am - 11 pm'),
('Thursday', 'Russell Volleyball Arena', '8 - 9:30 am & 11 am - 12:30 pm & 6 - 11 pm'),
('Thursday', 'Sideline Cafe', '7:30am - 2:00pm'),
('Thursday', 'University Fitness (Wells Hall)', '7 - 9 am & 12:30 - 9 pm'),
('Thursday', 'Weight Room / Cardio Center', '6 am - 11 pm'),
('Thursday', 'Willie\'s', '7:00am - 5:00pm'),
('Tuesday', 'Cafe at the Center of the Arts', '8:00am - 3:00pm'),
('Tuesday', 'Deliotte Cafe', '7:30am - 2:00pm'),
('Tuesday', 'DLK Gym (Main)', '8:30 - 9:30 am & 10:30 am - 2 pm & 6 - 11 pm'),
('Tuesday', 'Drumlin C-Store', '8:00am - 10:00pm'),
('Tuesday', 'Drumlin Dining Hall', '11:00am - 2:00pm'),
('Tuesday', 'Einstein Bros. Bagels', '8:00am - 4:00pm'),
('Tuesday', 'Erbert & Gerbert\'s in Drumlin', '11:00am - 10:00pm'),
('Tuesday', 'Esker C-Store', '11:00am - 10:00pm'),
('Tuesday', 'Esker Dining Hall', '11:00am - 2:00pm & 4:00pm - 7:30pm'),
('Tuesday', 'Food for Thought', '8:30am - 4:00pm'),
('Tuesday', 'h\'EAT & Fire', '11:00am - 10:00pm'),
('Tuesday', 'Ike Schaffer Commons', '7:30am - 10:30am'),
('Tuesday', 'Kachel Fieldhouse', '8 am - 2 pm & 7 - 11 pm'),
('Tuesday', 'Kachel Track', '8 am - 2 pm & 7 - 11 pm'),
('Tuesday', 'La Pradera', '7:30am - 9:30am & 11:00am - 11:00pm'),
('Tuesday', 'Pak\'s Sushi & Poke Station', '10:45am - 4:00pm'),
('Tuesday', 'Pool', '7:45 - 8:45am & 11 am - 1 pm & 7 - 9 pm '),
('Tuesday', 'Racquetball Courts', '8 am - 11 pm'),
('Tuesday', 'Russell Volleyball Arena', '8 - 9:30 am & 11 am - 12:30 pm & 7 - 11 pm'),
('Tuesday', 'Sideline Cafe', '7:30am - 2:00pm'),
('Tuesday', 'University Fitness (Wells Hall)', '7 - 9 am & 12:30 - 11 pm'),
('Tuesday', 'Weight Room / Cardio Center', '6 am - 11 pm'),
('Tuesday', 'Willie\'s', '7:00am - 5:00pm'),
('Wednesday', 'Cafe at the Center of the Arts', '8:00am - 3:00pm'),
('Wednesday', 'Deliotte Cafe', '7:30am - 2:00pm'),
('Wednesday', 'DLK Gym (Main)', '8:30 - 11 am & 6:30 - 8:30 pm'),
('Wednesday', 'Drumlin C-Store', '8:00am - 10:00pm'),
('Wednesday', 'Drumlin Dining Hall', '11:00am - 2:00pm'),
('Wednesday', 'Einstein Bros. Bagels', '8:00am - 4:00pm'),
('Wednesday', 'Erbert & Gerbert\'s in Drumlin', '11:00am - 10:00pm'),
('Wednesday', 'Esker C-Store', '11:00am - 10:00pm'),
('Wednesday', 'Esker Dining Hall', '11:00am - 2:00pm & 4:00pm - 7:30pm'),
('Wednesday', 'Food for Thought', '8:30am - 4:00pm'),
('Wednesday', 'h\'EAT & Fire', '11:00am - 10:00pm'),
('Wednesday', 'Ike Schaffer Commons', '7:30am - 10:30am'),
('Wednesday', 'Kachel Fieldhouse', '8 am - 2 pm & 7 - 11 pm'),
('Wednesday', 'Kachel Track', '8 am - 2 pm & 7 - 11 pm'),
('Wednesday', 'La Pradera', '7:30am - 9:30am & 11:00am - 11:00pm'),
('Wednesday', 'Pak\'s Sushi & Poke Station', '10:45am - 4:00pm'),
('Wednesday', 'Pool', '11 am - 1 pm & 7 - 9 pm'),
('Wednesday', 'Racquetball Courts', '8 am - 11 pm'),
('Wednesday', 'Russell Volleyball Arena', '8 - 10 am & 11 am - 1 pm & 6 - 11 pm'),
('Wednesday', 'Sideline Cafe', '7:30am - 2:00pm'),
('Wednesday', 'University Fitness (Wells Hall)', '7 - 9 am & 12:30 - 11 pm'),
('Wednesday', 'Weight Room / Cardio Center', '6 am - 11 pm'),
('Wednesday', 'Willie\'s', '7:00am - 5:00pm');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `startTime` datetime DEFAULT NULL,
  `endTime` datetime DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `netID` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE `facility` (
  `name` varchar(255) NOT NULL,
  `type` set('Dining','Fitness') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facility`
--

INSERT INTO `facility` (`name`, `type`) VALUES
('Cafe at the Center of the Arts', 'Dining'),
('Deliotte Cafe', 'Dining'),
('DLK Gym (Main)', 'Fitness'),
('Drumlin C-Store', 'Dining'),
('Drumlin Dining Hall', 'Dining'),
('Einstein Bros. Bagels', 'Dining'),
('Erbert & Gerbert\'s in Drumlin', 'Dining'),
('Esker C-Store', 'Dining'),
('Esker Dining Hall', 'Dining'),
('Food for Thought', 'Dining'),
('h\'EAT & Fire', 'Dining'),
('Ike Schaffer Commons', 'Dining'),
('Kachel Fieldhouse', 'Fitness'),
('Kachel Track', 'Fitness'),
('La Pradera', 'Dining'),
('Pak\'s Sushi & Poke Station', 'Dining'),
('Pool', 'Fitness'),
('Racquetball Courts', 'Fitness'),
('Russell Volleyball Arena', 'Fitness'),
('Sideline Cafe', 'Dining'),
('University Fitness (Wells Hall)', 'Fitness'),
('Weight Room / Cardio Center', 'Fitness'),
('Willie\'s', 'Dining');

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

CREATE TABLE `major` (
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`name`) VALUES
('ACCOUNTING (BBA)'),
('ART (BA)'),
('Art - FINE   ARTS   LICENSURE   EMPHASIS (BFA)'),
('Art - FINE  ARTS  EMPHASIS (BFA)'),
('Art - FINE  ARTS  GRAPHIC  DESIGN  EMPHASIS (BFA)'),
('ART EDUCATION (BSE)'),
('ART GRAPHIC DESIGN EMPHASIS (BA)'),
('ART HISTORY EMPHASIS (BA)'),
('ART LICENSURE EMPHASIS (BA)'),
('Biology - Ecology'),
('BIOLOGY - HONORS EMPHASIS'),
('BIOLOGY - MARINE BIOLOGY AND FRESHWATER ECOLOGY (BA/BS)'),
('BIOLOGY - PRE-BIOMEDICAL PROFESSIONS EMPHASIS'),
('Biology Education - Cell/Physiology Emphasis Requirements (BSE)'),
('Biology Education - Ecology/Field Emphasis Requirements (BSE)'),
('BIOLOGY-CELL/PHYSIOLOGY (BA/BS)'),
('BIOLOGY-EARLY ENTRANCE PRE-PROFESSIONAL EMPHASIS'),
('Business Analytics (BBA)'),
('Business Analytics - Digital Marketing Emphasis (BBA)'),
('Business Analytics - Marketing Emphasis (BBA)'),
('Business Analytics - Supply Chain Emphasis (BBA)'),
('BUSINESS AND MARKETING EDUCATION COMPREHENSIVE (BSE)'),
('BUSINESS EDUCATION (BSE)'),
('Business Education - Business and Computer Science Education Comprehensive Emphasis'),
('Business Education-Business and Marketing Education Comprehensive Emphasis - COEPS (BSE)'),
('Business Education-Marketing Education Emphasis (BSE)'),
('Business Undecided'),
('Chemistry - Analytical/Instrumental Emphasis'),
('CHEMISTRY - BIOCHEMISTRY EMPHASIS (BA/BS)'),
('CHEMISTRY - HONORS EMPHASIS (BA/BS)'),
('CHEMISTRY - LIBERAL ARTS (BA/BS)'),
('CHEMISTRY - PROFESSIONAL ACS APPROVED (BA/BS)'),
('Chemistry Education Requirements (BSE)'),
('COMMUNICATION - ELECTRONIC MEDIA EMPHASIS (BA/BS)'),
('COMMUNICATION - PUBLIC RELATIONS EMPHASIS (BA/BS)'),
('Communication -CORPORATE AND HEALTH COMMUNICATION (BA/BS)'),
('COMMUNICATION SCIENCES AND DISORDERS (BS)'),
('COMPUTER SCIENCE COMPREHENSIVE EMPHASIS (BA/BS)'),
('COMPUTER SCIENCE GENERAL EMPHASIS(BA/BS)'),
('CRIMINOLOGY (BA/BS)'),
('Cybersecurity - Comprehensive Emphasis'),
('Cybersecurity - Cyber Operations Emphasis Requirements'),
('Cybersecurity - Cybersecurity Emphasis'),
('EARLY CHILDHOOD EDUCATION (BSE)'),
('ECONOMICS (BA/BS)'),
('ECONOMICS (BBA)'),
('Economics Education Requirements (BSE)'),
('ELEMENTARY EDUCATION ELEMENTARY/MIDDLE EMPHASIS (BSE)'),
('ENGLISH CREATIVE WRITING EMPHASIS (BA/BS)'),
('ENGLISH EDUCATION (BSE)'),
('English Literature Requirements (BA/BS)'),
('ENGLISH PROFESSIONAL WRITING AND PUBLISHING BA/BS'),
('ENTREPRENEURSHIP (BBA)'),
('Environmental Science - ENVIRONMENTAL RESOURCE MANAGEMENT EMPHASIS'),
('Environmental Science - GEOSCIENCES EMPHASIS'),
('Environmental Science -NATURAL SCIENCES EMPHASIS'),
('Evolution and Behavior Emphasis Requirements (BA/BS)'),
('Film Studies Requirements (BA/BS)'),
('FINANCE (BBA)'),
('FINANCE - FINANCIAL PLANNING EMPHASIS HONORS (BBA)'),
('FINANCE - HONORS EMPHASIS (BBA)'),
('FINANCE - INSURANCE HONORS EMPHASIS (BBA)'),
('Finance - Investment Emphasis Requirements (BBA)'),
('FINANCE - REAL ESTATE HONORS EMPHASIS (BBA)'),
('FINANCE: FINANCIAL PLANNING EMPHASIS (BBA)'),
('FINANCE: INSURANCE EMPHASIS (BBA)'),
('FINANCE: REAL ESTATE EMPHASIS (BBA)'),
('FRENCH (BA/BS)'),
('FRENCH Education(BSE)'),
('General Business (BBA)'),
('General Business - Safety and Risk Management (BBA)'),
('GENERAL MANAGEMENT (BBA)'),
('General Management - Healthcare Management'),
('General Management - Managing Sports Programs Emphasis (BBA)'),
('General Management - Nonprofit Management Emphasis'),
('GEOGRAPHY Education(BSE)'),
('GEOGRAPHY GENERAL (BA/BS)'),
('GEOGRAPHY GEOLOGY EMPHASIS (BA/BS)'),
('GERMAN (BA/BS)'),
('GERMAN Education(BSE)'),
('HISTORY (BA/BS)'),
('HISTORY - HISTORY HONORS EMPHASIS (BA/BS)'),
('History - Public History Honors Emphasis Requirements (BA/BS)'),
('History Education (BSE)'),
('History Education - Honors Emphasis (BSE)'),
('HISTORY WITH PUBLIC HISTORY EMPHASIS (BA/BS)'),
('Human Performance BS'),
('HUMAN RESOURCE MANAGEMENT (BBA)'),
('INFORMATION TECHNOLOGY (BBA)'),
('INFORMATION TECHNOLOGY - BUSINESS ANALYSIS EMPHASIS (BBA)'),
('Information Technology - Business Analytics Emphasis (BBA)'),
('INFORMATION TECHNOLOGY - BUSINESS APPLICATION DEVELOPMENT EMPHASIS (BBA)'),
('INFORMATION TECHNOLOGY - NETWORKING AND SECURITY EMPHASIS (BBA)'),
('INTEGRATED SCIENCE - BUSINESS (BS)'),
('Integrated Science and Business - Water Emphasis (BBA)'),
('INTEGRATED SCIENCE-BUSINESS WATER RESOURCES EMPHASIS (BS)'),
('INTERNATIONAL BUSINESS (BBA)'),
('International Business - Global Sourcing Emphasis (BBA)'),
('International Studies - INTERNATIONAL ECONOMICS EMPHASIS'),
('INTERNATIONAL STUDIES - PUBLIC DIPLOMACY EMPHASIS'),
('INTERNATIONAL STUDIES BUSINESS EMPHASIS (BA/BS)'),
('INTERNATIONAL STUDIES: FOREIGN LANGUAGE AND AREA STUDIES EMPHASIS'),
('JAPANESE STUDIES (BA)'),
('Journalism - BROADCAST/PRINT/WEB JOURNALISM (BA/BS)'),
('JOURNALISM - INTERNATIONAL EMPHASIS (BA/BS)'),
('JOURNALISM ADVERTISING EMPHASIS (BA/BS)'),
('Legal Studies (BA/BS)'),
('LIBERAL STUDIES MAJOR WITH MINOR (BA/BS)'),
('LIBERAL STUDIES MAJOR WITH NO MINOR (BA/BS)'),
('Liberal Studies with No Minor Honors Emphasis (BA/BS)'),
('MARKETING (BBA)'),
('Marketing - Digital Marketing Emphasis Requirements (BBA)'),
('Marketing - Experiential and Sports Marketing (BBA)'),
('Marketing - Innovation and Social Enterprises (BBA)'),
('MARKETING - PROFESSIONAL SALES EMPHASIS (BBA)'),
('Marketing Retail Management Emphasis (BBA)'),
('MATHEMATICS (BA/BS)'),
('Mathematics - Actuarial Science Emphasis (BA/BS)'),
('MATHEMATICS EDUCATION (BSE)'),
('MATHEMATICS: STATISTICS EMPHASIS (BA/BS)'),
('MEDIA ARTS AND GAME DEVELOPMENT - COMMUNICATION/GAMING EMPHASIS (BA/BS)'),
('MEDIA ARTS AND GAME DEVELOPMENT - MEDIA ART EMPHASIS (BA/BS)'),
('MEDIA ARTS AND GAME DEVELOPMENT - TECHNOLOGY EMPHASIS (BA/BS)'),
('MUSIC (BA)'),
('MUSIC - CHORAL EDUCATION EMPHASIS (BM)'),
('MUSIC - GENERAL EDUCATION EMPHASIS (BM)'),
('MUSIC - INSTRUMENTAL PERFORMANCE EMPHASIS (BM)'),
('MUSIC - KEYBOARD PERFORMANCE EMPHASIS (BM)'),
('MUSIC - THEORY  EMPHASIS (BM)'),
('MUSIC - VOCAL PERFORMANCE EMPHASIS (BM)'),
('MUSIC INSTRUMENTAL EDUCATION EMPHASIS (BM)'),
('OCCUPATIONAL SAFETY (BS)'),
('OCCUPATIONAL SAFETY - ENVIRONMENTAL MANAGEMENT EMPHASIS (BS)'),
('OCCUPATIONAL SAFETY MAJOR - CONSTRUCTION SAFETY EMPHASIS (BS)'),
('PHYSICAL EDUCATION - EC-A License EMPHASIS (BSE)'),
('PHYSICS  ENGINEERING AND INDUSTRY EMPHASIS  (BA/BS)'),
('PHYSICS Education (BSE)'),
('PHYSICS GRADUATE SCHOOL EMPHASIS (BA/BS)'),
('POLITICAL SCIENCE (BA/BS)'),
('POLITICAL SCIENCE - LEGAL STUDIES EMPHASIS (BA/BS)'),
('Political Science Education (BSE)'),
('POLITICAL SCIENCE HONORS EMPHASIS (BA/BS)'),
('PSYCHOLOGY (BA/BS)'),
('PSYCHOLOGY Education (BSE)'),
('PUBLIC POLICY AND ADMINISTRATION (BS)'),
('SOCIAL STUDIES BROADFIELD - ECONOMICS I EMPHASIS (BSE)'),
('SOCIAL STUDIES BROADFIELD - ECONOMICS II EMPHASIS (BSE)'),
('Social Studies Broadfield - Geography Emphasis Requirements (BSE)'),
('SOCIAL STUDIES BROADFIELD - HISTORY EMPHASIS (BSE)*'),
('SOCIAL STUDIES BROADFIELD - POLITICAL SCIENCE EMPHASIS (BSE)'),
('SOCIAL STUDIES BROADFIELD - PSYCHOLOGY I EMPHASIS (BSE)'),
('SOCIAL STUDIES BROADFIELD - SOCIOLOGY EMPHASIS (BSE)'),
('SOCIAL WORK (BA/BS)'),
('SOCIOLOGY (BA/BS)'),
('SOCIOLOGY - HONORS EMPHASIS (BA/BS)'),
('Sociology Education (BSE)'),
('SOCIOLOGY GLOBAL COMPARATIVE STUDIES EMPHASIS (BA/BS)'),
('SPANISH (BA/BS)'),
('SPANISH Education(BSE)'),
('Special Education Major - Cross Categorical Emphasis BSE'),
('Special Education Major - Cross Categorical Program LD/EBD Emphasis Requirements (BSE)'),
('SUPPLY CHAIN AND OPERATIONS MANAGEMENT (BBA)'),
('Supply Chain and Operations Management - Global Sourcing Emphasis (BBA)'),
('Supply Chain and Operations Management - Logistics Analytics Emphasis (BBA)'),
('SUPPLY CHAIN AND OPERATIONS MANAGEMENT - PROJECT MANAGEMENT EMPHASIS (BBA)'),
('THEATRE (BA)'),
('THEATRE BFA DESIGN/TECHNOLOGY EMPHASIS'),
('THEATRE BFA MANAGEMENT/PROMOTION EMPHASIS'),
('THEATRE BFA PERFORMANCE EMPHASIS'),
('THEATRE BFA STAGE MANAGEMENT EMPHASIS'),
('THEATRE Education (BSE)'),
('WOMEN\'S and Gender STUDIES (BA/BS)');

-- --------------------------------------------------------

--
-- Table structure for table `majors_in`
--

CREATE TABLE `majors_in` (
  `netID` varchar(25) NOT NULL,
  `majorName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `minor`
--

CREATE TABLE `minor` (
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `minor`
--

INSERT INTO `minor` (`name`) VALUES
('Accounting'),
('Actuarial Mathematics'),
('Adaptive Education Licensure'),
('Advertising'),
('African American Studies'),
('Allied Health Foundations'),
('American Indian Studies'),
('Anthropology'),
('Art'),
('Art History'),
('Art Studio'),
('Arts Management'),
('Asian/Asian American Studies'),
('Athletic Coaching Education'),
('Bioinformatics'),
('Biology'),
('Biology Education'),
('Broadcast/Print/Web Requirements'),
('Business Analytics'),
('Business Law'),
('Business Law for Business Majors'),
('Chemistry'),
('Communication - General'),
('Communication Corporate'),
('Communication Electronic Media'),
('Communication Elementary Education'),
('Communication Public Relation'),
('Communication Sciences and Disorders'),
('Communication Secondary Education'),
('Computer Science'),
('Creative Writing'),
('Criminology'),
('Cybersecurity'),
('Dance'),
('Dance Secondary Education'),
('Data Science'),
('Economics'),
('Economics Education Requirements'),
('English'),
('English Education'),
('Entrepreneurship'),
('Environmental Management'),
('Environmental Studies'),
('Family'),
('Film Studies'),
('Finance'),
('French'),
('French Education'),
('Gender and Ethnic Studies'),
('General Business'),
('General Management'),
('General Science Elementary Education'),
('Geography'),
('Geography Elementary Education'),
('Geology'),
('German'),
('German Education'),
('GIS'),
('Health and Disability Studies'),
('Health Education'),
('Health Promotion'),
('History'),
('History Education'),
('Human and Social Services'),
('Human Resource Management'),
('Information Technology'),
('Integrated Marketing Communication'),
('International Business'),
('International Studies'),
('Japanese Studies'),
('Latinx/Latin American Studies'),
('Leadership and Military Science'),
('Legal Studies'),
('Liberal Studies'),
('Library Media K-12'),
('Library Science'),
('Marketing'),
('Marketing - Digital Marketing'),
('Marketing - Experiential and Sports Marketing'),
('Marketing - Innovation and Social Enterprises'),
('Marketing - Professional Sales'),
('Mathematics'),
('Mathematics - Elementary Education'),
('Mathematics - Secondary Education'),
('Media Arts and Game Development - Communication/Gaming'),
('Media Arts and Game Development - Technology'),
('Media Arts and Game Development - Visual Media Design'),
('Middle Eastern Studies'),
('Music'),
('Nonprofit Management'),
('Nonprofit Management for Business Majors'),
('Occupational Safety'),
('Philosophy'),
('Philosophy Education'),
('Physical Science'),
('Physics'),
('Physics Education'),
('Political Science'),
('Political Science Education'),
('Professional Writing and Publishing'),
('Psychology'),
('Psychology for Business Majors'),
('Psychology for Secondary Education Majors'),
('Public Administration'),
('Public Health'),
('Race and Ethnic Studies'),
('Recreation and Leisure Studies Education'),
('Recreation and Leisure Studies Letter and Science'),
('Retail Management  '),
('Social Studies Elementary Education'),
('Sociology'),
('Sociology Education'),
('Spanish'),
('Spanish Education'),
('Special Education for Non-Education Majors'),
('Sport Management'),
('Statistics'),
('Strength and Conditioning'),
('Supply Chain Management'),
('Teaching English as a Second Language'),
('Teaching English as a Second Language for Adults'),
('Teaching English as a Second Language/Bilingual-Bicultural'),
('Theatre'),
('Theatre Education'),
('Water Business'),
('Web Site Development and Administration'),
('Women\'s and Gender Studies'),
('World Religions');

-- --------------------------------------------------------

--
-- Table structure for table `minors_in`
--

CREATE TABLE `minors_in` (
  `netID` varchar(25) NOT NULL,
  `minorName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`name`) VALUES
('Campus Life Resources'),
('Career Resources'),
('Get Involved'),
('Get to Know Your Way Around Campus'),
('Graduation Resources'),
('Helpful Academic Resources'),
('Need Technical Help?'),
('Student Directory');

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `ID` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `creationTime` datetime DEFAULT NULL,
  `updateTime` datetime DEFAULT NULL,
  `netID` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reminder`
--

CREATE TABLE `reminder` (
  `ID` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `day` varchar(25) DEFAULT NULL,
  `time` time DEFAULT NULL,
  `netID` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `save`
--

CREATE TABLE `save` (
  `moduleName` varchar(255) NOT NULL,
  `netID` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tutor`
--

CREATE TABLE `tutor` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor`
--

INSERT INTO `tutor` (`ID`, `name`, `email`) VALUES
(1, 'Lauren Sankey', 'SankeyLK05@uww.edu'),
(2, 'Spencer Cooper', 'CooperK13@uww.edu'),
(3, 'Taylor Jensen', 'JensenTN03@uww.edu'),
(4, 'Eris Maag', 'MaagE24@uww.edu'),
(5, 'Noa Peller', 'PellerNC17@uww.edu'),
(6, 'Allison Steuri', 'SteuriAR11@uww.edu'),
(7, 'Natalie Tenge', 'TengeNM23@uww.edu'),
(8, 'Luke Toussaint', 'ToussainLT23@uww.edu'),
(9, 'Sarah Wendt', 'WendtSE14@uww.edu'),
(10, 'Mia Ciancio', 'CiancioMG04@uww.edu'),
(11, 'Jesse Hurst', 'HurstJF01@uww.edu'),
(12, 'Dane Crouse', 'CrouseDG08@uww.edu'),
(13, 'Jay Shorey', 'ShoreyJA12@uww.edu'),
(14, 'Jaedyn Henneberry', 'HenneberJN19@uww.edu'),
(15, 'Joseph Hanlon', 'HanlonJT27@uww.edu'),
(16, 'Hailey Meyer', 'MeyerHA28@uww.edu');

-- --------------------------------------------------------

--
-- Table structure for table `tutored_by`
--

CREATE TABLE `tutored_by` (
  `tutorID` int(11) NOT NULL,
  `netID` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tutors_for`
--

CREATE TABLE `tutors_for` (
  `tutorID` int(11) NOT NULL,
  `courseName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutors_for`
--

INSERT INTO `tutors_for` (`tutorID`, `courseName`) VALUES
(1, 'BEINDP 290'),
(2, 'BIO 141'),
(2, 'BIO 142'),
(2, 'BIO 251'),
(2, 'BIO 255'),
(2, 'BIO 380'),
(2, 'CHEM 100'),
(2, 'CHEM 102'),
(2, 'CHEM 104'),
(2, 'CHEM 260'),
(3, 'BIO 141'),
(3, 'BIO 142'),
(3, 'BIO 251'),
(3, 'BIO 253'),
(3, 'CHEM 100'),
(3, 'CHEM 102'),
(3, 'CHEM 104'),
(4, 'BIO 141'),
(4, 'BIO 142'),
(5, 'BIO 120'),
(5, 'BIO 141'),
(5, 'BIO 142'),
(5, 'BIO 190'),
(5, 'BIO 200'),
(5, 'BIO 251'),
(5, 'BIO 253'),
(5, 'BIO 254'),
(5, 'BIO 257'),
(5, 'BIO 361'),
(6, 'BIO 141'),
(6, 'BIO 142'),
(6, 'BIO 251'),
(6, 'BIO 257'),
(6, 'BIO 303'),
(6, 'CHEM 100'),
(6, 'CHEM 102'),
(6, 'CHEM 104'),
(7, 'BIO 141'),
(7, 'BIO 142'),
(7, 'BIO 200'),
(7, 'BIO 251'),
(7, 'BIO 253'),
(7, 'BIO 254'),
(7, 'BIO 311'),
(7, 'BIO 362'),
(7, 'BIO 456'),
(7, 'CHEM 102'),
(7, 'CHEM 104'),
(8, 'BIO 120'),
(8, 'BIO 141'),
(8, 'BIO 142'),
(8, 'BIO 251'),
(8, 'BIO 257'),
(8, 'CHEM 101'),
(8, 'CHEM 102'),
(8, 'CHEM 104'),
(9, 'BIO 120'),
(9, 'BIO 141'),
(9, 'BIO 142'),
(9, 'BIO 253'),
(9, 'BIO 254'),
(9, 'BIO 257'),
(9, 'BIO 311'),
(9, 'BIO 361'),
(9, 'BIO 446'),
(10, 'BIO 361'),
(11, 'COMM 110'),
(11, 'CORE 120'),
(11, 'DevEd 50'),
(11, 'DevEd 60'),
(12, 'CORE 110'),
(12, 'CORE 130'),
(12, 'CORE 140'),
(12, 'CORE 390'),
(12, 'DevEd 50'),
(12, 'DevEd 60'),
(13, 'CORE 120'),
(14, 'CORE 120'),
(15, 'DevEd 50'),
(15, 'DevEd 60'),
(16, 'DevEd 50'),
(16, 'DevEd 60');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `netID` varchar(25) NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `standing` varchar(25) DEFAULT NULL,
  `enrollmentType` varchar(25) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visit`
--

CREATE TABLE `visit` (
  `netID` varchar(25) NOT NULL,
  `facilityName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `day`
--
ALTER TABLE `day`
  ADD PRIMARY KEY (`dayName`,`facilityName`),
  ADD KEY `facilityName` (`facilityName`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `netID` (`netID`);

--
-- Indexes for table `facility`
--
ALTER TABLE `facility`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `major`
--
ALTER TABLE `major`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `majors_in`
--
ALTER TABLE `majors_in`
  ADD PRIMARY KEY (`netID`,`majorName`),
  ADD KEY `majorName` (`majorName`);

--
-- Indexes for table `minor`
--
ALTER TABLE `minor`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `minors_in`
--
ALTER TABLE `minors_in`
  ADD PRIMARY KEY (`netID`,`minorName`),
  ADD KEY `minorName` (`minorName`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `netID` (`netID`);

--
-- Indexes for table `reminder`
--
ALTER TABLE `reminder`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `netID` (`netID`);

--
-- Indexes for table `save`
--
ALTER TABLE `save`
  ADD PRIMARY KEY (`moduleName`,`netID`),
  ADD KEY `netID` (`netID`);

--
-- Indexes for table `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tutored_by`
--
ALTER TABLE `tutored_by`
  ADD PRIMARY KEY (`tutorID`,`netID`),
  ADD KEY `netID` (`netID`);

--
-- Indexes for table `tutors_for`
--
ALTER TABLE `tutors_for`
  ADD PRIMARY KEY (`tutorID`,`courseName`),
  ADD KEY `courseName` (`courseName`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`netID`);

--
-- Indexes for table `visit`
--
ALTER TABLE `visit`
  ADD PRIMARY KEY (`netID`,`facilityName`),
  ADD KEY `facilityName` (`facilityName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reminder`
--
ALTER TABLE `reminder`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tutor`
--
ALTER TABLE `tutor`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `day`
--
ALTER TABLE `day`
  ADD CONSTRAINT `day_ibfk_1` FOREIGN KEY (`facilityName`) REFERENCES `facility` (`name`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`netID`) REFERENCES `user` (`netID`);

--
-- Constraints for table `majors_in`
--
ALTER TABLE `majors_in`
  ADD CONSTRAINT `majors_in_ibfk_1` FOREIGN KEY (`netID`) REFERENCES `user` (`netID`),
  ADD CONSTRAINT `majors_in_ibfk_2` FOREIGN KEY (`majorName`) REFERENCES `major` (`name`);

--
-- Constraints for table `minors_in`
--
ALTER TABLE `minors_in`
  ADD CONSTRAINT `minors_in_ibfk_1` FOREIGN KEY (`netID`) REFERENCES `user` (`netID`),
  ADD CONSTRAINT `minors_in_ibfk_2` FOREIGN KEY (`minorName`) REFERENCES `minor` (`name`);

--
-- Constraints for table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`netID`) REFERENCES `user` (`netID`);

--
-- Constraints for table `reminder`
--
ALTER TABLE `reminder`
  ADD CONSTRAINT `reminder_ibfk_1` FOREIGN KEY (`netID`) REFERENCES `user` (`netID`);

--
-- Constraints for table `save`
--
ALTER TABLE `save`
  ADD CONSTRAINT `save_ibfk_1` FOREIGN KEY (`moduleName`) REFERENCES `module` (`name`),
  ADD CONSTRAINT `save_ibfk_2` FOREIGN KEY (`netID`) REFERENCES `user` (`netID`);

--
-- Constraints for table `tutored_by`
--
ALTER TABLE `tutored_by`
  ADD CONSTRAINT `tutored_by_ibfk_1` FOREIGN KEY (`tutorID`) REFERENCES `tutor` (`ID`),
  ADD CONSTRAINT `tutored_by_ibfk_2` FOREIGN KEY (`netID`) REFERENCES `user` (`netID`);

--
-- Constraints for table `tutors_for`
--
ALTER TABLE `tutors_for`
  ADD CONSTRAINT `tutors_for_ibfk_1` FOREIGN KEY (`tutorID`) REFERENCES `tutor` (`ID`),
  ADD CONSTRAINT `tutors_for_ibfk_2` FOREIGN KEY (`courseName`) REFERENCES `course` (`name`);

--
-- Constraints for table `visit`
--
ALTER TABLE `visit`
  ADD CONSTRAINT `visit_ibfk_1` FOREIGN KEY (`netID`) REFERENCES `user` (`netID`),
  ADD CONSTRAINT `visit_ibfk_2` FOREIGN KEY (`facilityName`) REFERENCES `facility` (`name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
