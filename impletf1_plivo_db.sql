-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2020 at 12:50 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `impletf1_plivo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_group`
--

CREATE TABLE `add_group` (
  `add_group_id` int(11) NOT NULL,
  `add_group_name` varchar(255) NOT NULL,
  `add_group_status` int(4) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `add_group`
--

INSERT INTO `add_group` (`add_group_id`, `add_group_name`, `add_group_status`, `createdon`) VALUES
(7, 'Test Group-CP', 1, '2020-08-05 14:36:38'),
(8, 'Faizan Ali TEAM WEB ECOMMERCE PROS', 1, '2020-08-21 04:27:09'),
(9, 'Faizan Ali Bulk SMS Sending ', 1, '2020-08-21 04:27:19'),
(10, 'Resellers', 1, '2020-11-03 09:27:19');

-- --------------------------------------------------------

--
-- Table structure for table `call_routes`
--

CREATE TABLE `call_routes` (
  `call_routes_id` int(11) NOT NULL,
  `call_routes_name` varchar(255) NOT NULL,
  `call_routes_number` varchar(255) NOT NULL,
  `call_routes_status` int(4) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `call_routes`
--

INSERT INTO `call_routes` (`call_routes_id`, `call_routes_name`, `call_routes_number`, `call_routes_status`, `createdon`) VALUES
(15, 'Seller', '+14138533247', 1, '2020-08-05 14:35:51'),
(25, 'Buyer', '+18325146419', 1, '2020-11-10 05:14:06'),
(26, 'Buyer', '+13658000673', 1, '2020-11-10 05:14:07'),
(27, 'Buyer', '+12153984559', 1, '2020-11-10 05:14:07'),
(42, 'Resellers', '+18325146419', 1, '2020-11-11 12:58:55'),
(43, 'Resellers', '+12283356017', 1, '2020-11-11 12:58:55'),
(44, 'Resellers', '+12283358676', 1, '2020-11-11 12:58:55'),
(45, 'Resellers', '+19893732800', 1, '2020-11-11 12:58:55'),
(46, 'Resellers', '+19036086874', 1, '2020-11-11 12:58:56'),
(47, 'Resellers', '+18125794212', 1, '2020-11-11 12:58:56'),
(48, 'Resellers', '+13658000673', 1, '2020-11-11 12:58:56'),
(49, 'Resellers', '+12153984559', 1, '2020-11-11 12:58:56'),
(50, 'Resellers', '+16626593598', 1, '2020-11-11 12:58:56'),
(51, 'Resellers', '+19803325316', 1, '2020-11-11 12:58:56'),
(52, 'Resellers', '+12185274402', 1, '2020-11-11 12:58:56'),
(53, 'Resellers', '+13158186471', 1, '2020-11-11 12:58:56'),
(54, 'Resellers', '+18125704245', 1, '2020-11-11 12:58:56'),
(55, 'Resellers', '+18125346293', 1, '2020-11-11 12:58:56'),
(56, 'Calling', '+18325146419', 1, '2020-11-13 06:20:52');

-- --------------------------------------------------------

--
-- Table structure for table `campaign`
--

CREATE TABLE `campaign` (
  `campaign_id` int(11) NOT NULL,
  `campaign_name` varchar(255) NOT NULL,
  `campaign_message` text NOT NULL,
  `campaign_group` varchar(255) NOT NULL,
  `campaign_call_route` varchar(255) NOT NULL,
  `campaign_route_numbers` text NOT NULL,
  `campaign_status` int(4) NOT NULL DEFAULT 1,
  `createdon` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `campaign`
--

INSERT INTO `campaign` (`campaign_id`, `campaign_name`, `campaign_message`, `campaign_group`, `campaign_call_route`, `campaign_route_numbers`, `campaign_status`, `createdon`) VALUES
(5, 'Test Campaign', 'Hi Laxman', '7', 'Seller', 'a:1:{i:0;s:12:\"+14138533247\";}', 1, '2020-11-03 10:53:34'),
(6, 'Bulk Message Test', 'Hi Guys', '10', 'Buyer', 'a:1:{i:0;s:12:\"+14138533247\";}', 1, '2020-11-04 10:35:20'),
(7, 'Evening Campaign', 'Resller Campaign test SMS', '10', 'Resellers', 'a:14:{i:0;s:12:\"+18325146419\";i:1;s:12:\"+12283356017\";i:2;s:12:\"+12283358676\";i:3;s:12:\"+19893732800\";i:4;s:12:\"+19036086874\";i:5;s:12:\"+18125794212\";i:6;s:12:\"+13658000673\";i:7;s:12:\"+12153984559\";i:8;s:12:\"+16626593598\";i:9;s:12:\"+19803325316\";i:10;s:12:\"+12185274402\";i:11;s:12:\"+13158186471\";i:12;s:12:\"+18125704245\";i:13;s:12:\"+18125346293\";}', 1, '2020-11-11 13:00:38');

-- --------------------------------------------------------

--
-- Table structure for table `contact_list`
--

CREATE TABLE `contact_list` (
  `id` int(11) NOT NULL,
  `list_name` text NOT NULL,
  `list_path` text NOT NULL,
  `recipients` int(11) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact_list`
--

INSERT INTO `contact_list` (`id`, `list_name`, `list_path`, `recipients`, `status`) VALUES
(10, 'test', 'test.xls', 7857575, 'Active'),
(11, 'test-excel-contacts.xlsx', 'excel_upload/test-excel-contacts.xlsx', 1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `response` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `folder`
--

CREATE TABLE `folder` (
  `folder_id` int(11) NOT NULL,
  `folder_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `folder_status` int(11) NOT NULL DEFAULT 1,
  `createdon` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `folder`
--

INSERT INTO `folder` (`folder_id`, `folder_name`, `folder_status`, `createdon`) VALUES
(2, 'ABCDEF', 1, '2020-08-14 18:53:47');

-- --------------------------------------------------------

--
-- Table structure for table `numbers`
--

CREATE TABLE `numbers` (
  `numbers_id` int(11) NOT NULL,
  `contact_list_id` int(11) NOT NULL,
  `numbers_first_name` varchar(255) NOT NULL,
  `numbers_last_name` varchar(255) NOT NULL,
  `numbers_address` varchar(255) NOT NULL,
  `numbers_phone_number` varchar(255) NOT NULL,
  `numbers_phone_type` varchar(255) NOT NULL,
  `numbers_group_id` int(11) NOT NULL,
  `numbers_status` int(4) NOT NULL DEFAULT 1,
  `createdon` timestamp NOT NULL DEFAULT current_timestamp(),
  `conversation_sid` text NOT NULL,
  `chat_service_sid` text NOT NULL,
  `messaging_service_sid` text NOT NULL,
  `participant_sid` text NOT NULL,
  `identity` text NOT NULL,
  `conversation_response` text NOT NULL,
  `participant_response` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `numbers`
--

INSERT INTO `numbers` (`numbers_id`, `contact_list_id`, `numbers_first_name`, `numbers_last_name`, `numbers_address`, `numbers_phone_number`, `numbers_phone_type`, `numbers_group_id`, `numbers_status`, `createdon`, `conversation_sid`, `chat_service_sid`, `messaging_service_sid`, `participant_sid`, `identity`, `conversation_response`, `participant_response`) VALUES
(5, 10, 'Chris', 'Purcell', 'ABC', '+12153269570', 'Mobile', 10, 1, '2020-11-10 11:29:57', 'CHd55b5e3a93d64064a685cc03657903e5', 'IS96849ab4f0d34f1e98042d414840dc51', 'MG2fe89d849ad4156c3c056be54175acfc', 'MB0d6be8cb5a444bb286149e83a2dfacb1', '', '{\"accountSid\":\"AC529db4ea06aba0a1ed7356e28d6b0dbb\",\"chatServiceSid\":\"IS96849ab4f0d34f1e98042d414840dc51\",\"messagingServiceSid\":\"MG2fe89d849ad4156c3c056be54175acfc\",\"sid\":\"CHd55b5e3a93d64064a685cc03657903e5\",\"friendlyName\":\"+12153269570\",\"uniqueName\":\"12153269570\",\"attributes\":\"{}\",\"state\":\"active\",\"dateCreated\":{\"date\":\"2020-11-10 11:29:56.000000\",\"timezone_type\":2,\"timezone\":\"Z\"},\"dateUpdated\":{\"date\":\"2020-11-10 11:29:56.000000\",\"timezone_type\":2,\"timezone\":\"Z\"},\"timers\":[],\"url\":\"https://conversations.twilio.com/v1/Conversations/CHd55b5e3a93d64064a685cc03657903e5\",\"links\":{\"participants\":\"https://conversations.twilio.com/v1/Conversations/CHd55b5e3a93d64064a685cc03657903e5/Participants\",\"messages\":\"https://conversations.twilio.com/v1/Conversations/CHd55b5e3a93d64064a685cc03657903e5/Messages\",\"webhooks\":\"https://conversations.twilio.com/v1/Conversations/CHd55b5e3a93d64064a685cc03657903e5/Webhooks\"}}', '{\"accountSid\":\"AC529db4ea06aba0a1ed7356e28d6b0dbb\",\"conversationSid\":\"CHd55b5e3a93d64064a685cc03657903e5\",\"sid\":\"MB0d6be8cb5a444bb286149e83a2dfacb1\",\"identity\":null,\"attributes\":\"{}\",\"messagingBinding\":{\"proxy_address\":\"+18325146419\",\"type\":\"sms\",\"address\":\"+12153269570\"},\"roleSid\":\"RLe7510345d8e440cfaa35e793ed2d9ee4\",\"dateCreated\":{\"date\":\"2020-11-10 11:29:57.000000\",\"timezone_type\":2,\"timezone\":\"Z\"},\"dateUpdated\":{\"date\":\"2020-11-10 11:29:57.000000\",\"timezone_type\":2,\"timezone\":\"Z\"},\"url\":\"https://conversations.twilio.com/v1/Conversations/CHd55b5e3a93d64064a685cc03657903e5/Participants/MB0d6be8cb5a444bb286149e83a2dfacb1\"}'),
(6, 11, 'Ch', 'Purcell', 'ABC', '+12153524444', 'Mobile', 10, 1, '2020-11-13 10:33:34', 'CH01b238e2ead7410c94fbefe47ecc4de1', 'IS96849ab4f0d34f1e98042d414840dc51', 'MG2fe89d849ad4156c3c056be54175acfc', 'MB6e1cf72937fc4d498bb7475fc843d199', '', '{\"accountSid\":\"AC529db4ea06aba0a1ed7356e28d6b0dbb\",\"chatServiceSid\":\"IS96849ab4f0d34f1e98042d414840dc51\",\"messagingServiceSid\":\"MG2fe89d849ad4156c3c056be54175acfc\",\"sid\":\"CH01b238e2ead7410c94fbefe47ecc4de1\",\"friendlyName\":\"+12153524444\",\"uniqueName\":\"12153524444\",\"attributes\":\"{}\",\"state\":\"active\",\"dateCreated\":{\"date\":\"2020-11-13 10:33:32.000000\",\"timezone_type\":2,\"timezone\":\"Z\"},\"dateUpdated\":{\"date\":\"2020-11-13 10:33:32.000000\",\"timezone_type\":2,\"timezone\":\"Z\"},\"timers\":[],\"url\":\"https://conversations.twilio.com/v1/Conversations/CH01b238e2ead7410c94fbefe47ecc4de1\",\"links\":{\"participants\":\"https://conversations.twilio.com/v1/Conversations/CH01b238e2ead7410c94fbefe47ecc4de1/Participants\",\"messages\":\"https://conversations.twilio.com/v1/Conversations/CH01b238e2ead7410c94fbefe47ecc4de1/Messages\",\"webhooks\":\"https://conversations.twilio.com/v1/Conversations/CH01b238e2ead7410c94fbefe47ecc4de1/Webhooks\"}}', '{\"accountSid\":\"AC529db4ea06aba0a1ed7356e28d6b0dbb\",\"conversationSid\":\"CH01b238e2ead7410c94fbefe47ecc4de1\",\"sid\":\"MB6e1cf72937fc4d498bb7475fc843d199\",\"identity\":null,\"attributes\":\"{}\",\"messagingBinding\":{\"proxy_address\":\"+18325146419\",\"type\":\"sms\",\"address\":\"+12153524444\"},\"roleSid\":\"RLe7510345d8e440cfaa35e793ed2d9ee4\",\"dateCreated\":{\"date\":\"2020-11-13 10:33:33.000000\",\"timezone_type\":2,\"timezone\":\"Z\"},\"dateUpdated\":{\"date\":\"2020-11-13 10:33:33.000000\",\"timezone_type\":2,\"timezone\":\"Z\"},\"url\":\"https://conversations.twilio.com/v1/Conversations/CH01b238e2ead7410c94fbefe47ecc4de1/Participants/MB6e1cf72937fc4d498bb7475fc843d199\"}');

-- --------------------------------------------------------

--
-- Table structure for table `purchased_numbers`
--

CREATE TABLE `purchased_numbers` (
  `id` int(11) NOT NULL,
  `pn_sid` varchar(1000) NOT NULL,
  `address_sid` varchar(1000) DEFAULT NULL,
  `identity_sid` varchar(1000) DEFAULT NULL,
  `friendly_name` varchar(500) NOT NULL,
  `phone_number` varchar(500) NOT NULL,
  `region` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `monthly_rental` varchar(11) NOT NULL,
  `origin` varchar(100) NOT NULL,
  `voice` varchar(100) NOT NULL DEFAULT 'false',
  `sms` varchar(100) NOT NULL DEFAULT 'false',
  `mms` varchar(100) NOT NULL DEFAULT 'false',
  `fax` varchar(100) NOT NULL DEFAULT 'false',
  `status` varchar(100) NOT NULL,
  `response` text NOT NULL,
  `date_created` varchar(100) DEFAULT NULL,
  `date_updated` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchased_numbers`
--

INSERT INTO `purchased_numbers` (`id`, `pn_sid`, `address_sid`, `identity_sid`, `friendly_name`, `phone_number`, `region`, `type`, `monthly_rental`, `origin`, `voice`, `sms`, `mms`, `fax`, `status`, `response`, `date_created`, `date_updated`) VALUES
(2, 'PNbb28b4dd742e143f7382eeeb3009d679', '', '', '(228) 335-6017', '+12283356017', 'us', 'local', '2.00', 'twilio', '1', '1', '1', 'false', 'in-use', '{\"accountSid\":\"AC529db4ea06aba0a1ed7356e28d6b0dbb\",\"addressSid\":null,\"addressRequirements\":\"none\",\"apiVersion\":\"2010-04-01\",\"beta\":false,\"capabilities\":{\"voice\":true,\"sms\":true,\"mms\":true},\"dateCreated\":{\"date\":\"2020-11-11 12:57:04.000000\",\"timezone_type\":1,\"timezone\":\"+00:00\"},\"dateUpdated\":{\"date\":\"2020-11-11 12:57:04.000000\",\"timezone_type\":1,\"timezone\":\"+00:00\"},\"friendlyName\":\"(228) 335-6017\",\"identitySid\":null,\"phoneNumber\":\"+12283356017\",\"origin\":\"twilio\",\"sid\":\"PNbb28b4dd742e143f7382eeeb3009d679\",\"smsApplicationSid\":\"\",\"smsFallbackMethod\":\"POST\",\"smsFallbackUrl\":\"\",\"smsMethod\":\"POST\",\"smsUrl\":\"\",\"statusCallback\":\"\",\"statusCallbackMethod\":\"POST\",\"trunkSid\":null,\"uri\":\"/2010-04-01/Accounts/AC529db4ea06aba0a1ed7356e28d6b0dbb/IncomingPhoneNumbers/PNbb28b4dd742e143f7382eeeb3009d679.json\",\"voiceReceiveMode\":null,\"voiceApplicationSid\":null,\"voiceCallerIdLookup\":false,\"voiceFallbackMethod\":\"POST\",\"voiceFallbackUrl\":null,\"voiceMethod\":\"POST\",\"voiceUrl\":null,\"emergencyStatus\":\"Inactive\",\"emergencyAddressSid\":null,\"bundleSid\":null,\"status\":\"in-use\"}', '2020-11-11 12:57:04', '2020-11-11 12:57:04');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`id`, `user_name`, `password`) VALUES
(1, 'admin', 'admin123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_group`
--
ALTER TABLE `add_group`
  ADD PRIMARY KEY (`add_group_id`);

--
-- Indexes for table `call_routes`
--
ALTER TABLE `call_routes`
  ADD PRIMARY KEY (`call_routes_id`);

--
-- Indexes for table `campaign`
--
ALTER TABLE `campaign`
  ADD PRIMARY KEY (`campaign_id`);

--
-- Indexes for table `contact_list`
--
ALTER TABLE `contact_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folder`
--
ALTER TABLE `folder`
  ADD PRIMARY KEY (`folder_id`);

--
-- Indexes for table `numbers`
--
ALTER TABLE `numbers`
  ADD PRIMARY KEY (`numbers_id`);

--
-- Indexes for table `purchased_numbers`
--
ALTER TABLE `purchased_numbers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_group`
--
ALTER TABLE `add_group`
  MODIFY `add_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `call_routes`
--
ALTER TABLE `call_routes`
  MODIFY `call_routes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `campaign`
--
ALTER TABLE `campaign`
  MODIFY `campaign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_list`
--
ALTER TABLE `contact_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `folder`
--
ALTER TABLE `folder`
  MODIFY `folder_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `numbers`
--
ALTER TABLE `numbers`
  MODIFY `numbers_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchased_numbers`
--
ALTER TABLE `purchased_numbers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
