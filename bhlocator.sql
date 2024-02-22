-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2024 at 04:02 AM
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
-- Database: `bhlocator`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `boarding_house`
--

CREATE TABLE `boarding_house` (
  `boarding_house_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `boarding_house_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `description` text NOT NULL,
  `boarding_house_photo` varchar(255) NOT NULL,
  `facilities` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `boarding_house`
--

INSERT INTO `boarding_house` (`boarding_house_id`, `owner_id`, `boarding_house_name`, `address`, `longitude`, `latitude`, `description`, `boarding_house_photo`, `facilities`) VALUES
(1, 1, 'Peña Boarding House', 'Real St., Calatagan Proper, Virac Catanduanes', 124.21170900, 13.58807800, '\"sample\"', 'pena.jpg', 'Parking Area, Study Area'),
(2, 2, 'Alaskador Boarding House', 'Real St., Calatagan Proper, Virac Catanduanes', 124.32570000, 13.68880000, '\"none\"', 'alaskador.jpg', 'Kithen, Lobby'),
(3, 3, 'De Leon\'s Boarding House', 'Real St., Calatagan Proper, Virac Catanduanes', 124.20816900, 13.58891200, '\"Gate Closed at 10pm\"', 'deleon.jpg', 'Study Area, Parking Area'),
(4, 4, 'Sicio\'s Boarding House', 'Real St., Calatagan Proper, Virac Catanduanes', 124.20922000, 13.58655500, '\"Girls Only\"', 'sicio.jpg', 'none'),
(5, 5, 'Ubang Boarding House', 'Real St., Calatagan Proper, Virac Catanduanes', 124.20810400, 13.58663900, '\"Proper Segregation of waste, Curfew 10pm\"', 'ubang.jpg', 'Study Area'),
(6, 6, 'Valenzuela Boarding House', 'Real St., Calatagan Proper, Virac Catanduanes', 124.21016400, 13.58849500, '\"none\"', 'valenzuela.jpg', 'Study Area'),
(7, 7, 'Lleno\'s Boarding House', 'Real St., Calatagan Proper, Virac Catanduanes', 124.20883400, 13.58862000, '\"None\"', 'lleno.jpg', 'Parking Area'),
(8, 8, 'Taños Boarding House', 'Real St., Calatagan Proper, Virac Catanduanes', 124.20851200, 13.58966300, '\"None\"', 'tanos.jpg', 'None'),
(9, 9, 'Obic Boarding House', 'Real St., Calatagan Proper, Virac Catanduanes', 124.20902700, 13.58953800, '\"Required at least 10 months of Stay\"', 'obic.jpg', 'Study Area'),
(10, 10, 'MJT Boarding House', 'Real St., Calatagan Proper, Virac Catanduanes', 124.20855500, 13.58699300, '\"None\"', 'mjt.jpg', 'Study Area, Parking Area, Laundry Area ');

-- --------------------------------------------------------

--
-- Table structure for table `boarding_house_owner`
--

CREATE TABLE `boarding_house_owner` (
  `owner_id` int(11) NOT NULL,
  `owner_name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `account_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `boarding_house_owner`
--

INSERT INTO `boarding_house_owner` (`owner_id`, `owner_name`, `address`, `username`, `password`, `contact_number`, `email_address`, `account_status`) VALUES
(1, '', '', 'owner1', 'owner1', '', '', ''),
(2, 'Romeo P. Vargas Jr', 'Real St., Calatagan Proper, Virac Catanduanes', 'owner2', 'owner2', 'n/a', 'vargas624@gmail.com', 'activated'),
(3, 'Prisalla F. De Leon', 'Real St., Calatagan Proper, Virac Catanduanes', 'owner3', 'owner3', '09195974421', 'prisalladl1969@gmail.com', 'activated'),
(4, 'Corazon B. Sicio', 'Real St., Calatagan Proper, Virac Catanduanes', 'owner4', 'owner4', '09608618944', 'corazonsicio@gmail.com', 'activated'),
(5, 'Richynel Ubang', 'Real St., Calatagan Proper, Virac Catanduanes', 'owner5', 'owner5', '09067095211', 'n/a', 'activated'),
(6, 'Lelia Valenzuela', 'Real St., Calatagan Proper, Virac Catanduanes', 'owner6', 'owner6', '09708105540', 'n/a', 'activated'),
(7, 'Luis Lleno', 'Real St., Calatagan Proper, Virac Catanduanes', 'owner7', 'owner7', '09295338856', 'n/a', 'activated'),
(8, 'Maricel S. Taño', 'Real St., Calatagan Proper, Virac Catanduanes', 'owner8', 'owner8', '09085740615', 'n/a', 'activated'),
(9, 'Sany', 'Real St., Calatagan Proper, Virac Catanduanes', 'owner9', 'owner9', '09518016865', 'n/a', 'activated'),
(10, 'Mercy Tejerero', 'Real St., Calatagan Proper, Virac Catanduanes', 'owner10', 'owner10', 'n/a', 'n/a', 'activated'),
(17, 'sample', 'sample', 'sample', 'sample', 'sample', 'sample@gmail.com', 'Pending'),
(18, 'jhon mark', 'National Road', 'jhonmark', 'password0', '09129282836', 'jhonmarkhallare0@gmail.com', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `boarding_house_id` int(11) NOT NULL,
  `total_room` int(11) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `room_price` decimal(10,2) NOT NULL,
  `amenities` text NOT NULL,
  `comfort_room` varchar(100) NOT NULL,
  `pets_allowed` varchar(100) NOT NULL,
  `electricity_bill` varchar(100) NOT NULL,
  `water_bill` varchar(100) NOT NULL,
  `room_availability_status` int(11) NOT NULL,
  `room_photos` varchar(255) NOT NULL,
  `room_type_photos` varchar(255) NOT NULL,
  `inclutions` varchar(100) NOT NULL,
  `room_capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `boarding_house_id`, `total_room`, `room_type`, `room_price`, `amenities`, `comfort_room`, `pets_allowed`, `electricity_bill`, `water_bill`, `room_availability_status`, `room_photos`, `room_type_photos`, `inclutions`, `room_capacity`) VALUES
(1, 1, 3, 'Quad Room', 3000.00, 'Study Table, Cabinet', 'Outside The Room', 'Yes', 'Include', 'Include', 0, 'room_photos/', '', 'Water, Electricity, 2 Double Deck, Study Table', 4),
(2, 2, 5, 'Quad Room', 2000.00, 'Kitchen, Lobby', 'Inside The Room', 'Yes', 'Included', 'Included', 1, 'room2.jpg', 'double_room.jpg', 'Bed, Desk, Chair, water, electricity', 4),
(3, 3, 20, 'Quad Room', 2700.00, 'Study Area, Parking Area', 'Inside the room', 'Yes', 'Included', 'Included', 2, '', '', 'Water, Electricity, Bed, Table', 4),
(4, 4, 10, 'Triple Room', 3000.00, '', 'Inside The room', 'No', 'Not Included', 'Not Included', 2, '', '', 'Bed, Table, Chairs', 3),
(5, 5, 6, 'Triple Room', 3000.00, '', 'Inside The Room', 'Yes', 'Included', 'Included', 0, '', '', 'Table, Chair, Bed', 3),
(6, 6, 6, 'Triple Room', 2500.00, '', 'Outside The Room', 'Yes', 'Not Included', 'Not Included', 0, '', '', 'Bed, Table, Chair', 3),
(7, 7, 10, 'Quad Room', 3000.00, '', 'Inside The Room', 'Yes', 'Included', 'Separated', 2, '', '', 'Table, Chair, Bed', 4),
(8, 8, 7, 'Quad Room', 1800.00, '', 'Outside The Room', 'No', 'Not Included', 'Not Included', 0, '', '', 'Table, Bed, Chair', 4),
(9, 9, 10, 'Quad Room', 3000.00, '', 'Outside The Room', 'Yes', 'Included', 'Included', 3, '', '', 'Bed, Table, Chair', 4),
(10, 10, 50, 'Quad Room', 3000.00, 'Piso Wifi', 'Inside The Room', 'Yes', 'Separated', 'Separated', 0, '', '', 'Bed, Table, Chair', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `boarding_house`
--
ALTER TABLE `boarding_house`
  ADD PRIMARY KEY (`boarding_house_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `boarding_house_owner`
--
ALTER TABLE `boarding_house_owner`
  ADD PRIMARY KEY (`owner_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `boarding_house_id` (`boarding_house_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `boarding_house`
--
ALTER TABLE `boarding_house`
  MODIFY `boarding_house_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `boarding_house_owner`
--
ALTER TABLE `boarding_house_owner`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boarding_house`
--
ALTER TABLE `boarding_house`
  ADD CONSTRAINT `boarding_house_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `boarding_house_owner` (`owner_id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`boarding_house_id`) REFERENCES `boarding_house` (`boarding_house_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
