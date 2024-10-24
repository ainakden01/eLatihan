-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2024 at 08:33 AM
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
-- Database: `internn`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password_hash`) VALUES
(3, 'admin@admin', '$2y$10$Sq7Jmxx5IM9YqVDkUfVOWujdVXoG5qPNOkcpnuv1OY08OBS/pIrBC');

-- --------------------------------------------------------

--
-- Table structure for table `internship_applications`
--

CREATE TABLE `internship_applications` (
  `application_id` varchar(10) NOT NULL,
  `borang_sokongan` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama_pegawai` varchar(255) DEFAULT NULL,
  `appeal_status` enum('Tiada','Dalam Proses','Lulus','Tidak Lulus') DEFAULT 'Tiada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `internship_applications`
--

INSERT INTO `internship_applications` (`application_id`, `borang_sokongan`, `start_date`, `end_date`, `user_id`, `nama_pegawai`, `appeal_status`) VALUES
('LIUU-001', 'Aiman-BORANG PENILAIAN PENCAPAIAN OUTPUT JUN 2024.pdf', '2024-07-19', '2024-09-17', 1, NULL, 'Tiada'),
('LIUU-003', 'Salinan IC .pdf', '2024-07-16', '2024-09-26', 1, NULL, 'Tiada'),
('LIUU-004', 'Preview Application.pdf', '2024-07-18', '2024-08-23', 1, NULL, 'Tiada'),
('LIUU-005', 'Preview Application.pdf', '2024-07-18', '2024-07-18', 1, NULL, 'Tiada'),
('LIUU-006', 'eStatement-202405_20240624155341.pdf', '2024-07-18', '2024-07-31', 1, NULL, 'Tiada'),
('LIUU-007', '1721629503_Salinan IC .pdf', '2024-07-16', '2024-09-25', 1, NULL, 'Tiada'),
('LIUU-008', '1721629956_Salinan IC .pdf', '2024-07-23', '2024-09-16', 1, NULL, 'Tiada'),
('LIUU-009', '1721630527_Salinan IC .pdf', '2024-07-16', '2024-12-17', 6, NULL, 'Tiada'),
('LIUU-010', '1722500200_SENARAI SISTEM.pdf', '2024-08-09', '2024-10-10', 8, NULL, 'Tiada'),
('LIUU-011', '1722501027_Dokumentasi Sistem Epertukaran.pdf', '2024-08-09', '2024-08-31', 8, NULL, 'Tiada'),
('LIUU-012', '1723532562_Offer Letter.pdf', '2024-08-21', '2024-09-18', 1, NULL, 'Tiada'),
('LIUU-013', '1723533179_Offer Letter.pdf', '2024-08-14', '2024-09-11', 1, NULL, 'Tiada'),
('LIUU-014', '1723533249_Offer Letter.pdf', '2024-08-14', '2024-09-11', 1, NULL, 'Tiada'),
('LIUU-015', '1723533250_Offer Letter.pdf', '2024-08-14', '2024-09-11', 1, NULL, 'Tiada'),
('LIUU-016', '1723533250_Offer Letter.pdf', '2024-08-14', '2024-09-11', 1, NULL, 'Tiada'),
('LIUU-017', '1723533250_Offer Letter.pdf', '2024-08-14', '2024-09-11', 1, NULL, 'Tiada'),
('LIUU-018', '1723533273_Offer Letter.pdf', '2024-08-14', '2024-09-11', 1, NULL, 'Tiada'),
('LIUU-019', '1723533273_Offer Letter.pdf', '2024-08-14', '2024-09-11', 1, NULL, 'Tiada'),
('LIUU-020', '1723533284_Offer Letter.pdf', '2024-08-14', '2024-09-11', 1, NULL, 'Tiada'),
('LIUU-021', '1723533307_Offer Letter.pdf', '2024-08-14', '2024-09-11', 1, NULL, 'Tiada'),
('LIUU-022', '1723533308_Offer Letter.pdf', '2024-08-14', '2024-09-11', 1, NULL, 'Tiada'),
('LIUU-023', '1723533309_Offer Letter.pdf', '2024-08-14', '2024-09-11', 1, NULL, 'Tiada'),
('LIUU-024', '1723533309_Offer Letter.pdf', '2024-08-14', '2024-09-11', 1, NULL, 'Tiada'),
('LIUU-025', '1723533327_Offer Letter.pdf', '2024-08-14', '2024-09-11', 1, NULL, 'Tiada'),
('LIUU-026', '1723533328_Offer Letter.pdf', '2024-08-14', '2024-09-11', 1, NULL, 'Tiada'),
('LIUU-027', '1723533328_Offer Letter.pdf', '2024-08-14', '2024-09-11', 1, NULL, 'Tiada'),
('LIUU-028', '1723533328_Offer Letter.pdf', '2024-08-14', '2024-09-11', 1, NULL, 'Tiada'),
('LIUU-029', '1723533604_Salinan IC  (2).pdf', '2024-08-14', '2024-09-20', 1, NULL, 'Tiada'),
('LIUU-030', '1723533862_Sijil Tamat Belajar Diploma.pdf', '2024-08-14', '2024-12-11', 1, NULL, 'Tiada'),
('LIUU-031', '1723538226_Salinan IC  (2).pdf', '2024-08-15', '2024-10-23', 1, NULL, 'Tiada'),
('LIUU-032', '1723538453_Offer Letter.pdf', '2024-08-16', '2024-12-25', 1, NULL, 'Tiada'),
('LIUU-033', '1723538595_Offer Letter.pdf', '2024-08-16', '2024-08-30', 1, NULL, 'Tiada'),
('LIUU-034', '1723538688_Salinan IC .pdf', '2024-08-16', '2024-08-15', 1, NULL, 'Tiada'),
('LIUU-035', '1723538901_Salinan IC .pdf', '2024-08-16', '2024-08-15', 1, NULL, 'Tiada'),
('LIUU-036', '1723538904_Salinan IC .pdf', '2024-08-16', '2024-08-15', 1, NULL, 'Tiada'),
('LIUU-037', '1723538940_Salinan IC  (2).pdf', '2024-08-14', '2024-08-15', 1, NULL, 'Tiada'),
('LIUU-038', '1723539161_Salinan IC  (2).pdf', '2024-08-14', '2024-08-15', 1, NULL, 'Tiada'),
('LIUU-039', '1723539290_Salinan IC  (2).pdf', '2024-08-21', '2024-08-29', 1, NULL, 'Tiada'),
('LIUU-040', '1723555153_Salinan IC  (2).pdf', '2024-08-21', '2024-08-29', 1, NULL, 'Tiada'),
('LIUU-041', '1723555221_Salinan IC  (2).pdf', '2024-08-16', '2024-09-25', 1, NULL, 'Tiada'),
('LIUU-042', '1723555933_Salinan IC  (2).pdf', '2024-08-13', '2024-08-30', 1, NULL, 'Tiada'),
('LIUU-043', '1723556453_Preview Application.pdf', '2024-08-15', '2024-10-17', 1, NULL, 'Tiada'),
('LIUU-044', '1723557355_Salinan IC  (2).pdf', '2024-08-13', '2024-08-13', 1, NULL, 'Tiada'),
('LIUU-045', '1723619234_Final Project IoT Rahimi 2.pdf', '2024-08-15', '2024-12-19', 1, NULL, 'Tiada'),
('LIUU-046', '1723620779_NAK PRINT.pdf', '2024-09-01', '2024-11-01', 8, NULL, 'Tiada'),
('LIUU-047', '1723620900_final project report iot rahimi.pdf', '2024-08-14', '2024-08-14', 8, NULL, 'Tiada'),
('LIUU-048', '1723682937_TestingPDF.pdf', '2024-08-15', '2024-10-15', 9, NULL, 'Tiada'),
('LIUU-049', '1723686465_1723682937_TestingPDF.pdf', '2024-08-15', '2024-10-22', 9, NULL, 'Tiada'),
('LIUU-050', '1725435622_BORANG KELULUSAN KETUA JABATAN BAGI PERJALANAN MELEBIHI 240 KM KEW JPM 002.docx', '2024-09-04', '2024-11-14', 1, NULL, 'Tiada'),
('LIUU-051', '1725846861_tng_ewallet_transactions.pdf', '2024-09-12', '2024-11-21', 9, NULL, 'Tiada'),
('LIUU-052', '1725847738_Application_Report_LIUU-048.pdf', '2024-10-15', '2024-11-20', 9, NULL, 'Tiada'),
('LIUU-053', '1725869555_Application_Report_LIUU-048 (1).pdf', '2024-09-10', '2024-09-20', 9, NULL, 'Tiada'),
('LIUU-054', '1726037111_1723682937_TestingPDF.pdf', '2024-09-12', '2025-01-16', 9, NULL, 'Tiada'),
('LIUU-055', '1726038942_1723682937_TestingPDF.pdf', '2024-09-11', '2024-11-20', 9, NULL, 'Tiada'),
('LIUU-056', '1726103965_1723682937_TestingPDF.pdf', '2024-09-12', '2024-11-13', 9, NULL, 'Tiada'),
('LIUU-057', '1726130716_Application_Report_LIUU-048.pdf', '2024-09-09', '2025-02-20', 9, NULL, 'Tiada'),
('LIUU-058', '1726730773_Laporan_Permohonan_LIUU-004.pdf', '2024-09-19', '2024-09-26', 11, NULL, 'Tiada'),
('LIUU-059', '1728352195_dummies.pdf', '2024-10-10', '2025-10-10', 9, NULL, 'Tiada'),
('LIUU-060', '1728441928_dummies.pdf', '2024-10-09', '2024-10-10', 9, NULL, 'Tiada'),
('LIUU-061', '1728526551_dummies.pdf', '2024-10-10', '2024-10-11', 9, NULL, 'Tiada'),
('LIUU-062', '1728546452_dummies.pdf', '2024-10-10', '2024-10-11', 9, NULL, 'Tiada'),
('LIUU-063', '1728548655_dummies.pdf', '2024-10-10', '2024-10-11', 9, NULL, 'Tiada'),
('LIUU-064', '1728869983_dummies.pdf', '2024-10-15', '2024-10-15', 9, NULL, 'Tiada'),
('LIUU-065', '1728870559_dummies.pdf', '2024-10-15', '2024-10-16', 9, NULL, 'Tiada'),
('LIUU-066', '1728975474_dummies.pdf', '2024-10-15', '2024-10-16', 9, NULL, 'Tiada'),
('LIUU-067', '1728975802_dummies.pdf', '2024-10-15', '2024-10-16', 9, NULL, 'Tiada'),
('LIUU-068', '1729129232_dummies.pdf', '2024-10-17', '2024-10-18', 9, NULL, 'Tiada'),
('LIUU-069', '1729129753_dummies.pdf', '2024-10-18', '2024-10-26', 9, NULL, 'Tiada'),
('LIUU-070', '1729150107_dummies.pdf', '2024-10-18', '2024-10-26', 9, NULL, 'Tiada'),
('LIUU-071', '1729150400_dummies.pdf', '2024-10-18', '2024-10-25', 9, NULL, 'Tiada'),
('LIUU-072', '1729150493_dummies.pdf', '2024-10-18', '2024-11-01', 9, NULL, 'Tiada'),
('LIUU-073', '1729150626_dummies.pdf', '2024-10-10', '2024-10-30', 9, NULL, 'Tiada'),
('LIUU-074', '1729151641_dummies.pdf', '2024-10-23', '2024-10-25', 9, NULL, 'Tiada'),
('LIUU-075', '1729152158_dummies.pdf', '2024-10-30', '2024-10-30', 9, NULL, 'Tiada'),
('LIUU-076', '1729152253_dummies.pdf', '2024-10-29', '2024-10-30', 9, NULL, 'Tiada');

-- --------------------------------------------------------

--
-- Table structure for table `rayuan`
--

CREATE TABLE `rayuan` (
  `rayuan_id` int(11) NOT NULL,
  `application_id` varchar(10) DEFAULT NULL,
  `id_lokasi` int(11) DEFAULT NULL,
  `appeal_status` varchar(20) NOT NULL DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rayuan`
--

INSERT INTO `rayuan` (`rayuan_id`, `application_id`, `id_lokasi`, `appeal_status`, `remarks`, `student_id`, `user_id`) VALUES
(23, 'LIUU-048', 87, 'Approved', '123123', 59, 9),
(24, 'LIUU-003', 1, 'Rejected', 'Testing Syasya', 5, 1),
(25, 'LIUU-003', 75, 'Rejected', 'Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 Testing 456 ', 6, 1),
(26, 'LIUU-003', 69, 'Rejected', '@9834$*(^(*69349276(*#$^9832649838&amp;(*A&amp;42938694jnsdf', 4, 1),
(27, 'LIUU-005', 97, 'Approved', 'Saya nak rumah dekat', 9, 1),
(28, 'LIUU-003', 80, 'Rejected', 'Testing123', 4, 1),
(29, 'LIUU-058', 1, 'Rejected', 'tsetotsettsotseotsots', 71, 11),
(30, 'LIUU-059', 1, 'Approved', 'Test', 72, 9),
(31, 'LIUU-060', 70, 'Approved', 'pindah rumah', 73, 9),
(40, 'LIUU-062', 49, 'Approved', ' j ml; ;l', 75, 9),
(41, 'LIUU-062', 65, 'Approved', 'jknf', 75, 9),
(42, 'LIUU-063', 1, 'Rejected', 'bhk', 76, 9),
(43, 'LIUU-066', 1, 'Pending', 'aaa', 79, 9),
(44, 'LIUU-065', 1, 'Approved', 'aaa', 78, 9);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `student_matrics` varchar(50) DEFAULT NULL,
  `student_ic` varchar(50) DEFAULT NULL,
  `negeri_id` int(11) DEFAULT NULL,
  `lokasi_id` int(11) DEFAULT NULL,
  `application_id` varchar(10) DEFAULT NULL,
  `status` enum('Sedang Diproses','Lulus','Tidak Lulus') DEFAULT 'Sedang Diproses',
  `kursus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_name`, `student_matrics`, `student_ic`, `negeri_id`, `lokasi_id`, `application_id`, `status`, `kursus`) VALUES
(1, 'Mohamad', 'bcs2111', '012310231023', 10, 83, 'LIUU-001', 'Lulus', NULL),
(4, 'Rahimi', 'BCS12312', '030403020102', 16, 1, 'LIUU-003', 'Tidak Lulus', 'Degree in Education'),
(5, 'Syasya', 'AHA12312', '011020019322', 12, 93, 'LIUU-003', 'Tidak Lulus', 'Degree in Statistic'),
(6, 'Paan', 'YUH12312', '03948482131', 10, 84, 'LIUU-003', 'Tidak Lulus', 'Degree in Law'),
(7, 'Upin', 'BJE2100', '961234203423', 10, 74, 'LIUU-004', 'Lulus', 'Degree in Game'),
(8, 'Ipin', 'BGH2141', '981243299248', 16, 1, 'LIUU-004', 'Lulus', 'Degree in TESL'),
(9, 'Ehsan', 'HUR12312313', '030415120993', 14, 2, 'LIUU-005', 'Tidak Lulus', NULL),
(10, 'Fizi', 'BAU123123', '094093204830', 5, 57, 'LIUU-005', 'Sedang Diproses', NULL),
(11, 'Mohamad', 'BCS2111', '035023049340', 13, 97, 'LIUU-006', 'Tidak Lulus', NULL),
(12, 'TESTING', 'TEST123', '032135435153', 13, 97, 'LIUU-007', 'Sedang Diproses', NULL),
(13, 'MOHAMAD', 'BUS123123', '024923049103', 11, 89, 'LIUU-008', 'Sedang Diproses', 'Diploma in Law'),
(14, 'Ijat', 'OKO1203912', '102391203102', 7, 70, 'LIUU-009', 'Lulus', 'Diploma in Computer Science'),
(15, 'Hakimi', 'BCS12312', '030402030300', 6, 62, 'LIUU-010', 'Tidak Lulus', 'Diploma in Law'),
(16, 'Shahrul', 'HHA12312', '994123421432', 16, 1, 'LIUU-010', 'Sedang Diproses', 'Diploma in Computer Science'),
(17, 'Amirul', 'HJC134902', '084123421341', 13, 99, 'LIUU-010', 'Sedang Diproses', 'Degree in Bussiness'),
(18, 'Tsting', 'fse432424', '423423424232', 16, 1, 'LIUU-011', 'Lulus', 'Diploma in Law'),
(19, 'Ali ', 'ABC123', '093030303003', 10, 82, 'LIUU-012', 'Sedang Diproses', 'Diploma in Law'),
(20, 'Abu', 'DEF321', '094309203492', 12, 93, 'LIUU-012', 'Sedang Diproses', 'Diploma in Computer Science'),
(21, 'Atan', 'HAH123', '023940239402', 11, 91, 'LIUU-012', 'Tidak Lulus', 'Diploma in Law'),
(22, 'Jihyo', 'RAW13123213', '093208402340', 11, 87, 'LIUU-013', 'Sedang Diproses', 'Diploma in Accounting'),
(23, 'Jihyo', 'BSC324242', '093208402340', 14, 2, 'LIUU-014', 'Sedang Diproses', 'Diploma in Accounting'),
(24, 'Jihyo', 'BSC324242', '093208402340', 14, 2, 'LIUU-015', 'Sedang Diproses', 'Diploma in Accounting'),
(25, 'Jihyo', 'BSC324242', '093208402340', 14, 2, 'LIUU-016', 'Sedang Diproses', 'Diploma in Accounting'),
(26, 'Jihyo', 'BSC324242', '093208402340', 14, 2, 'LIUU-017', 'Sedang Diproses', 'Diploma in Accounting'),
(27, 'Jihyo', 'BSC324242', '093208402340', 14, 2, 'LIUU-018', 'Sedang Diproses', 'Diploma in Accounting'),
(28, 'Jihyo', 'BSC324242', '093208402340', 14, 2, 'LIUU-019', 'Sedang Diproses', 'Diploma in Accounting'),
(29, 'Jihyo', 'BSC324242', '093208402340', 14, 2, 'LIUU-020', 'Sedang Diproses', 'Diploma in Accounting'),
(30, 'Jihyo', 'BSC324242', '093208402340', 14, 2, 'LIUU-021', 'Sedang Diproses', 'Diploma in Accounting'),
(31, 'Jihyo', 'BSC324242', '093208402340', 14, 2, 'LIUU-022', 'Sedang Diproses', 'Diploma in Accounting'),
(32, 'Jihyo', 'BSC324242', '093208402340', 14, 2, 'LIUU-023', 'Sedang Diproses', 'Diploma in Accounting'),
(33, 'Jihyo', 'BSC324242', '093208402340', 14, 2, 'LIUU-024', 'Sedang Diproses', 'Diploma in Accounting'),
(34, 'Jihyo', 'BSC324242', '093208402340', 14, 2, 'LIUU-025', 'Sedang Diproses', 'Diploma in Accounting'),
(35, 'Jihyo', 'BSC324242', '093208402340', 14, 2, 'LIUU-026', 'Sedang Diproses', 'Diploma in Accounting'),
(36, 'Jihyo', 'BSC324242', '093208402340', 14, 2, 'LIUU-027', 'Sedang Diproses', 'Diploma in Accounting'),
(37, 'Jihyo', 'BSC324242', '093208402340', 14, 2, 'LIUU-028', 'Sedang Diproses', 'Diploma in Accounting'),
(38, 'Baim', 'BCS1231231', '030415120993', 10, 80, 'LIUU-029', 'Sedang Diproses', 'Diploma in Accounting'),
(39, 'Dina', 'HAR123213', '030415120993', 14, 2, 'LIUU-030', 'Sedang Diproses', 'Diploma in Accounting'),
(40, 'Aiman ', 'BRA12353', '093240294024', 14, 2, 'LIUU-031', 'Sedang Diproses', 'Diploma in Accounting'),
(41, 'Haikal', 'HAR12321', '040112091264', 12, 94, 'LIUU-032', 'Sedang Diproses', 'Diploma in Law'),
(42, 'Aimanrahimi', 'SJA2343251', '302403249029', 8, 15, 'LIUU-033', 'Sedang Diproses', 'Diploma in Accounting'),
(43, 'Mirul', 'Jdljfnwlqr3q1', '013490341041', 14, 2, 'LIUU-034', 'Sedang Diproses', 'Diploma in Law'),
(44, 'Mirul', 'Jdljfnwlqr3q1', '013490341041', 14, 2, 'LIUU-035', 'Sedang Diproses', 'Diploma in Law'),
(45, 'Mirul', 'Jdljfnwlqr3q1', '013490341041', 14, 2, 'LIUU-036', 'Sedang Diproses', 'Diploma in Law'),
(46, 'Test', '231321', '423423423424', 8, 18, 'LIUU-037', 'Sedang Diproses', 'Diploma in Law'),
(47, 'Test', '231321', '423423423424', 8, 18, 'LIUU-038', 'Sedang Diproses', 'Diploma in Law'),
(48, 'Testinb', '1231', '123123123213', 10, 78, 'LIUU-039', 'Sedang Diproses', 'Diploma in Law'),
(49, 'Testinb', '1231', '123123123213', 10, 78, 'LIUU-040', 'Sedang Diproses', 'Diploma in Law'),
(50, 'Testing', 'HAHA0123123123', '123123213131', 11, 87, 'LIUU-041', 'Sedang Diproses', 'Diploma in Accounting'),
(51, 'Testing', '76765858', '766666666666', 7, 70, 'LIUU-042', 'Sedang Diproses', 'Diploma in Law'),
(52, 'MOHAMAD AIMAN', 'BCS2111', '030134023043', 13, 98, 'LIUU-043', 'Sedang Diproses', 'Diploma in Computer Science'),
(53, 'Iman', 'BHA1321', '091231029313', 10, 86, 'LIUU-044', 'Sedang Diproses', 'Diploma in Law'),
(54, 'Aidil', '202112241010', '991223566678', 10, 80, 'LIUU-045', 'Sedang Diproses', 'Diploma in Law'),
(55, 'Mohamad', '2021', '039401481093', 7, 69, 'LIUU-046', 'Sedang Diproses', 'Diploma in Law'),
(56, 'Aiman', '2022', '019283901283', 16, 1, 'LIUU-046', 'Sedang Diproses', 'Degree in Law'),
(57, 'Rahimi', '2023', '091238021902', 11, 87, 'LIUU-046', 'Sedang Diproses', 'ACCA'),
(58, 'Abu', '2025', '090909430320', 14, 2, 'LIUU-047', 'Sedang Diproses', 'Diploma in Law'),
(59, 'Ali', '20240305', '000921116023', 16, 1, 'LIUU-048', 'Tidak Lulus', 'Diploma in Law'),
(60, 'Abu', '20240203', '020911032034', 11, 89, 'LIUU-048', 'Tidak Lulus', 'Bachelors in Law'),
(62, 'Ali', '123', '019230129372', 4, 48, 'LIUU-049', 'Lulus', 'Diploma in Law'),
(63, 'Aiman', '91312001293', '032141239193', 12, 93, 'LIUU-050', 'Sedang Diproses', 'Diploma in Law'),
(64, 'Mohamad', '09123', 'Notentera12123', 7, 70, 'LIUU-051', 'Sedang Diproses', 'Diploma in Law'),
(65, 'Aiman', '0918321', '034129831293', 11, 88, 'LIUU-052', 'Sedang Diproses', 'Diploma in Law'),
(66, 'kjhkjhk', '09809809', '093208402340', 14, 2, 'LIUU-053', 'Sedang Diproses', 'Diploma in Law'),
(67, '', '', '', 0, 0, 'LIUU-054', 'Sedang Diproses', ''),
(68, '', '', '', 0, 0, 'LIUU-055', 'Sedang Diproses', ''),
(69, '', '', '', 0, 0, 'LIUU-056', 'Sedang Diproses', ''),
(70, '', '', '', 0, 0, 'LIUU-057', 'Sedang Diproses', ''),
(71, 'Abu', '23423424', '1231231', 10, 76, 'LIUU-058', 'Tidak Lulus', '23423423'),
(72, 'aeshae', '00000', '123456', 16, 1, 'LIUU-059', 'Tidak Lulus', 'Information Technology'),
(73, 'abc', '123', '123', 16, 1, 'LIUU-060', 'Tidak Lulus', 'abc'),
(74, 'a', '1', '1', 16, 1, 'LIUU-061', 'Tidak Lulus', 'a'),
(75, 'a', 'a', 'a', 16, 1, 'LIUU-062', 'Tidak Lulus', 'a'),
(76, 'as', 'sa', 'sas', 16, 1, 'LIUU-063', 'Tidak Lulus', 'sa'),
(77, 'aa', '12', '12', 7, 70, 'LIUU-064', 'Sedang Diproses', 'aa'),
(78, 'aa', 'aa', 'aa', 16, 1, 'LIUU-065', 'Tidak Lulus', 'aa'),
(79, 'arif', '123', '123', 12, 95, 'LIUU-066', 'Tidak Lulus', 'computer'),
(80, 'aa', 'aa', 'aa', 16, 1, 'LIUU-067', 'Lulus', 'aa'),
(81, 'test', 'aa', 'aa', 16, 1, 'LIUU-068', 'Sedang Diproses', 'aa'),
(82, 'ds', 'dd', 'dd', 7, 70, 'LIUU-069', 'Sedang Diproses', 'dd'),
(83, 'aa', 'aa', 'aa', 9, 74, 'LIUU-070', 'Sedang Diproses', 'aa'),
(84, 'aa', 'aa', 'aa', 13, 98, 'LIUU-071', 'Sedang Diproses', 'aa'),
(85, 'cc', 'cc', 'cc', 13, 99, 'LIUU-072', 'Sedang Diproses', 'cc'),
(86, 'bb', 'bb', 'bb', 10, 84, 'LIUU-073', 'Sedang Diproses', 'bb'),
(87, 'cc', 'cc', 'cc', 11, 88, 'LIUU-074', 'Sedang Diproses', 'cc'),
(88, 'bb', 'bb', 'bb', 6, 61, 'LIUU-075', 'Sedang Diproses', 'bb'),
(89, 'bb', 'bb', 'bb', 12, 95, 'LIUU-076', 'Sedang Diproses', 'bb');

-- --------------------------------------------------------

--
-- Table structure for table `tbllokasi`
--

CREATE TABLE `tbllokasi` (
  `id_lokasi` int(11) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `negeri_lokasi` varchar(50) NOT NULL,
  `no_tel_lokasi` varchar(25) NOT NULL,
  `id_negeri` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbllokasi`
--

INSERT INTO `tbllokasi` (`id_lokasi`, `lokasi`, `negeri_lokasi`, `no_tel_lokasi`, `id_negeri`) VALUES
(1, 'Istana Kehakiman', 'W.P Putrajaya', '0388803500', 16),
(2, 'Kompleks Mahkamah Kuala Lumpur', 'W.P Kuala Lumpur', '0362094000', 14),
(3, 'Mahkamah Ipoh', 'Perak', '05-55511111', 8),
(4, 'Mahkamah Taiping', 'Perak', '', 8),
(5, 'Mahkamah Teluk Intan', 'Perak', '', 8),
(6, 'Mahkamah Seri Manjung', 'Perak', '', 8),
(7, 'Mahkamah Pantai Remis', 'Perak', '', 8),
(8, 'Mahkamah Tanjung Malim', 'Perak', '', 8),
(9, 'Mahkamah Tapah', 'Perak', '', 8),
(10, 'Mahkamah Parit Buntar', 'Perak', '', 8),
(11, 'Mahkamah Kuala Kangsar', 'Perak', '', 8),
(12, 'Mahkamah Sungai Siput', 'Perak', '', 8),
(13, 'Mahkamah Gerik', 'Perak', '', 8),
(14, 'Mahkamah Lenggong', 'Perak', '', 8),
(15, 'Mahkamah Pengkalan Hulu', 'Perak', '', 8),
(16, 'Mahkamah Selama', 'Perak', '', 8),
(17, 'Mahkamah Kampar', 'Perak', '', 8),
(18, 'Mahkamah Batu Gajah', 'Perak', '', 8),
(19, 'Mahkamah Slim River', 'Perak', '', 8),
(20, 'Kompleks Mahkamah Johor Bahru', 'Johor', '', 1),
(21, 'Mahkamah Batu Pahat', 'Johor', '', 1),
(22, 'Mahkamah Muar', 'Johor', '', 1),
(23, 'Mahkamah Kluang', 'Johor', '', 1),
(24, 'Mahkamah Kota Tinggi', 'Johor', '', 1),
(25, 'Mahkamah Mersing', 'Johor', '', 1),
(26, 'Mahkamah Kulai', 'Johor', '', 1),
(27, 'Mahkamah Tangkak', 'Johor', '', 1),
(28, 'Mahkamah Segamat', 'Johor', '', 1),
(29, 'Kompleks Mahkamah Alor Setar', 'Kedah', '', 2),
(30, 'Mahkamah Baling', 'Kedah', '', 2),
(31, 'Mahkamah Gurun', 'Kedah', '', 2),
(32, 'Mahkamah Kulim', 'Kedah', '', 2),
(33, 'Mahkamah Langkawi', 'Kedah', '', 2),
(34, 'Mahkamah Jitra', 'Kedah', '', 2),
(35, 'Mahkamah Kuala Nerang', 'Kedah', '', 2),
(36, 'Mahkamah Sungai Petani', 'Kedah', '', 2),
(37, 'Mahkamah Sik', 'Kedah', '', 2),
(38, 'Mahkamah Yan', 'Kedah', '', 2),
(39, 'Mahkamah Kota Bharu', 'Kelantan', '', 3),
(40, 'Mahkamah Bachok', 'Kelantan', '', 3),
(41, 'Mahkamah Machang', 'Kelantan', '', 3),
(42, 'Mahkamah Pasir Mas', 'Kelantan', '', 3),
(43, 'Mahkamah Pasir Puteh', 'Kelantan', '', 3),
(44, 'Mahkamah Tumpat', 'Kelantan', '', 3),
(45, 'Mahkamah Gua Musang', 'Kelantan', '', 3),
(46, 'Mahkamah Jeli', 'Kelantan', '', 3),
(47, 'Mahkamah Kuala Krai', 'Kelantan', '', 3),
(48, 'Kompleks Mahkamah Melaka ', 'Melaka', '', 4),
(49, 'Mahkamah Alor Gajah', 'Melaka', '', 4),
(50, 'Mahkamah Jasin', 'Melaka', '', 4),
(51, 'Kompleks Mahkamah Seremban', 'Negeri Sembilan', '', 5),
(52, 'Mahkamah Port Dickson', 'Negeri Sembilan', '', 5),
(53, 'Mahkamah Kuala Pilah', 'Negeri Sembilan', '', 5),
(54, 'Mahkamah Rembau', 'Negeri Sembilan', '', 5),
(55, 'Mahkamah Bahau', 'Negeri Sembilan', '', 5),
(56, 'Mahkamah Jelebu', 'Negeri Sembilan', '', 5),
(57, 'Mahkamah Tampin', 'Negeri Sembilan', '', 5),
(58, 'Mahkamah Gemas', 'Negeri Sembilan', '', 5),
(59, 'Kompleks Mahkamah Kuantan', 'Pahang', '', 6),
(60, 'Mahkamah Temerloh', 'Pahang', '', 6),
(61, 'Mahkamah Bentong', 'Pahang', '', 6),
(62, 'Mahkamah Cameron Highland', 'Pahang', '', 6),
(63, 'Mahkamah Jerantut', 'Pahang', '', 6),
(64, 'Mahkamah Kuala Lipis', 'Pahang', '', 6),
(65, 'Mahkamah Pekan', 'Pahang', '', 6),
(66, 'Mahkamah Raub', 'Pahang', '', 6),
(67, 'Mahkamah Rompin', 'Pahang', '', 6),
(68, 'Mahkamah Maran', 'Pahang', '', 6),
(69, 'Mahkamah Georgetown', 'Pulau Pinang', '', 7),
(70, 'Mahkamah Butterworth', 'Pulau Pinang', '', 7),
(71, 'Mahkamah Balik Pulau', 'Pulau Pinang', '', 7),
(72, 'Mahkamah Bukit Mertajam', 'Pulau Pinang', '', 7),
(73, 'Mahkamah Jawi', 'Pulau Pinang', '', 7),
(74, 'Mahkamah Kangar', 'Perlis', '', 9),
(75, 'Kompleks Mahkamah Shah Alam', 'Selangor', '', 10),
(76, 'Mahkamah Klang', 'Selangor', '', 10),
(77, 'Mahkamah Telok Datok', 'Selangor', '', 10),
(78, 'Mahkamah Kuala Selangor', 'Selangor', '', 10),
(79, 'Mahkamah Sungai Besar', 'Selangor', '', 10),
(80, 'Mahkamah Kajang', 'Selangor', '', 10),
(81, 'Mahkamah Ampang', 'Selangor', '', 10),
(82, 'Mahkamah Bandar Baru Bangir', 'Selangor', '', 10),
(83, 'Mahkamah Kuala Kubu Bharu', 'Selangor', '', 10),
(84, 'Mahkmah Petaling Jaya', 'Selangor', '', 10),
(85, 'Mahkamah Selayang', 'Selangor', '', 10),
(86, 'Mahkamah Sepang', 'Selangor', '', 10),
(87, 'Kompleks Mahkamah Kuala Terengganu', 'Terengganu', '', 11),
(88, 'Mahkamah Kemaman', 'Terengganu', '', 11),
(89, 'Mahkamah Marang', '', '', 11),
(90, 'Mahkamah Setiu', '', '', 11),
(91, 'Mahkamah Kuala Berang', '', '', 11),
(92, 'Mahkamah Dungun', '', '', 11),
(93, 'Mahkamah Kota Kinabalu', '', '', 12),
(94, 'Mahkamah Sandakan', '', '', 12),
(95, 'Mahkamah Keningau', '', '', 12),
(96, 'Mahkamah Tawau', '', '', 12),
(97, 'Kompleks Mahkamah Kuching ', '', '', 13),
(98, 'Mahkamah Bintulu', '', '', 13),
(99, 'Mahkamah Miri', '', '', 13),
(100, 'Mahkamah Sibu', '', '', 13),
(101, 'Mahkamah Lawas', '', '', 13),
(102, 'Mahkamah Limbang', '', '', 13),
(103, 'Mahkamah Sarikei', '', '', 13);

-- --------------------------------------------------------

--
-- Table structure for table `tblnegeri`
--

CREATE TABLE `tblnegeri` (
  `id_negeri` int(11) NOT NULL,
  `negeri` varchar(50) NOT NULL,
  `letterhead` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `emelby` varchar(50) DEFAULT NULL,
  `title_en` varchar(50) DEFAULT NULL,
  `emelby_en` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblnegeri`
--

INSERT INTO `tblnegeri` (`id_negeri`, `negeri`, `letterhead`, `title`, `emelby`, `title_en`, `emelby_en`) VALUES
(1, 'Johor', 'JOHOR-01.jpg', 'PENGARAH', 'MAHKAMAH NEGERI JOHOR', 'DIRECTOR', 'STATE COURT OF JOHOR'),
(2, 'Kedah', 'KEDAH-01.jpg', 'PENGARAH', 'MAHKAMAH NEGERI KEDAH', 'DIRECTOR', 'STATE COURT OF KEDAH'),
(3, 'Kelantan', 'KELANTAN-01.jpg', 'PENGARAH', 'MAHKAMAH NEGERI KELANTAN', 'DIRECTOR', 'STATE COURT OF KELANTAN'),
(4, 'Melaka', 'MELAKA-01.jpg', 'PENGARAH', 'MAHKAMAH NEGERI MELAKA', 'DIRECTOR', 'STATE COURT OF MELAKA'),
(5, 'Negeri Sembilan', 'N9-01.jpg', 'PENGARAH', 'MAHKAMAH NEGERI SEMBILAN', 'DIRECTOR', 'STATE COURT OF NEGERI SEMBILAN'),
(6, 'Pahang', 'PAHANG-01.jpg', 'PENGARAH', 'MAHKAMAH NEGERI PAHANG', 'DIRECTOR', 'STATE COURT OF PAHANG'),
(7, 'Pulau Pinang', 'PENANG-01.jpg', 'PENGARAH', 'MAHKAMAH NEGERI PULAU PINANG', 'DIRECTOR', 'STATE COURT OF PULAU PINANG'),
(8, 'Perak', 'PERAK-01.jpg', 'PENGARAH', 'MAHKAMAH NEGERI PERAK', 'DIRECTOR', 'STATE COURT OF PERAK'),
(9, 'Perlis', 'PERLIS-01.jpg', 'PENGARAH', 'MAHKAMAH NEGERI PERLIS', 'DIRECTOR', 'STATE COURT OF PERLIS'),
(10, 'Selangor', 'SELANGOR-01.jpg', 'PENGARAH', 'MAHKAMAH NEGERI SELANGOR', 'DIRECTOR', 'STATE COURT OF SELANGOR'),
(11, 'Terengganu', 'TERENGGANU-01.jpg', 'PENGARAH', 'MAHKAMAH NEGERI TERENGGANU', 'DIRECTOR', 'STATE COURT OF TERENGGANU'),
(12, 'Sabah', 'SABAH-01.jpg', 'PENGARAH', 'MAHKAMAH NEGERI SABAH', 'DIRECTOR', 'STATE COURT OF SABAH'),
(13, 'Sarawak', 'SARAWAK-01.jpg', 'PENGARAH', 'MAHKAMAH NEGERI SARAWAK', 'DIRECTOR', 'STATE COURT OF SARAWAK'),
(14, 'W.P Kuala Lumpur', 'KL-01.jpg', 'PENGARAH', 'MAHKAMAH WILAYAH PERSEKUTUAN KUALA LUMPUR', 'DIRECTOR', 'STATE COURT OF WILAYAH PERSEKUTUAN KUALA LUMPUR'),
(15, 'W.P Labuan', 'SABAH-01.jpg', 'PENGARAH', 'MAHKAMAH NEGERI SABAH', 'DIRECTOR', 'STATE COURT OF SABAH'),
(16, 'W.P Putrajaya', 'PKPMP-01.jpg', 'PEJABAT KETUA PENDAFTAR', 'MAHKAMAH PERSEKUTUAN MALAYSIA', 'OFFICE OF THE CHIEF REGISTRAR', 'FEDERAL COURT OF MALAYSIA');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `college_uni` varchar(100) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `no_phone` varchar(20) NOT NULL,
  `nama_pegawai` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `password`, `email`, `college_uni`, `name`, `no_phone`, `nama_pegawai`) VALUES
(1, '$2y$10$NzGbSh6OcYqhbIJka.JoTOYMxRlTIfNL7MUhMq6Rf9YNhNh5hZ/5y', 'admin123@gmail.com', 'KPM Beranang', 'Aiman Rahimi', '01122326736', NULL),
(6, '$2y$10$3IXWisJAsuvwODCm7Z3lfe4ohnY8fTImyvjFJF7rkrJy1219LGdnO', 'ali123@gmail.com', 'UITM Shah Alam', 'Ali bin Abu', '0111234567', NULL),
(8, '$2y$10$xTxC/gDPcL1LqusDrYePnufIib5xAtsx3ju59IfdY/ilZEUYdRPuO', 'poli@gmail.com', 'Politeknik SultanMizan', '', '0912039102', NULL),
(9, '$2y$10$pcWIASmvsTHOzW2xqExK1.9XKFQOysz4rnCSYJCpQpSMOy/6HLWfi', 'ukm@gmail.com', 'Universiti Kebangsaan Malaysia', '', '03119043821', NULL),
(10, '$2y$10$phmsCs.VG77bMIVK.8khPOMuAeAQ16dv7QKKr3Qu/raaZ1aQsqDrK', 'aimanrahimi8080@gmail.com', 'Universiti Kuala Lumpur', '', '01162232686', 'Aiman Rahimi'),
(11, '$2y$10$YPvS7Nw4G04MxTdwm42QrODFp37D40nH7XnVbdI43mO7r.FXcpFEW', 'uitm@gmail.com', 'UITM', '', '012212313121', 'Ali');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `internship_applications`
--
ALTER TABLE `internship_applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rayuan`
--
ALTER TABLE `rayuan`
  ADD PRIMARY KEY (`rayuan_id`),
  ADD KEY `application_id` (`application_id`),
  ADD KEY `id_lokasi` (`id_lokasi`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `application_id` (`application_id`);

--
-- Indexes for table `tbllokasi`
--
ALTER TABLE `tbllokasi`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indexes for table `tblnegeri`
--
ALTER TABLE `tblnegeri`
  ADD PRIMARY KEY (`id_negeri`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rayuan`
--
ALTER TABLE `rayuan`
  MODIFY `rayuan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `tbllokasi`
--
ALTER TABLE `tbllokasi`
  MODIFY `id_lokasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `internship_applications`
--
ALTER TABLE `internship_applications`
  ADD CONSTRAINT `internship_applications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `rayuan`
--
ALTER TABLE `rayuan`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `rayuan_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `internship_applications` (`application_id`),
  ADD CONSTRAINT `rayuan_ibfk_2` FOREIGN KEY (`id_lokasi`) REFERENCES `tbllokasi` (`id_lokasi`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `internship_applications` (`application_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
