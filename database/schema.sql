-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2026 at 07:59 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `faculty_directory`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'bcrypt hash',
  `role` varchar(100) NOT NULL DEFAULT 'Administrator'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'Admin', 'admin@university.edu', '$2a$12$R.OWSmqYZhkFmubTFWgL4u60qD3.EKHhxX3Fu9fMgYMAzyRitZhXa', 'Administrator'),
(2, 'Fazal Abbas', 'fazal@gmail.com', '$2a$12$MYefIGLA8.PvNU6AFhFuCuvg4q.vNyWz55UI/GwVvoEKjYR853U2m', 'Super Admin');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `ID` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `detail` text NOT NULL,
  `date` varchar(20) NOT NULL,
  `user` varchar(100) NOT NULL COMMENT 'Publisher name',
  `category` varchar(255) NOT NULL COMMENT 'Audience: All Students / All Teachers / email',
  `role` varchar(100) NOT NULL COMMENT 'Publisher role'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`ID`, `subject`, `detail`, `date`, `user`, `category`, `role`) VALUES
(1, 'Mid-Term Examination Schedule Released', 'The mid-term examination schedule for the Spring 2026 semester has been finalized. All students are advised to check the academic portal for their individual timetables. Examinations will commence from 15-Jun-2026. No requests for rescheduling will be entertained after 10-Jun-2026.', '01-Jun-2026', 'Sarmad Ali', 'All Students', 'Administrator'),
(2, 'Library Timings Extended During Exams', 'To support students during the examination period, the central library will remain open until 11:00 PM from 10-Jun-2026 to 30-Jun-2026. Students are required to carry their university ID cards for entry.', '02-Jun-2026', 'Sarmad Ali', 'All Students', 'Administrator'),
(3, 'Student Portal Maintenance Notice', 'The student online portal will undergo scheduled maintenance on 08-Jun-2026 from 12:00 AM to 4:00 AM. During this window, result checking, fee payment, and course registration services will be unavailable. We apologize for any inconvenience.', '03-Jun-2026', 'Ayesha Khan', 'All Students', 'Super Admin'),
(4, 'Faculty Meeting â€” Academic Calendar Review', 'All faculty members are requested to attend a mandatory meeting on 10-Jun-2026 at 10:00 AM in the Main Conference Hall (Block A, Room 201). The agenda includes reviewing the academic calendar for the Fall 2026 semester and discussing the updated grading policy.', '01-Jun-2026', 'Sarmad Ali', 'All Teachers', 'Administrator'),
(5, 'Submission Deadline: Final Grade Sheets', 'All faculty are reminded that the deadline for submitting final grade sheets for the Spring 2026 semester is 25-Jun-2026. Grades must be entered into the academic management system before 5:00 PM. Late submissions will not be accepted.', '04-Jun-2026', 'Ayesha Khan', 'All Teachers', 'Super Admin'),
(6, 'Research Grant Applications Open', 'The university research committee is inviting applications for internal research grants for the academic year 2026-2027. Faculty members with ongoing or proposed research projects are encouraged to apply. Application forms and guidelines are available on the faculty portal. Deadline: 30-Jun-2026.', '05-Jun-2026', 'Sarmad Ali', 'All Teachers', 'Administrator'),
(7, 'Your Course Registration Confirmed', 'Dear Ali Hassan, your course registration for the Spring 2026 semester has been successfully confirmed. You are enrolled in 5 courses totalling 18 credit hours. Please ensure your fee challan is submitted before the due date to avoid de-enrollment.', '02-Jun-2026', 'Ayesha Khan', 'ali.hassan@student.edu', 'Super Admin'),
(8, 'Reminder: Project Submission Due', 'Dear Fatima Zahra, this is a reminder that your final year project report submission is due on 12-Jun-2026. Please ensure you submit both the soft copy via the portal and the hard copy to the department office by 3:00 PM.', '03-Jun-2026', 'Sarmad Ali', 'fatima.zahra@student.edu', 'Administrator'),
(9, 'Office Hour Change Notification', 'Dear Dr. Ahmed Raza, please note that your Wednesday office hours have been shifted from 2:00 PM to 4:00 PM effective from next week, due to the room booking conflict in Block B. Your updated schedule has been reflected in the faculty directory.', '04-Jun-2026', 'Sarmad Ali', 'ahmed.raza@university.edu', 'Administrator'),
(10, 'Workshop Invitation: Modern Teaching Methodologies', 'Dear Prof. Sara Malik, you have been selected to attend a two-day workshop on Modern Teaching Methodologies being held on 14-15 Jun-2026 at the Faculty Development Centre. Please confirm your attendance by replying to this notice before 11-Jun-2026.', '05-Jun-2026', 'Ayesha Khan', 'sara.malik@university.edu', 'Super Admin');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(100) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_password` varchar(255) NOT NULL COMMENT 'bcrypt hash',
  `u_type` enum('Student','Teacher','Admin') NOT NULL,
  `status` enum('Pending','Accepted','Rejected') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`u_id`, `u_name`, `u_email`, `u_password`, `u_type`, `status`) VALUES
(1, 'Prof. Ahmed Raza', 'ahmed.raza@university.edu', '$2a$12$qJFz5GcnVVxHJEgV28IBN.H5M/H7lY7TwO59ZWdH00/.VF1aSjHDe', 'Teacher', 'Accepted'),
(2, 'Prof. Sara Malik', 'sara.malik@university.edu', '$2a$12$qJFz5GcnVVxHJEgV28IBN.H5M/H7lY7TwO59ZWdH00/.VF1aSjHDe', 'Teacher', 'Accepted'),
(3, 'Usman Tariq', 'usman.tariq@university.edu', '$2a$12$qJFz5GcnVVxHJEgV28IBN.H5M/H7lY7TwO59ZWdH00/.VF1aSjHDe', 'Teacher', 'Accepted'),
(4, 'Ms. Nadia Hussain', 'nadia.hussain@university.edu', '$2a$12$qJFz5GcnVVxHJEgV28IBN.H5M/H7lY7TwO59ZWdH00/.VF1aSjHDe', 'Teacher', 'Accepted'),
(5, 'Ali Hassan', 'ali.hassan@student.edu', '$2a$12$qJFz5GcnVVxHJEgV28IBN.H5M/H7lY7TwO59ZWdH00/.VF1aSjHDe', 'Student', 'Accepted'),
(6, 'Fatima Zahra', 'fatima.zahra@student.edu', '$2a$12$qJFz5GcnVVxHJEgV28IBN.H5M/H7lY7TwO59ZWdH00/.VF1aSjHDe', 'Student', 'Accepted'),
(7, 'Bilal Ahmed', 'bilal.ahmed@student.edu', '$2a$12$qJFz5GcnVVxHJEgV28IBN.H5M/H7lY7TwO59ZWdH00/.VF1aSjHDe', 'Student', 'Accepted'),
(8, 'Zainab Iqbal', 'zainab.iqbal@student.edu', '$2a$12$qJFz5GcnVVxHJEgV28IBN.H5M/H7lY7TwO59ZWdH00/.VF1aSjHDe', 'Student', 'Accepted'),
(9, 'Hassan Nawaz', 'hassan.nawaz@student.edu', '$2a$12$qJFz5GcnVVxHJEgV28IBN.H5M/H7lY7TwO59ZWdH00/.VF1aSjHDe', 'Student', 'Accepted'),
(10, 'Mariam Butt', 'mariam.butt@student.edu', '$2a$12$qJFz5GcnVVxHJEgV28IBN.H5M/H7lY7TwO59ZWdH00/.VF1aSjHDe', 'Student', 'Accepted'),
(11, 'Omar Farooq', 'omar.farooq@student.edu', '$2a$12$qJFz5GcnVVxHJEgV28IBN.H5M/H7lY7TwO59ZWdH00/.VF1aSjHDe', 'Student', 'Accepted'),
(12, 'Hira Baig', 'hira.baig@student.edu', '$2a$12$qJFz5GcnVVxHJEgV28IBN.H5M/H7lY7TwO59ZWdH00/.VF1aSjHDe', 'Student', 'Pending'),
(13, 'Prof. Kamran Shahid', 'kamran.shahid@university.edu', '$2a$12$qJFz5GcnVVxHJEgV28IBN.H5M/H7lY7TwO59ZWdH00/.VF1aSjHDe', 'Teacher', 'Pending'),
(14, 'Sana Mirza', 'sana.mirza@student.edu', '$2a$12$qJFz5GcnVVxHJEgV28IBN.H5M/H7lY7TwO59ZWdH00/.VF1aSjHDe', 'Student', 'Rejected'),
(35, 'Azhar', 'azhar@gmail.com', '$2a$12$qJFz5GcnVVxHJEgV28IBN.H5M/H7lY7TwO59ZWdH00/.VF1aSjHDe', 'Student', 'Accepted');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `u_email` (`u_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
