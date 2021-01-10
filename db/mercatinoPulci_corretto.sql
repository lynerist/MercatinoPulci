-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Nov 10, 2020 alle 00:08
-- Versione del server: 10.4.14-MariaDB
-- Versione PHP: 7.4.10

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
CREATE DATABASE IF NOT EXISTS `mercatinopulci` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `mercatinopulci`;

-- --------------------------------------------------------

--
-- Struttura della tabella `acquista`
--

CREATE TABLE `acquista` (
  `dataOraPubblicazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `venditore` varchar(16) NOT NULL,
  `acquirente` varchar(16) NOT NULL,
  `valutazioneSuAcquirente` tinyint(6) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Struttura della tabella `annuncio`
--

CREATE TABLE `annuncio` (
  `dataOraPubblicazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `venditore` varchar(16) NOT NULL,
  `statoAnnuncio` set('inVendita','venduto','eliminato') NOT NULL DEFAULT 'inVendita',
  `titolo` varchar(150) NOT NULL,
  `prodotto` varchar(30) NOT NULL,
  `categoria` set('elettrodomestici','fotoEVideo','abbigliamento','hobby') NOT NULL,
  `sottoCategoria` set('aspirapolveri','caffettiere','tostapane','frullatori','macchineFotografiche','accessori','telecamere','microfoni','vestiti','borse','scarpe','accessori','giocattoli','filmEDVD','musica','libriERiviste','altro') NOT NULL,
  `prezzo` float UNSIGNED NOT NULL,
  `statoUsura` set('comeNuovo','buono','medio','usurato') DEFAULT NULL,
  `tempoUsura` smallint(5) UNSIGNED NOT NULL,
  `scadenzaGaranzia` date DEFAULT NULL,
  `foto` varchar(30) DEFAULT NULL,
  `valutazioneSuVenditore` tinyint(6) UNSIGNED DEFAULT NULL,
  `visibilita` set('privata','pubblica','ristretta') NOT NULL,
  `comune` varchar(35) NOT NULL,
  `provincia` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `areageografica`
--

CREATE TABLE `areageografica` (
  `comune` varchar(35) NOT NULL,
  `provincia` varchar(22) NOT NULL,
  `regione` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `areavisibilita`
--

CREATE TABLE `areavisibilita` (
  `dataOraPubblicazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `venditore` varchar(16) NOT NULL,
  `comune` varchar(35) NOT NULL,
  `provincia` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `areavisibilita`
--
DELIMITER $$
CREATE TRIGGER `check_visibilita` BEFORE INSERT ON `areavisibilita` FOR EACH ROW BEGIN

IF (
    SELECT visibilita 
    FROM annuncio
    WHERE dataOraPubblicazione = new.dataOraPubblicazione
    AND venditore = new.venditore
    ) != 'ristretta'
    THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "ERROR - visibilita non è ristretta";
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `osserva`
--

CREATE TABLE `osserva` (
  `acquirente` varchar(16) NOT NULL,
  `dataOraPubblicazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `venditore` varchar(16) NOT NULL,
  `richiestaDiAcquisto` enum('0','1') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `osserva`
--
DELIMITER $$
CREATE TRIGGER `check_osserva_annuncio_in_vendita` BEFORE INSERT ON `osserva` FOR EACH ROW BEGIN

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

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `codiceFiscale` varchar(16) NOT NULL,
  `tipoAccount`  set('acquirente','venditore','venditoreAcquirente') NOT NULL,
  `nome` varchar(20) NOT NULL,
  `cognome` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `immagine` varchar(30) DEFAULT NULL,
  `comune` varchar(35) NOT NULL,
  `provincia` varchar(22) NOT NULL,
  `eliminato` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `acquista`
--
ALTER TABLE `acquista`
  ADD PRIMARY KEY (`dataOraPubblicazione`,`venditore`),
  ADD KEY `acquista_fk1` (`acquirente`),
  ADD CONSTRAINT `ERRORE_acquisto_proprio_prodotto` CHECK (`venditore` != `acquirente`),
  ADD CONSTRAINT `ERRORE_valutazioneSuAcquirente_non_valida` CHECK (`valutazioneSuAcquirente` > 0 AND `valutazioneSuAcquirente` < 6);

--
-- Indici per le tabelle `annuncio`
--
ALTER TABLE `annuncio`
  ADD PRIMARY KEY (`dataOraPubblicazione`,`venditore`),
  ADD KEY `annuncio_fk1` (`venditore`),
  ADD KEY `annuncio_fk2` (`comune`,`provincia`),
  ADD CONSTRAINT `ERRORE_valutazioneSuVenditore_non_valido` CHECK (`valutazioneSuVenditore` IS NULL OR `statoAnnuncio` = 'venduto'),
  ADD CONSTRAINT `ERRORE_valutazioneSuVenditore_non_valida` CHECK (`valutazioneSuVenditore` > 0 AND `valutazioneSuVenditore` < 6),
  ADD CONSTRAINT `ERRORE_prezzo==0` CHECK (`prezzo` > 0),
  ADD CONSTRAINT `ERRORE_sottocategoria_NOT_IN_categoria` CHECK (`categoria` = 'elettrodomestici' AND `sottoCategoria` IN ('aspirapolveri','caffettiere','tostapane','frullatori') OR `categoria` = 'fotoEVideo' AND `sottoCategoria` IN ('macchineFotografiche','accessori','telecamere','microfoni') OR `categoria` = 'abbigliamento' AND `sottoCategoria` IN ('vestiti','borse','scarpe','accessori') OR `categoria` = 'hobby' AND `sottoCategoria` IN ('giocattoli','filmEDVD','musica','libriERiviste') OR `sottoCategoria` = 'altro' AND `categoria` IN ('elettrodomestici','fotoEVideo','abbigliamento','hobby')),
  ADD CONSTRAINT `ERRORE_statoUsura_e_tempoUsura incoerenti` CHECK (`tempoUsura` = 0 AND `statoUsura` IS NULL OR `tempoUsura` > 0 AND `statoUsura` IS NOT NULL),
  ADD CONSTRAINT `ERRORE_tempoUsura_negativo` CHECK (`tempoUsura` >= 0),
  ADD CONSTRAINT `ERRORE_nessun_prodotto` CHECK (`prodotto` != ""),
  ADD CONSTRAINT `ERRORE_nessun_titolo` CHECK (`titolo` != "");

--
-- Indici per le tabelle `areageografica`
--
ALTER TABLE `areageografica`
  ADD PRIMARY KEY (`comune`,`provincia`);

--
-- Indici per le tabelle `areavisibilita`
--
ALTER TABLE `areavisibilita`
  ADD PRIMARY KEY (`dataOraPubblicazione`,`venditore`,`comune`,`provincia`),
  ADD KEY `areaVisibilita_fk2` (`comune`,`provincia`);

--
-- Indici per le tabelle `osserva`
--
ALTER TABLE `osserva`
  ADD PRIMARY KEY (`acquirente`,`dataOraPubblicazione`,`venditore`),
  ADD KEY `osserva_fk2` (`dataOraPubblicazione`,`venditore`),
  ADD CONSTRAINT `ERRORE_osservazione_proprio_prodotto` CHECK (`venditore` != `acquirente`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`codiceFiscale`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `utente_fk1` (`comune`,`provincia`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `acquista`
--
ALTER TABLE `acquista`
  ADD CONSTRAINT `acquista_fk1` FOREIGN KEY (`acquirente`) REFERENCES `utente` (`codiceFiscale`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `acquista_fk2` FOREIGN KEY (`dataOraPubblicazione`,`venditore`) REFERENCES `annuncio` (`dataOraPubblicazione`, `venditore`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Limiti per la tabella `annuncio`
--
ALTER TABLE `annuncio`
  ADD CONSTRAINT `annuncio_fk1` FOREIGN KEY (`venditore`) REFERENCES `utente` (`codiceFiscale`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `annuncio_fk2` FOREIGN KEY (`comune`,`provincia`) REFERENCES `areageografica` (`comune`, `provincia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `areavisibilita`
--
ALTER TABLE `areavisibilita`
  ADD CONSTRAINT `areaVisibilita_fk1` FOREIGN KEY (`dataOraPubblicazione`,`venditore`) REFERENCES `annuncio` (`dataOraPubblicazione`, `venditore`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `areaVisibilita_fk2` FOREIGN KEY (`comune`,`provincia`) REFERENCES `areageografica` (`comune`, `provincia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `osserva`
--
ALTER TABLE `osserva`
  ADD CONSTRAINT `osserva_fk1` FOREIGN KEY (`acquirente`) REFERENCES `utente` (`codiceFiscale`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `osserva_fk2` FOREIGN KEY (`dataOraPubblicazione`,`venditore`) REFERENCES `annuncio` (`dataOraPubblicazione`, `venditore`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Limiti per la tabella `utente`
--
ALTER TABLE `utente`
  ADD CONSTRAINT `utente_fk1` FOREIGN KEY (`comune`,`provincia`) REFERENCES `areageografica` (`comune`, `provincia`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
