

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `auth`
--

DROP TABLE IF EXISTS `auth`;
CREATE TABLE IF NOT EXISTS `auth` (
  `login` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `user_id` varchar(10) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `auth`
--

INSERT INTO `auth` (`login`, `password`, `user_id`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', '0'),
('medic', '0d20326e6155cae6bb2b510bfc2cc01e', '1');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `crew`
--

DROP TABLE IF EXISTS `crew`;
CREATE TABLE IF NOT EXISTS `crew` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `middle_name` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `last_name` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `dob` date NOT NULL,
  `rank` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `sex` set('M','F') COLLATE utf8_polish_ci NOT NULL,
  `company` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `alcohol` set('N','Y') COLLATE utf8_polish_ci DEFAULT NULL,
  `smoking` set('N','Y') COLLATE utf8_polish_ci DEFAULT NULL,
  `allergies` varchar(45) COLLATE utf8_polish_ci DEFAULT NULL,
  `medication` varchar(45) COLLATE utf8_polish_ci DEFAULT NULL,
  `immunization` varchar(45) COLLATE utf8_polish_ci DEFAULT NULL,
  `info` varchar(45) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`pid`),
  KEY `crewmember` (`last_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=4 ;

--
-- Zrzut danych tabeli `crew`
--

INSERT INTO `crew` (`pid`, `first_name`, `middle_name`, `last_name`, `dob`, `rank`, `sex`, `company`, `alcohol`, `smoking`, `allergies`, `medication`, `immunization`, `info`) VALUES
(3, 'darek', 'nikodem', 'kramin', '1973-05-28', 'sdpo', 'M', 's7', 'N', 'N', NULL, NULL, 'yellow fever 2020', 'nil');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `history`
--

DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history` (
  `hid` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `pid` int(11) NOT NULL,
  `complaint` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `examination` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `diagnose` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `sid` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`hid`),
  KEY `crew_history` (`pid`),
  KEY `stock_history` (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=36 ;

--
-- Zrzut danych tabeli `history`
--

INSERT INTO `history` (`hid`, `date`, `pid`, `complaint`, `examination`, `diagnose`, `sid`, `qty`) VALUES
(35, '2011-03-15', 3, 'cought', 'infection', 'throat irritation', 87, 8);

--
-- Wyzwalacze `history`
--
DROP TRIGGER IF EXISTS `deduct_stock_after_history_insert`;
DELIMITER //
CREATE TRIGGER `deduct_stock_after_history_insert` AFTER INSERT ON `history`
 FOR EACH ROW begin
 
update `my4261_emr`.`stock` 
      SET stock = stock-new.qty 
      where sid=new.sid;

end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `update_stock_after_history_update`;
DELIMITER //
CREATE TRIGGER `update_stock_after_history_update` AFTER UPDATE ON `history`
 FOR EACH ROW begin
 
update `my4261_emr`.`stock` 
      SET stock = stock-(new.qty-old.qty) 
      where sid=new.sid;

end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `category` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `generic_name` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `description` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `min_stock` int(11) NOT NULL,
  `remarks` varchar(45) COLLATE utf8_polish_ci DEFAULT NULL,
  `packing` varchar(45) COLLATE utf8_polish_ci DEFAULT NULL,
  `stock1` int(11) NOT NULL,
  `expiry1` date DEFAULT NULL,
  `stock2` int(11) NOT NULL,
  `expiry2` date DEFAULT NULL,
  `stock3` int(11) NOT NULL,
  `expiry3` date DEFAULT NULL,
  `stock4` int(11) NOT NULL,
  `expiry4` date DEFAULT NULL,
  `stock5` int(11) NOT NULL,
  `expiry5` date DEFAULT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`sid`),
  KEY `medicine` (`generic_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=122 ;

--
-- Zrzut danych tabeli `stock`
--

INSERT INTO `stock` (`sid`, `page`, `category`, `generic_name`, `description`, `min_stock`, `remarks`, `packing`, `stock1`, `expiry1`, `stock2`, `expiry2`, `stock3`, `expiry3`, `stock4`, `expiry4`, `stock5`, `expiry5`, `stock`) VALUES
(1, '1', 'Gastrointestinal', 'Anusol', 'suppository', 24, NULL, NULL, 24, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(2, '1', 'Gastrointestinal', 'Anusol', 'cream', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(3, '1', 'Gastrointestinal', 'Dioralyte, natural ', 'sachets (packs of 6)', 5, NULL, NULL, 5, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(4, '1', 'Gastrointestinal', 'Domperidone', 'tablets, 10mg', 30, NULL, NULL, 30, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(5, '1', 'Gastrointestinal', 'Gaviscon', 'tablets', 120, NULL, NULL, 120, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(6, '1', 'Gastrointestinal', 'Glycerin suppositoria', 'suppositories', 24, NULL, NULL, 24, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(7, '1', 'Gastrointestinal', 'Loperamide', 'capsules, 2mg', 60, NULL, NULL, 60, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(8, '1', 'Gastrointestinal', 'Mebendazole ', 'tablets, 100mg', 6, NULL, NULL, 6, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(9, '1', 'Gastrointestinal', 'Mebeverine', 'tablets, 135mg', 100, NULL, NULL, 100, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(10, '1', 'Gastrointestinal', 'Omeprazole ', 'capsules, 10mg', 56, NULL, NULL, 56, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(11, '1', 'Gastrointestinal', 'Prochlorperazine ', 'buccal, 3mg', 50, NULL, NULL, 50, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(12, '1', 'Gastrointestinal', 'Senna', 'tablets, 7.5mg', 50, NULL, NULL, 50, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(13, '2', 'Cardiovascular', 'Adrenaline/ Epinephrine', '1:10,000, 1mg/10ml, 10ml amp (Minijet)', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(14, '2', 'Cardiovascular', 'Adrenaline/ Epinephrine', '1:1000, 1mg/ml, 1ml amp (Minijet)', 20, NULL, NULL, 20, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(15, '2', 'Cardiovascular', 'Amiodarone', '30mg/ml 10ml minijet', 2, NULL, NULL, 2, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(16, '2', 'Cardiovascular', 'Aspirin', '300mg tablet dispersible', 100, NULL, NULL, 100, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(17, '2', 'Cardiovascular', 'Atenolol', 'tablet, 50mg', 28, NULL, NULL, 28, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(18, '2', 'Cardiovascular', 'Atropine', 'injection, 1mg10ml, Minijet', 6, NULL, NULL, 6, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(19, '2', 'Cardiovascular', 'Dalteparin ', '10,000 unit pere filled syringe', 1, NULL, NULL, 1, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(20, '2', 'Cardiovascular', 'Furosemide ', 'injection, 10mg/ml, 5ml amp', 5, NULL, NULL, 5, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(21, '2', 'Cardiovascular', 'Furosemide ', '40mg tablets', 28, NULL, NULL, 28, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(22, '2', 'Cardiovascular', 'Glyceryl trinitrate ', '0.5mg tablets', 100, 'not in capita list; for hyperbaric use', NULL, 100, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(23, '2', 'Cardiovascular', 'Nitrolingual', 'spray', 2, NULL, NULL, 2, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(24, '2', 'Cardiovascular', 'Tenecteplase', '10,000 unit = 50mg vial', 1, NULL, NULL, 1, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(25, '3', 'Respiratory', 'Beclomethasone / Beclometasone', 'inhaler, 50 microgram/dose, 200 dose inhaler', 2, NULL, NULL, 2, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(26, '3', 'Respiratory', 'Chlorpheniramine ', 'injection, 10mg/ml, 1ml amp', 5, NULL, NULL, 5, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(27, '3', 'Respiratory', 'Ipratropium Bromide', 'nebules, 250 microgram/ml, 1ml nebule', 20, NULL, NULL, 20, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(28, '3', 'Respiratory', 'Linctus Simplex', 'liquid, 100ml', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(29, '3', 'Respiratory', 'Salbutamol ', 'inhaler, 100 micrograms per dose, 200 dose un', 3, NULL, NULL, 3, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(30, '3', 'Respiratory', 'Salbutamol ', 'Nebules, 1mg/ml, 2.5ml', 20, NULL, NULL, 20, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(31, '4', 'Central Nerve Syst', 'Benzatropine ', '2mg/2ml amp', 3, NULL, NULL, 3, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(32, '4', 'Central Nerve Syst', 'Diazepam', 'injection, 5mg/ml, 2ml amp', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(33, '4', 'Central Nerve Syst', 'Diazepam', 'rectal tubes, 4mg/ml, 2.5ml tube', 5, NULL, NULL, 5, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(34, '4', 'Central Nerve Syst', 'Diazepam', 'tablets, 5mg', 50, NULL, NULL, 50, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(35, '4', 'Central Nerve Syst', 'Haloperidol ', 'tablets, 5mg', 40, NULL, NULL, 40, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(36, '4', 'Central Nerve Syst', 'Haloperidol ', 'injection, 5mg/ml, 1ml  amp', 5, NULL, NULL, 5, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(37, '4', 'Central Nerve Syst', 'Hyoscine hydrobromide', 'tablets, 0.3mg', 180, NULL, NULL, 180, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(38, '4', 'Central Nerve Syst', 'Hyoscine hydrobromide ', 'dermal patches, 1mg', 20, 'not in capita list', NULL, 20, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(39, '4', 'Central Nerve Syst', 'Metoclopramide', 'injection, 5mg/ml, 2ml amp', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(40, '4', 'Central Nerve Syst', 'Prochlorperazine ', 'injection, 12.5mg/ml, 1ml amp', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(41, '4', 'Central Nerve Syst', 'Zolpidem ', 'tablets, 5mg', 56, NULL, NULL, 56, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(42, '5', 'Antibacterial', 'Amoxicillin', 'capsules, 250mg', 224, NULL, NULL, 224, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(43, '5', 'Antibacterial', 'Cefuroxime ', '750mg vial for injection', 20, NULL, NULL, 20, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(44, '5', 'Antibacterial', 'Ciprofloxacin', 'tablets, 500mg', 60, NULL, NULL, 60, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(45, '5', 'Antibacterial', 'Clarithromycin ', 'tablets, 250 mg', 200, NULL, NULL, 200, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(46, '5', 'Antibacterial', 'Co-Amoxiclav', 'tablets, 625 mg', 63, NULL, NULL, 63, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(47, '5', 'Antibacterial', 'Doxycyclin', '100mg capsules', 200, NULL, NULL, 200, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(48, '5', 'Antibacterial', 'Flucloxacillin', 'capsules, 500mg', 100, NULL, NULL, 100, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(49, '5', 'Antibacterial', 'Metronidazole ', 'tablets, 200mg', 100, NULL, NULL, 100, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(50, '5', 'Antibacterial', 'Metronidazole', 'suppositories, 1g', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(51, '5', 'Antibacterial', 'Penicillin G ', '1200mg vial for injection, ', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(52, '5', 'Antibacterial', 'Penicillin V ', 'tablets, 250mg', 200, NULL, NULL, 200, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(53, '5', 'Antibacterial', 'Trimethoprim', 'tablets, 200mg', 100, NULL, NULL, 100, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(54, '6', 'Endocrine', 'Dexamethasone', 'injection, 4mg/ml, 2ml amp', 2, 'not in capita list', NULL, 2, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(55, '6', 'Endocrine', 'Dextrose', 'injection, 50% in 25ml', 5, NULL, NULL, 5, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(56, '6', 'Endocrine', 'Glucagon', 'injection, 1mg amp', 2, NULL, NULL, 2, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(57, '6', 'Endocrine', 'Hydrocortisone', 'injection, 100mg/ml, 1ml amp', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(58, '6', 'Endocrine', 'Prednisolone', 'tablets, 5mg', 60, NULL, NULL, 60, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(59, '7', 'Analgesics', 'Co-Codamol Paracetamol/ Codeine', 'tablets (500/8 mg)', 200, NULL, NULL, 200, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(60, '7', 'Analgesics', 'Diclofenac', 'injection, 25mg/ml, 3ml amp', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(61, '7', 'Analgesics', 'Diclofenac', 'tablets, 25mg', 168, NULL, NULL, 168, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(62, '7', 'Analgesics', 'Dihydrocodeine', 'tablets, 30mg', 60, NULL, NULL, 60, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(63, '7', 'Analgesics', 'Ibuprofen', 'tablets, 400mg', 420, NULL, NULL, 420, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(64, '7', 'Analgesics', 'Migraleve ', 'packs 48 tablets /pack', 5, NULL, NULL, 5, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(65, '7', 'Analgesics', 'Paracetamol', 'tablets, 500mg', 400, NULL, NULL, 400, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(66, '7', 'Analgesics', 'Sumitriptan', 'unit vial, nasal spray', 2, NULL, NULL, 2, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(67, '8', 'Controlled Drugs', 'Morphine', 'injection, 10mg amps ', 15, NULL, NULL, 15, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(68, '8', 'Controlled Drugs', 'Pethidine', 'injection, 50mg/ml 2ml amp', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(69, '9', 'Eye', 'Betamethasone', '0.1% drops, 10ml', 5, NULL, NULL, 5, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(70, '9', 'Eye', 'Chloramphenical', 'eye ointment 4gr tube 0.1%', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(71, '9', 'Eye', 'Fluorescein ', 'minims', 20, NULL, NULL, 20, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(72, '9', 'Eye', 'Fusidic Acid', 'drops, 5g', 20, NULL, NULL, 20, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(73, '9', 'Eye', 'Oxybuprocaine', 'minims', 60, NULL, NULL, 60, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(74, '9', 'Eye', 'Pilocarpine ', '1%, eye drops, 0.5ml minims', 20, NULL, NULL, 20, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(75, '9', 'Eye', 'Sodium Chloride 0.9%', 'minims', 60, NULL, NULL, 60, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(76, '10', 'ENT', 'Cavit', 'dental filling', 3, NULL, NULL, 3, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(77, '10', 'ENT', 'Chlorhexidine ', 'mouthwash, 300ml', 3, NULL, NULL, 3, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(78, '10', 'ENT', 'Ephedrine', 'nasal drops, 10ml bottle', 20, NULL, NULL, 20, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(79, '10', 'ENT', 'Gentisone HC', 'ear drops, 0.3%, 10ml', 5, NULL, NULL, 5, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(80, '10', 'ENT', 'Hydrocortisone ', 'pellets, 2.5mg', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(81, '10', 'ENT', 'Karvol', 'inhalation capsules', 40, NULL, NULL, 40, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(82, '10', 'ENT', 'Loratidine ', 'tablets, 10mg', 60, NULL, NULL, 60, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(83, '10', 'ENT', 'Naseptin cream', 'tube 15 gram', 3, NULL, NULL, 3, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(84, '10', 'ENT', 'Oil of Cloves', '10ml', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(85, '10', 'ENT', 'Olive Oil', 'ear drops, 10ml', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(86, '10', 'ENT', 'Pseudoephedrine', 'tablets, 60mg', 100, NULL, NULL, 100, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(87, '10', 'ENT', 'Strepsils', 'lozenge, packs of 24 tablets ', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 10),
(88, '11', 'Skin', 'Aciclovir ', 'cream 5%, 2g', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(89, '11', 'Skin', 'Aqueous creme (Barrier creme)', 'tube 100gr', 3, NULL, NULL, 3, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(90, '11', 'Skin', 'Betamethasone', 'ointment, 0.1%, 30g', 5, NULL, NULL, 5, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(91, '11', 'Skin', 'Calamine ', 'lotion, 200ml', 5, NULL, NULL, 5, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(92, '11', 'Skin', 'Clotrimazole', 'cream, 1%, 20g', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(93, '11', 'Skin', 'Ethyl Chloride', 'spray', 2, NULL, NULL, 2, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(94, '11', 'Skin', 'Histoacryl skin glue', '200mg unit', 5, NULL, NULL, 5, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(95, '11', 'Skin', 'Hydrocortisone', 'cream, 1%,15g', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(96, '11', 'Skin', 'Instillagel', 'gel, 2%, plus Chlorhexidine (Instillagel), 6m', 4, NULL, NULL, 4, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(97, '11', 'Skin', 'Lignocaine / Lidocaine', 'injection, 1%, 2ml amp', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(98, '11', 'Skin', 'Lypsyl', 'lip application', 36, NULL, NULL, 36, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(99, '11', 'Skin', 'Magnesium Sulphate', 'paste,25g', 1, NULL, NULL, 1, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(100, '11', 'Skin', 'Malathion ', 'lotion, 0.5%, 200ml aqueous base', 2, NULL, NULL, 2, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(101, '11', 'Skin', 'Mentholatum rub', 'tube 40gr', 5, NULL, NULL, 5, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(102, '11', 'Skin', 'Mupirocin ', 'ointment,2%, 15g', 5, NULL, NULL, 5, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(103, '11', 'Skin', 'Potassium Permanganate', 'crystals, 10g', 1, NULL, NULL, 1, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(104, '11', 'Skin', 'Silver Sulfadiazine ', 'cream, 50g', 5, NULL, NULL, 5, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(105, '11', 'Skin', 'Steripod (Sodium Chloride)', 'liquid, 20ml', 50, NULL, NULL, 50, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(106, '11', 'Skin', 'Unisept (Chlorhexidine)', 'liquid, 25ml', 50, NULL, NULL, 50, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(107, '11', 'Skin', 'Zinc', 'ointment, 25g', 1, NULL, NULL, 1, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(108, '12', 'Miscellaneous', 'Clotrimazole', 'pessaries, 500mg', 2, NULL, NULL, 2, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(109, '12', 'Miscellaneous', 'Fluconazole', 'capsule, 150mg', 2, NULL, NULL, 2, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(110, '12', 'Miscellaneous', 'Syntometrine', 'injection, 1ml amp', 2, NULL, NULL, 2, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(111, '12', 'Miscellaneous', 'Tetanus Immunoglobulin', '250units c/w syringe', 1, NULL, NULL, 1, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(112, '12', 'Miscellaneous', 'Tetanus Toxoid vaccine (Diphteria/Tetanus)', '0.5ml amp', 5, NULL, NULL, 5, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(113, '13', 'Intravenous Fluids', 'Gelofusine', '500ml', 20, NULL, NULL, 20, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(114, '13', 'Intravenous Fluids', 'Glucose', '5%, 500ml', 5, NULL, NULL, 5, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(115, '13', 'Intravenous Fluids', 'Hartmann''s solution', '500ml', 20, NULL, NULL, 20, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(116, '13', 'Intravenous Fluids', 'Mannitol', '20%, 500ml', 2, NULL, NULL, 2, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(117, '13', 'Intravenous Fluids', 'Sodium Chloride', '0.9%, 500ml', 20, NULL, NULL, 20, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(118, '13', 'Intravenous Fluids', 'Water ', 'injection, 20ml amp', 20, NULL, NULL, 20, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(119, '14', 'Antidotes', 'Calcium Gluconate gel', 'supplied as kit', 1, 'only when hydroflueric acid on board', NULL, 1, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(120, '14', 'Antidotes', 'Ethanol ', '70 proof spirit bottle', 1, NULL, NULL, 1, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0),
(121, '14', 'Antidotes', 'Naloxone', 'injection, 0.4mg/ml, 1ml amp', 10, NULL, NULL, 10, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0);

--
-- Wyzwalacze `stock`
--
DROP TRIGGER IF EXISTS `update_stock_after_insert`;
DELIMITER //
CREATE TRIGGER `update_stock_after_insert` BEFORE INSERT ON `stock`
 FOR EACH ROW begin
if new.sid=new.sid THEN   
      SET new.stock = new.stock1+new.stock2+new.stock3+new.stock4+new.stock5;  
end if;

end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `update_stock_after_change`;
DELIMITER //
CREATE TRIGGER `update_stock_after_change` BEFORE UPDATE ON `stock`
 FOR EACH ROW begin
if new.sid=new.sid THEN   
      SET new.stock = new.stock1+new.stock2+new.stock3+new.stock4+new.stock5;  
end if;

end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `stock_expiry`
--
DROP VIEW IF EXISTS `stock_expiry`;
CREATE TABLE IF NOT EXISTS `stock_expiry` (
`sid` int(11)
,`page` varchar(45)
,`category` varchar(45)
,`generic_name` varchar(45)
,`description` varchar(45)
,`min_stock` int(11)
,`remarks` varchar(45)
,`packing` varchar(45)
,`stock1` int(11)
,`expiry1` date
,`stock2` int(11)
,`expiry2` date
,`stock3` int(11)
,`expiry3` date
,`stock4` int(11)
,`expiry4` date
,`stock5` int(11)
,`expiry5` date
,`stock` int(11)
);
-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `stock_refresh`
--
DROP VIEW IF EXISTS `stock_refresh`;
CREATE TABLE IF NOT EXISTS `stock_refresh` (
`sid` int(11)
,`page` varchar(45)
,`category` varchar(45)
,`generic_name` varchar(45)
,`description` varchar(45)
,`min_stock` int(11)
,`remarks` varchar(45)
,`packing` varchar(45)
,`stock1` int(11)
,`expiry1` date
,`stock2` int(11)
,`expiry2` date
,`stock3` int(11)
,`expiry3` date
,`stock4` int(11)
,`expiry4` date
,`stock5` int(11)
,`expiry5` date
,`stock` int(11)
);
-- --------------------------------------------------------

--
-- Struktura widoku `stock_expiry`
--
DROP TABLE IF EXISTS `stock_expiry`;

CREATE VIEW `stock_expiry` AS select `stock`.`sid` AS `sid`,`stock`.`page` AS `page`,`stock`.`category` AS `category`,`stock`.`generic_name` AS `generic_name`,`stock`.`description` AS `description`,`stock`.`min_stock` AS `min_stock`,`stock`.`remarks` AS `remarks`,`stock`.`packing` AS `packing`,`stock`.`stock1` AS `stock1`,`stock`.`expiry1` AS `expiry1`,`stock`.`stock2` AS `stock2`,`stock`.`expiry2` AS `expiry2`,`stock`.`stock3` AS `stock3`,`stock`.`expiry3` AS `expiry3`,`stock`.`stock4` AS `stock4`,`stock`.`expiry4` AS `expiry4`,`stock`.`stock5` AS `stock5`,`stock`.`expiry5` AS `expiry5`,`stock`.`stock` AS `stock` from `stock` where ((`stock`.`expiry1` <= (curdate() + interval 60 day)) or (`stock`.`expiry2` <= (curdate() + interval 60 day)) or (`stock`.`expiry3` <= (curdate() + interval 60 day)) or (`stock`.`expiry4` <= (curdate() + interval 60 day)) or (`stock`.`expiry5` <= (curdate() + interval 60 day)));

-- --------------------------------------------------------

--
-- Struktura widoku `stock_refresh`
--
DROP TABLE IF EXISTS `stock_refresh`;

CREATE VIEW `stock_refresh` AS select `stock`.`sid` AS `sid`,`stock`.`page` AS `page`,`stock`.`category` AS `category`,`stock`.`generic_name` AS `generic_name`,`stock`.`description` AS `description`,`stock`.`min_stock` AS `min_stock`,`stock`.`remarks` AS `remarks`,`stock`.`packing` AS `packing`,`stock`.`stock1` AS `stock1`,`stock`.`expiry1` AS `expiry1`,`stock`.`stock2` AS `stock2`,`stock`.`expiry2` AS `expiry2`,`stock`.`stock3` AS `stock3`,`stock`.`expiry3` AS `expiry3`,`stock`.`stock4` AS `stock4`,`stock`.`expiry4` AS `expiry4`,`stock`.`stock5` AS `stock5`,`stock`.`expiry5` AS `expiry5`,`stock`.`stock` AS `stock` from `stock` where (`stock`.`stock` <= `stock`.`min_stock`);

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `crew_history` FOREIGN KEY (`pid`) REFERENCES `crew` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_history` FOREIGN KEY (`sid`) REFERENCES `stock` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE;
