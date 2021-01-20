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
-- Struttura della tabella `annuncio`
--

CREATE TABLE `annuncio` (
  `dataOraPubblicazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `venditore` varchar(16) NOT NULL,
  `statoAnnuncio` set('inVendita','venduto','eliminato') NOT NULL DEFAULT 'inVendita',
  `titolo` varchar(150) NOT NULL,
  `prodotto` varchar(30) NOT NULL,
  `categoria` set('elettrodomestici','fotoEVideo','abbigliamento','hobby') NOT NULL,
  `sottoCategoria` set('aspirapolveri','caffettiere','tostapane','frullatori','macchineFotografiche','accessori','telecamere','microfoni','vestiti','borse','scarpe','giocattoli','filmEDVD','musica','libriERiviste','altro') NOT NULL,
  `prezzo` float UNSIGNED NOT NULL,
  `statoUsura` set('comeNuovo','buono','medio','usurato') DEFAULT NULL,
  `tempoUsura` smallint(5) UNSIGNED NOT NULL,
  `scadenzaGaranzia` date DEFAULT NULL,
  `foto` varchar(40) DEFAULT NULL,
  `valutazioneSuVenditore` tinyint(6) UNSIGNED DEFAULT NULL,
  `visibilita` set('privata','pubblica','ristretta') NOT NULL,
  `comune` varchar(35) NOT NULL,
  `provincia` varchar(22) NOT NULL
) ;

--
-- Dump dei dati per la tabella `annuncio`
--

INSERT INTO `annuncio` (`dataOraPubblicazione`, `venditore`, `statoAnnuncio`, `titolo`, `prodotto`, `categoria`, `sottoCategoria`, `prezzo`, `statoUsura`, `tempoUsura`, `scadenzaGaranzia`, `foto`, `valutazioneSuVenditore`, `visibilita`, `comune`, `provincia`) VALUES
('2021-01-11 00:12:53', 'PRGDRD99M23F133R', 'inVendita', 'Ramponi da montagna', 'ramponi', 'hobby', 'altro', 50, 'buono', 7, NULL, '17b54ace9e87994384adc1c2b1747d9f.jpg', NULL, 'pubblica', 'Merate', 'Lecco'),
('2021-01-11 01:00:23', 'PNZGNR67L16C351I', 'inVendita', 'La caffettiera della nonna', 'caffettiera', 'elettrodomestici', 'caffettiere', 37, 'medio', 40, NULL, 'c5aa8c8a12f6c6636ac8dd19ecd80af2.jpg', NULL, 'pubblica', 'Palermo', 'Palermo'),
('2021-01-11 19:29:20', 'DNTLCU63A01C803H', 'inVendita', 'Apple Pencil ancora nella scatola mai aperta', 'Apple Pencil', 'hobby', 'altro', 70, NULL, 0, NULL, '85f2ca787ab09b3e041129ed5470c715.jpg', NULL, 'pubblica', 'Alpette', 'Torino'),
('2021-01-11 19:34:10', 'LLLSCN71R18A271O', 'inVendita', 'paperetta di gomma nuova, c\'era il 2x1', 'papera di gomma', 'hobby', 'giocattoli', 3.5, NULL, 0, NULL, 'ddd15c4e0d2c694fbb017bea816197b3.jpg', NULL, 'pubblica', 'Camerano', 'Ancona'),
('2021-01-11 21:58:27', 'PNACCL83E41G713I', 'venduto', 'Vaso con fiori rossi in ceramica', 'vaso', 'hobby', 'altro', 24, 'comeNuovo', 8, NULL, '0b442f3a9b24de6ee2d321979ab145cb.jpg', 4, 'pubblica', 'Pistoia', 'Pistoia'),
('2021-01-11 22:03:23', 'PNACCL83E41G713I', 'venduto', 'Reflex appena presa', 'Reflex', 'fotoEVideo', 'macchineFotografiche', 350, 'comeNuovo', 1, NULL, NULL, 4, 'pubblica', 'Pistoia', 'Pistoia'),
('2021-01-11 22:22:54', 'CLMMTN00L51A794O', 'inVendita', 'borsa rossa alla moda', 'borsa ', 'abbigliamento', 'borse', 39, 'comeNuovo', 3, NULL, NULL, NULL, 'pubblica', 'Bergamo', 'Bergamo'),
('2021-01-11 22:32:28', 'CRVLRT87R11C559Q', 'inVendita', 'Quadro su papiro', 'quadro', 'hobby', 'altro', 25, 'usurato', 83, NULL, '4b2b286a3765df26df8a0d79b92af80b.jpg', NULL, 'pubblica', 'Imperia', 'Imperia'),
('2021-01-11 22:44:33', 'CSTNAI91R69G113A', 'inVendita', 'DVD le crociate', 'DVD', 'hobby', 'filmEDVD', 10, 'comeNuovo', 18, NULL, '7a7a2d7c9ff429cc5f4d28e997b577fe.jpg', NULL, 'pubblica', 'Sassari', 'Sassari'),
('2021-01-11 23:14:21', 'RSSCTR96D57A401O', 'inVendita', 'carte per tarocchi', 'tarocchi', 'hobby', 'altro', 210, 'buono', 70, NULL, '0173532172f5a87af2ef207d6250bf42.jpg', NULL, 'pubblica', 'Roma', 'Roma'),
('2021-01-12 20:27:47', 'PNACCL83E41G713I', 'venduto', 'Clean code per imparare a programmare', 'libro', 'hobby', 'libriERiviste', 25, 'comeNuovo', 3, NULL, 'f65d500af1bb1da7c101c19255e1ea09.jpg', NULL, 'pubblica', 'Pistoia', 'Pistoia'),
('2021-01-12 20:28:22', 'PNACCL83E41G713I', 'venduto', 'Nel Vuoto di Alex Honnold', 'libro', 'hobby', 'libriERiviste', 20, 'comeNuovo', 2, NULL, '7403a1d0d5e8afdb7244a7c6ad17419d.jpg', 2, 'pubblica', 'Pistoia', 'Pistoia'),
('2021-01-12 20:32:55', 'RSSVNC97R06B157T', 'inVendita', 'Collezione Divina commedia tre volumi, Dante Alighieri', 'libri', 'hobby', 'libriERiviste', 50, NULL, 0, NULL, '0f3c618628d7557a354290c5c5452f43.jpg', NULL, 'pubblica', 'Roncadelle', 'Brescia'),
('2021-01-12 20:35:57', 'SLMBRN92B16D205T', 'inVendita', 'Buoni o cattivi cd di Vasco Rossi', 'cd', 'hobby', 'musica', 15, 'buono', 36, NULL, '7e9e7e880b70be408bce70a64975fc2b.jpg', NULL, 'pubblica', 'Barolo', 'Cuneo'),
('2021-01-12 20:39:44', 'PNZGNR67L16C351I', 'inVendita', 'Chitarra edizione limitata LIDL', 'chitarra', 'hobby', 'musica', 120, 'comeNuovo', 47, NULL, '2eb6996544fefa16dd5075bb1cfcc30e.jpeg', NULL, 'pubblica', 'Palermo', 'Palermo'),
('2021-01-13 13:19:09', 'RSSCTR96D57A401O', 'inVendita', 'Chitarra gipsy', 'chitarra', 'hobby', 'musica', 250, 'buono', 132, NULL, 'e5835e5976fbade6b32818976bf7f056.jpg', NULL, 'pubblica', 'Agosta', 'Roma'),
('2021-01-13 13:23:28', 'CRVLRT87R11C559Q', 'inVendita', 'Trattore vissuto', 'trattore', 'hobby', 'altro', 2900, 'usurato', 300, NULL, '61c40902b92878d2b8172689506bf0f4.jpeg', NULL, 'pubblica', 'Imperia', 'Imperia'),
('2021-01-13 13:28:51', 'SLMBRN92B16D205T', 'inVendita', 'Picca d\'alpinismo della petzl', 'picca', 'hobby', 'altro', 100, 'comeNuovo', 1, NULL, '3267de5c0053888e06cd954861de2f7a.jpeg', NULL, 'pubblica', 'Cuneo', 'Cuneo'),
('2021-01-13 18:38:20', 'PRGDRD99M23F133R', 'inVendita', 'Frontale vissuta ad incandescenza funzionante', 'torcia frontale', 'abbigliamento', 'altro', 25, 'buono', 327, NULL, 'fc8b03cc0c447c5524b620599396029a.jpg', NULL, 'pubblica', 'Calco', 'Lecco'),
('2021-01-13 18:43:28', 'LHRMRG99A41E801X', 'inVendita', 'Tazza Oracle con fondo in sughero', 'tazza', 'hobby', 'altro', 30, 'comeNuovo', 2, NULL, 'd0163a9aed80448f90890febd127bcae.jpeg', NULL, 'pubblica', 'Magenta', 'Milano'),
('2021-01-13 18:44:14', 'LHRMRG99A41E801X', 'venduto', 'Tazza Cars 2', 'tazza', 'hobby', 'altro', 20, 'comeNuovo', 3, NULL, '2380658485a1ed98f77fa8c70e1c8335.jpeg', 3, 'pubblica', 'Magenta', 'Milano'),
('2021-01-13 18:47:12', 'PRCRRT83H11A014Q', 'inVendita', 'Pantaloni Ande da montagna pesanti nuovi', 'pantaloni', 'abbigliamento', 'vestiti', 75, NULL, 0, NULL, '3479a61fde90826cea3cdd668b4c47c9.jpg', NULL, 'pubblica', 'Acate', 'Ragusa'),
('2021-01-13 18:48:03', 'PRCRRT83H11A014Q', 'inVendita', 'Pantaloni Ande da montagna blu  nuovi', 'pantaloni', 'abbigliamento', 'vestiti', 70, NULL, 0, NULL, '1cb76f7770abac455d5284e0aaf25118.jpg', NULL, 'pubblica', 'Acate', 'Ragusa'),
('2021-01-14 20:55:19', 'DNTLCU63A01C803H', 'venduto', 'Gibson Les Paul originale', 'chitarra', 'hobby', 'musica', 1500, 'comeNuovo', 240, NULL, 'c6d807828ce13eba15bd39579052ab43.jpg', NULL, 'pubblica', 'Torino', 'Torino'),
('2021-01-14 21:01:33', 'DNTLCU63A01C803H', 'inVendita', 'Doppio pedale IRON COBRA per batteria', 'doppio pedale', 'hobby', 'musica', 150, 'comeNuovo', 120, NULL, '797fabcd96cd67fc0e7ef0d48238a219.jpg', NULL, 'pubblica', 'Torino', 'Torino'),
('2021-01-14 21:09:13', 'CLMMTN00L51A794O', 'venduto', 'Scarpette d\'arrampicata nuove del 38 (numero sbagliato)', 'scarpe d\'arrampicata', 'abbigliamento', 'scarpe', 40, NULL, 0, NULL, '5a84e3abf95be50cc78863a17aa5455c.jpeg', 4, 'pubblica', 'Bergamo', 'Bergamo'),
('2021-01-14 21:12:47', 'LHRMRG99A41E801X', 'inVendita', 'Lampada in bambu', 'lampada', 'hobby', 'altro', 35, 'comeNuovo', 1, NULL, 'ca261f032b576987786693610dc0d15c.jpg', NULL, 'pubblica', 'Magenta', 'Milano'),
('2021-01-14 21:18:03', 'CSTNAI91R69G113A', 'inVendita', 'Slackline per equilibrismo mai usata', 'slackline', 'hobby', 'altro', 30, NULL, 0, NULL, 'd4c0d23922a8be5336fef0300c5ad7e9.jpeg', NULL, 'pubblica', 'Olbia', 'Sassari'),
('2021-01-14 21:21:14', 'LLLSCN71R18A271O', 'inVendita', 'Ventilatore usato', 'ventilatore', 'elettrodomestici', 'altro', 40, 'comeNuovo', 24, NULL, '3828541a7371cd5daf32da836b17fe01.jpg', NULL, 'pubblica', 'Ancona', 'Ancona'),
('2021-01-14 21:25:26', 'PRCRRT83H11A014Q', 'inVendita', 'Secchiello d\'arrampicata per alpinismo', 'discensore', 'hobby', 'altro', 20, NULL, 0, NULL, 'ce5b8b3fc73d702ef27f485fdafedbcf.jpeg', NULL, 'pubblica', 'Barolo', 'Cuneo'),
('2021-01-14 21:29:25', 'PNZGNR67L16C351I', 'inVendita', 'scarpe antinfortunistiche nuove', 'scarpe antinfortunistiche', 'abbigliamento', 'scarpe', 40, NULL, 0, NULL, '08c9bcd85ec9c0bdbdf65b0472b8c2e4.jpeg', NULL, 'pubblica', 'Palermo', 'Palermo'),
('2021-01-14 21:31:50', 'RSSCTR96D57A401O', 'venduto', 'palla da baseball pericolosa, pesante', 'palla da baseball', 'hobby', 'altro', 10, 'buono', 2, NULL, '077da4e9a8c50e427bbb2f628be4b7fa.jpg', 3, 'pubblica', 'Roma', 'Roma'),
('2021-01-15 14:50:52', 'SLGDRA97A41E801X', 'venduto', 'Frullatore tritatutto', 'frullatore', 'elettrodomestici', 'frullatori', 28, 'comeNuovo', 6, NULL, NULL, NULL, 'pubblica', 'Abriola', 'Potenza'),
('2021-01-15 14:53:42', 'SFGLNE12B69A288U', 'inVendita', 'tostapane nuovo', 'tostapane', 'elettrodomestici', 'tostapane', 35, NULL, 0, '2021-12-23', NULL, NULL, 'pubblica', 'Brescia', 'Brescia'),
('2021-01-15 14:58:36', 'RGNGNN97R13L736H', 'venduto', 'Bicicletta Bianchi del \'99', 'bicicletta', 'hobby', 'altro', 25, 'buono', 240, NULL, '6012a309566c4956cf0f4aa3ca66f5a7.jpg', NULL, 'pubblica', 'Venezia', 'Venezia'),
('2021-01-15 15:51:05', 'BCCGRT89R52E617T', 'inVendita', 'Borraccia per città colorata', 'borraccia', 'hobby', 'altro', 10, 'comeNuovo', 2, NULL, '5d366f903c853bd0f182136a1d9247c9.jpeg', NULL, 'pubblica', 'Lissone', 'Monza e della Brianza'),
('2021-01-15 15:52:59', 'BCCGRT89R52E617T', 'inVendita', 'Lapislazzuli', 'pietre e minerali', 'hobby', 'altro', 12, NULL, 0, NULL, 'd34dca85a2d3bfad611a3f37b9d620b7.jpg', NULL, 'pubblica', 'Lissone', 'Monza e della Brianza'),
('2021-01-15 15:56:31', 'RGNGNN97R13L736H', 'inVendita', 'telecamera frontale per sport mai aperta', 'telecamera frontale', 'fotoEVideo', 'altro', 25, NULL, 0, NULL, '2206ee489f7447be963cc7a5f8a785a0.jpg', NULL, 'pubblica', 'Venezia', 'Venezia'),
('2021-01-15 15:58:27', 'PRCRRT83H11A014Q', 'inVendita', 'Guida alle falesie del bergamasco', 'libro', 'hobby', 'libriERiviste', 30, NULL, 0, NULL, 'ed72765553e568262ce56690c3326baf.jpeg', NULL, 'pubblica', 'Acate', 'Ragusa'),
('2021-01-18 22:48:04', 'RSSVNC97R06B157T', 'inVendita', 'tazzina da caffè bella ', 'tazzina da caffé', 'hobby', 'altro', 5, 'comeNuovo', 2, NULL, NULL, NULL, 'pubblica', 'Brescia', 'Brescia'),
('2021-01-19 23:30:08', 'RGNGNN97R13L736H', 'inVendita', 'Schiaccianoci in metallo', 'schiaccianoci', 'hobby', 'altro', 7, 'comeNuovo', 19, NULL, NULL, NULL, 'pubblica', 'Venezia', 'Venezia'),
('2021-01-19 23:36:06', 'RGNGNN97R13L736H', 'inVendita', 'frullatore raramente usato multiuso', 'frullatore moderno', 'elettrodomestici', 'frullatori', 100, 'comeNuovo', 2, NULL, 'b9e31cb634542472b45e2db83d05965f.jpg', NULL, 'pubblica', 'Venezia', 'Venezia'),
('2021-01-19 23:42:01', 'RGNGNN97R13L736H', 'inVendita', 'tostapane bialetti ', 'tostapane', 'elettrodomestici', 'tostapane', 15, 'comeNuovo', 5, NULL, 'fbb47e8784b471548bd10108c56e9290.jpg', NULL, 'pubblica', 'Venezia', 'Venezia'),
('2021-01-19 23:44:33', 'PRCRRT83H11A014Q', 'inVendita', 'tostapane professionale', 'tostapane professionale', 'elettrodomestici', 'tostapane', 120, 'comeNuovo', 8, NULL, 'e2b8a242cd119bb4b3340063ba0be5b8.jpg', NULL, 'pubblica', 'Palermo', 'Palermo'),
('2021-01-19 23:47:27', 'SLMBRN92B16D205T', 'inVendita', 'treppiedi per fotocamera', 'treppiedi', 'fotoEVideo', 'accessori', 15, 'comeNuovo', 1, NULL, NULL, NULL, 'pubblica', 'Cuneo', 'Cuneo'),
('2021-01-19 23:55:08', 'PNACCL83E41G713I', 'venduto', 'Borsa Armani Jeans Color Bordeaux, Usata Pochissime Volte ', 'Borsa Armani', 'abbigliamento', 'borse', 100, 'comeNuovo', 3, NULL, 'a3a3f39155ca3d5917223333b571d766.jpg', NULL, 'pubblica', 'Pistoia', 'Pistoia'),
('2021-01-20 00:03:20', 'BCCGRT89R52E617T', 'venduto', 'Microfono AKG C 2000 B da registrazione', 'microfono da registrazione', 'fotoEVideo', 'microfoni', 100, 'buono', 48, NULL, '76bb833fcfbaca16bab795d55d15a731.jpg', NULL, 'pubblica', 'Lissone', 'Monza e della Brianza');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `annuncio`
--
ALTER TABLE `annuncio`
  ADD PRIMARY KEY (`dataOraPubblicazione`,`venditore`),
  ADD KEY `annuncio_fk1` (`venditore`),
  ADD KEY `annuncio_fk2` (`comune`,`provincia`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `annuncio`
--
ALTER TABLE `annuncio`
  ADD CONSTRAINT `annuncio_fk1` FOREIGN KEY (`venditore`) REFERENCES `utente` (`codiceFiscale`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `annuncio_fk2` FOREIGN KEY (`comune`,`provincia`) REFERENCES `areageografica` (`comune`, `provincia`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
