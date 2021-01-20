-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 20, 2021 alle 01:04
-- Versione del server: 10.4.17-MariaDB
-- Versione PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mercatinopulci`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `acquista`
--

CREATE TABLE `acquista` (
  `dataOraPubblicazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `venditore` varchar(16) NOT NULL,
  `acquirente` varchar(16) NOT NULL,
  `valutazioneSuAcquirente` tinyint(6) UNSIGNED DEFAULT NULL
) ;

--
-- Dump dei dati per la tabella `acquista`
--

INSERT INTO `acquista` (`dataOraPubblicazione`, `venditore`, `acquirente`, `valutazioneSuAcquirente`) VALUES
('2021-01-11 21:58:27', 'PNACCL83E41G713I', 'FCUFTA90P25D560I', 4),
('2021-01-11 22:03:23', 'PNACCL83E41G713I', 'RGNGNN97R13L736H', 2),
('2021-01-12 20:27:47', 'PNACCL83E41G713I', 'BCCGRT89R52E617T', 5),
('2021-01-12 20:28:22', 'PNACCL83E41G713I', 'SFGLNE12B69A288U', 5),
('2021-01-13 18:44:14', 'LHRMRG99A41E801X', 'RSNLND85R12A652Y', 5),
('2021-01-14 20:55:19', 'DNTLCU63A01C803H', 'PNZGNR67L16C351I', NULL),
('2021-01-14 21:09:13', 'CLMMTN00L51A794O', 'FCUFTA90P25D560I', 3),
('2021-01-14 21:31:50', 'RSSCTR96D57A401O', 'SFGLNE12B69A288U', 3),
('2021-01-15 14:50:52', 'SLGDRA97A41E801X', 'LLLSCN71R18A271O', NULL),
('2021-01-15 14:58:36', 'RGNGNN97R13L736H', 'PRGDRD99M23F133R', NULL),
('2021-01-19 23:55:08', 'PNACCL83E41G713I', 'BCCGRT89R52E617T', 4),
('2021-01-20 00:03:20', 'BCCGRT89R52E617T', 'PNACCL83E41G713I', 4);

--
-- Trigger `acquista`
--
DELIMITER $$
CREATE TRIGGER `check_acquista_annuncio_in_vendita` BEFORE INSERT ON `acquista` FOR EACH ROW BEGIN

IF (
    SELECT statoAnnuncio 
    FROM annuncio
    WHERE dataOraPubblicazione = new.dataOraPubblicazione
    AND venditore = new.venditore
    ) != 'inVendita'
    THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "ERROR - L'annuncio non è più in vendita";
	END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `imposta_statoAnnuncio_venduto` AFTER INSERT ON `acquista` FOR EACH ROW BEGIN

UPDATE annuncio SET statoAnnuncio = 'venduto' WHERE new.dataOraPubblicazione = dataOraPubblicazione AND new.venditore = venditore;

END
$$
DELIMITER ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `acquista`
--
ALTER TABLE `acquista`
  ADD PRIMARY KEY (`dataOraPubblicazione`,`venditore`),
  ADD KEY `acquista_fk1` (`acquirente`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `acquista`
--
ALTER TABLE `acquista`
  ADD CONSTRAINT `acquista_fk1` FOREIGN KEY (`acquirente`) REFERENCES `utente` (`codiceFiscale`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `acquista_fk2` FOREIGN KEY (`dataOraPubblicazione`,`venditore`) REFERENCES `annuncio` (`dataOraPubblicazione`, `venditore`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
