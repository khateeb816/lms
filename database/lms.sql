-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2024 at 03:53 PM
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
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` int(50) NOT NULL,
  `user_id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'unread',
  `created_at` varchar(255) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`id`, `user_id`, `title`, `message`, `status`, `created_at`) VALUES
(1, 11, '', 'You have pending fee', 'read', '2024-12-23 18:09:30'),
(2, 11, 'title', 'message', 'read', '2024-12-23 18:09:30'),
(3, 11, 'title', 'message', 'read', '2024-12-23 18:09:30'),
(4, 16, 'titellle', 'message 3', 'unread', '2024-12-23 18:09:30'),
(5, 16, 'titellle', 'message 3', 'unread', '2024-12-23 18:09:30'),
(6, 12, 'This is title', 'This is test message', 'read', '2024-12-23 18:10:14'),
(7, 12, 'Hey', 'This is your warning about', 'read', '2024-12-23 18:25:52'),
(8, 10, 'this is test', 'this is test', 'read', '2024-12-24 16:04:32'),
(9, 11, '', 'You have pending fee', 'read', '2024-12-26 12:29:26'),
(10, 10, 'test', 'this is test', 'read', '2024-12-26 12:37:29'),
(11, 10, 'test', 'test', 'read', '2024-12-26 13:30:20'),
(12, 10, 'titel', 'ti;e', 'read', '2024-12-26 13:31:09'),
(13, 10, 'student', 'test', 'read', '2024-12-26 13:33:21'),
(14, 10, 'hi', 'hi', 'read', '2024-12-28 18:34:15'),
(15, 17, '', 'You have pending fee', 'read', '2024-12-28 18:59:15');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(50) NOT NULL,
  `message` varchar(255) NOT NULL,
  `deadline` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `title` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `message`, `deadline`, `created_at`, `title`, `status`) VALUES
(1, 'Hey this is announcement', '2024-12-29T19:21', '2024-12-28 19:21:10', 'Announcement 1', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(50) NOT NULL,
  `file` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `title` varchar(255) NOT NULL,
  `teacher_id` int(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `course_id` int(50) NOT NULL,
  `deadline` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `file`, `created_at`, `title`, `teacher_id`, `description`, `status`, `course_id`, `deadline`) VALUES
(10, 'uploads/676d213da37fc.docx', '2024-12-26 14:26:21', 'assignment 1', 13, 'desc', 'pending', 1, '2024-12-27T14:26'),
(11, 'uploads/676d21a9747ed.docx', '2024-12-26 14:28:09', 'assignment mth401', 13, 'desc', 'pending', 4, '2024-12-27T14:28');

-- --------------------------------------------------------

--
-- Table structure for table `assignment_submissions`
--

CREATE TABLE `assignment_submissions` (
  `id` int(50) NOT NULL,
  `assignment_id` int(50) NOT NULL,
  `student_id` int(50) NOT NULL,
  `created_at` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `file` varchar(255) NOT NULL,
  `marks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignment_submissions`
--

INSERT INTO `assignment_submissions` (`id`, `assignment_id`, `student_id`, `created_at`, `file`, `marks`) VALUES
(4, 11, 10, '2024-12-26 15:23:31', 'assignmentSolutions/BC210409486.docx', '10');

-- --------------------------------------------------------

--
-- Table structure for table `attendence`
--

CREATE TABLE `attendence` (
  `id` int(255) NOT NULL,
  `Date` date NOT NULL,
  `teacher_id` int(255) NOT NULL,
  `semester_id` int(255) NOT NULL,
  `student_id` int(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendence`
--

INSERT INTO `attendence` (`id`, `Date`, `teacher_id`, `semester_id`, `student_id`, `status`) VALUES
(7, '2024-12-23', 12, 1, 10, 'absent'),
(8, '2024-12-23', 12, 1, 16, 'present'),
(9, '2024-12-23', 12, 1, 17, 'leave'),
(10, '2024-12-24', 12, 1, 10, 'present'),
(11, '2024-12-24', 12, 1, 16, 'absent'),
(12, '2024-12-24', 12, 1, 17, 'leave'),
(13, '2024-12-26', 13, 1, 11, 'present'),
(14, '2024-12-28', 13, 1, 10, 'present'),
(15, '2024-12-28', 13, 1, 17, 'present');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `semester_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `title`, `description`, `semester_id`) VALUES
(1, 'BSCS', 'Bacholour in computer science', 1);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `teacher_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `created_at`, `status`, `teacher_id`) VALUES
(1, 'course 1', 'this is course 1', '10', 'active', '12,13'),
(4, 'MTH401', 'This is maths course', '2024-12-21 12:55:46', 'active', '12,13');

-- --------------------------------------------------------

--
-- Table structure for table `fee_vouchers`
--

CREATE TABLE `fee_vouchers` (
  `id` int(50) NOT NULL,
  `tracking_id` varchar(255) NOT NULL,
  `unpaid` int(255) NOT NULL,
  `paid` int(255) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fines`
--

CREATE TABLE `fines` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `amount` int(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fines`
--

INSERT INTO `fines` (`id`, `user_id`, `amount`, `reason`, `created_at`) VALUES
(2, 10, 150, 'no reason', '2024-12-28 19:01:45');

-- --------------------------------------------------------

--
-- Table structure for table `live_chat`
--

CREATE TABLE `live_chat` (
  `id` int(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `teacher_id` int(255) NOT NULL,
  `student_id` int(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `live_chat`
--

INSERT INTO `live_chat` (`id`, `message`, `teacher_id`, `student_id`, `sender`, `created_at`) VALUES
(1, 'hello', 12, 10, 'teacher', '2024-12-24 14:21:21'),
(2, 'this is test', 12, 10, 'teacher', '2024-12-24 14:21:40'),
(3, 'hi this is student', 12, 10, 'student', '2024-12-24 16:08:50');

-- --------------------------------------------------------

--
-- Table structure for table `quizes`
--

CREATE TABLE `quizes` (
  `id` int(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `question` varchar(255) NOT NULL,
  `options` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `teacher_id` int(50) NOT NULL,
  `created_at` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `deadline` varchar(255) NOT NULL,
  `course_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizes`
--

INSERT INTO `quizes` (`id`, `title`, `question`, `options`, `status`, `teacher_id`, `created_at`, `deadline`, `course_id`) VALUES
(1, 'Quiz 1', 'this is question', 'a,b,c,d', 'active', 12, '2024-12-24 13:54:53', '2024-12-26', 1),
(2, 'quiz 2', 'this is active', 'ss,d,g,hg', 'completed', 12, '2024-12-24 15:03:09', '2024-12-26', 1),
(3, 'quiz 3', 'this is completed', 't,gv,jh,kj', 'completed', 12, '2024-12-24 15:03:23', '2024-12-26', 1),
(6, 'title', 'desc', '1,1,1,1', 'active', 13, '2024-12-26 14:23:41', '2024-12-27T14:23', 1),
(7, 'quiz 1', 'quiz', '1,2,4,3', 'active', 13, '2024-12-26 14:33:14', '2024-12-27T14:31', 4);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_submissions`
--

CREATE TABLE `quiz_submissions` (
  `id` int(255) NOT NULL,
  `quiz_id` int(255) NOT NULL,
  `student_id` int(255) NOT NULL,
  `selected_option` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `marks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_submissions`
--

INSERT INTO `quiz_submissions` (`id`, `quiz_id`, `student_id`, `selected_option`, `created_at`, `marks`) VALUES
(2, 2, 10, 'd', '2024-12-24 15:29:12', ''),
(3, 3, 10, 'jh', '2024-12-24 16:02:05', ''),
(4, 1, 10, 'b', '2024-12-24 16:02:08', ''),
(5, 4, 11, 'p', '2024-12-26 12:44:07', ''),
(6, 7, 10, '2', '2024-12-26 14:50:23', '1'),
(7, 6, 10, '1', '2024-12-26 14:50:27', '1');

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `fees` int(255) NOT NULL,
  `courses` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` varchar(255) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semesters`
--

INSERT INTO `semesters` (`id`, `title`, `fees`, `courses`, `description`, `status`, `created_at`) VALUES
(1, 'BSCS Semester 1', 28000, '4', '', 'active', '2024-12-21 14:12:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'student',
  `email` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `profile` varchar(255) NOT NULL,
  `semester_id` int(255) NOT NULL DEFAULT 1,
  `fee_status` varchar(255) NOT NULL DEFAULT 'unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `email`, `number`, `password`, `created_at`, `status`, `profile`, `semester_id`, `fee_status`) VALUES
(9, 'Muhammad Khateeb', 'admin', 'khateebfareed114582@gmail.com', '0030', '$2y$10$qP7ho7tf9gwfqTvk18.vBeJ6qrhusJe.qBzHKyNIqvH0dpLtFjoy2', '2024-12-18 16:00:41', 'active', 'images/users/6762ab5902a98.jpg', 1, 'unpaid'),
(10, 'Muhammad Khateeb', 'student', 'student1@gmail.com', '03481156978', '$2y$10$qP7ho7tf9gwfqTvk18.vBeJ6qrhusJe.qBzHKyNIqvH0dpLtFjoy2', '2024-12-18 16:12:53', 'active', './images/users/6762ae353e0d2.png', 1, 'paid'),
(12, 'teacher 1', 'teacher', 'teacher1@gmail.com', '03481156978', '$2y$10$qP7ho7tf9gwfqTvk18.vBeJ6qrhusJe.qBzHKyNIqvH0dpLtFjoy2', '2024-12-18 16:13:52', 'pending', './images/users/6762ae6fafbac.jpg', 0, 'unpaid'),
(13, 'Muhammad Khateeb', 'teacher', 'teacher2@gmail.com', '03481156978', '$2y$10$qP7ho7tf9gwfqTvk18.vBeJ6qrhusJe.qBzHKyNIqvH0dpLtFjoy2', '2024-12-18 16:14:22', 'active', './images/users/6762ae8dc44fb.png', 0, 'unpaid'),
(14, 'Muhammad Khateeb', 'management', 'management1@gmail.com', '03481156978', '$2y$10$qP7ho7tf9gwfqTvk18.vBeJ6qrhusJe.qBzHKyNIqvH0dpLtFjoy2', '2024-12-18 16:15:38', 'active', './images/users/6762aeda5c1cf.png', 0, 'unpaid'),
(15, 'Muhammad Khateeb', 'management', 'management2@gmail.com', '03481156978', '$2y$10$qP7ho7tf9gwfqTvk18.vBeJ6qrhusJe.qBzHKyNIqvH0dpLtFjoy2', '2024-12-18 16:16:04', 'active', './images/users/6762aef47c541.png', 0, 'unpaid'),
(17, 'Muhammad Khateeb', 'student', 'student3@gmail.com', '03481156978', '$2y$10$qP7ho7tf9gwfqTvk18.vBeJ6qrhusJe.qBzHKyNIqvH0dpLtFjoy2', '2024-12-18 17:57:35', 'active', './images/users/6762c6bf797c9.png', 1, 'unpaid'),
(18, 'management', 'management', 'maki@spicysoda.com', '03481156978', '$2y$10$qP7ho7tf9gwfqTvk18.vBeJ6qrhusJe.qBzHKyNIqvH0dpLtFjoy2', '2024-12-18 17:58:18', 'active', './images/users/6762c6eac3340.png', 0, 'unpaid');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendence`
--
ALTER TABLE `attendence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee_vouchers`
--
ALTER TABLE `fee_vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fines`
--
ALTER TABLE `fines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `live_chat`
--
ALTER TABLE `live_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quizes`
--
ALTER TABLE `quizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `attendence`
--
ALTER TABLE `attendence`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fee_vouchers`
--
ALTER TABLE `fee_vouchers`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fines`
--
ALTER TABLE `fines`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `live_chat`
--
ALTER TABLE `live_chat`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quizes`
--
ALTER TABLE `quizes`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
