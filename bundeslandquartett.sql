-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 04, 2023 at 07:52 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bundeslandquartett`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards-bonus`
--

CREATE TABLE `cards-bonus` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `text` text NOT NULL,
  `points` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cards-bonus`
--

INSERT INTO `cards-bonus` (`id`, `name`, `text`, `points`, `time`) VALUES
(0, '312€', 'Besucht eine der Landesrundfunkanstalten an ihrem Hauptsitz , wie in der Liste eingetragen und siehe dir ein min. 10 minütiges Video der jeweiligen Landesrundfunkanstalt vor Ort an: https://de.wikipedia.org/wiki/Landesrundfunkanstalt', 50, 30),
(1, 'Ich finde Wein lecker', 'Geh in eine Bar und frage nach Shots eines regionalen Schnapps. Trinkt davon min. 2 auf das Team verteilt.', 75, 45),
(2, 'Der Tourist', 'Suche mit Tripadvisor (”Stadtname” Things to do), die nichts oder nur seeeehr wenig kosten, freie Auswahl unter den Top 5 auf die dies zutrifft: https://www.tripadvisor.de/', 50, 30),
(3, 'Häuptling faltiger Fuchs', 'Findet einen Ort, der nach Adenauer benannt ist und das dazugehörige Schild (Straße, Platz, etc.)', 50, 30),
(4, 'UNO', 'Ein UNESCO Weltkulturerbe besuchen: https://www.unesco.de/kultur-und-natur/welterbe/welterbe-deutschland/welterbestaetten-deutschland', 50, 30),
(5, 'Das Geschäft', 'Gratis öffentliche Toilette besuchen und benutzen: Gratispinkeln.de', 75, 45),
(6, 'Der Stern, JULIAN', 'Einen Unfallschwerpunkt besuchen. Min 10 Unfälle laut dem Unfallatlas: https://unfallatlas.statistikportal.de/', 50, 30),
(7, 'Der Künstler', 'Male ein echtes Gemälde ab, dass du real siehst: min 3 Farben, nicht digital, min. DIN A5, kein leeres Blatt Papier als Grundlage → Gemälde muss erkennbar sein', 100, 60),
(8, 'Das Hufeisen finden', 'Ein Buch von Sarah Wagenknecht und Alice Weidel in der gleichen Bibliothek finden.', 75, 45),
(9, 'Mario Kart', 'Sammle 3 Items aus dem Spiel “Mario Kart”.', 50, 30),
(10, '420', 'Tätige einen Einkauf für exact 4,20€. Du darfst nicht freiwillig mehr oder weniger bezahlen. Du darfst nichts nach Gewicht/Menge einkaufen.', 50, 30),
(11, 'Der Wanderer', 'Lege zu Fuß 250 Höhenmeter zurück. Es dürfen keine Fahrzeuge oder andere Hilfen benutzt werden. Die Höhenmeter müssen nicht am Stück zurückgelegt werden.', 75, 45),
(12, 'Der Diplomat', 'Geht zu einer Botschaft oder einem Konsulats eines beliebigen Landes und singe die jeweilige Nationalhymne.', 50, 30),
(13, 'Der Übersetzer', 'Das ganze Team muss die Sprache ihrer Handys für 4h auf Niederländisch verstellen. Das gleiche gilt wenn möglich auch für alle anderen benutzten elektronischen Geräte.', 50, 30),
(14, '“Touch a cat”', 'Berühre eine Katze. Pls do (not) the cat!', 75, 45),
(15, 'Der Clown', 'Findet eine Halloween-Maske, die zum Verkauf steht.', 50, 30),
(16, 'Der Pilot', 'Falte einen Papierflieger. Werfe diesen danach min. 5m weit. Der Papierflieger muss der Form eines Flugzeugs ähneln.', 50, 30),
(17, 'Der Genießer', 'Macht euch einen Kaffe und trinkt diesen (min. 0,5l, also 0,25l pro Person). Kaffeautomaten zählen.', 50, 30),
(18, 'Der Frühaufsteher', 'Esse Frühstücke bei McDonalds', 75, 45);

-- --------------------------------------------------------

--
-- Table structure for table `cards-challenge`
--

CREATE TABLE `cards-challenge` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `text` text NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cards-challenge`
--

INSERT INTO `cards-challenge` (`id`, `name`, `text`, `time`) VALUES
(0, 'Nummernschilder', 'Wer ein Nummernschild findet, dass von am weitesten weg von seiner jetzigen Position herkommt.', 30),
(1, 'Vögel', 'Wer die meisten Vögel filmt.', 10),
(2, 'Essen', 'Wer mehr Bäcker besucht.', 20),
(3, 'ÖPNV', 'Wer mehr verschiedene ÖPNV-Linien fährt.', 20),
(4, 'Zoo', 'Wer die meisten verschiedenen Säugetiere fotografiert (Menschen ausgeschlossen).', 20),
(5, 'Der Kommunist', 'Wer am schnellsten “Das Kapital” oder “Das kommunistische Manifest” in den Händen hält (es darf nicht bei sich getragen worden sein).', 45),
(6, 'Chef', 'Wer den günstigsten Döner (mit allem und Fleisch) findet.', 15),
(7, 'Der Steinhauer', 'Wer mehr Statuen findet.', 15);

-- --------------------------------------------------------

--
-- Table structure for table `cards-main`
--

CREATE TABLE `cards-main` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `text` text NOT NULL,
  `points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cards-main`
--

INSERT INTO `cards-main` (`id`, `name`, `text`, `points`) VALUES
(0, 'Der Bergsteiger', 'Begebe dich innerhalb von 50m zu dem höchsten natürlichen Punkt in dem Bundesland definiert nach dieser Liste: https://de.wikipedia.org/wiki/Liste_der_h%C3%B6chsten_Berge_der_deutschen_L%C3%A4nder', 100),
(1, 'I see no God up here', 'Begebe dich so nah wie erlaubt (wenn möglich auch in und auf das Gebäude), dass das höchste Bauwerk in dem Bundesland ist: https://de.wikipedia.org/wiki/Liste_der_h%C3%B6chsten_Bauwerke_in_Deutschland#H%C3%B6chste_Bauwerke_nach_Land', 50),
(2, 'Der Historiker', 'Begebe dich so nah wie erlaubt (wenn möglich auch in das Gebäude), dass das älteste Gebäude in dem Bundesland ist.', 0),
(3, 'Die Kurvendiskussion', 'Besuche einen der Extrempunkte Deutschlands nach dieser Liste: https://de.wikipedia.org/wiki/Liste_der_Extrempunkte_Deutschlands', 150),
(4, 'Mhh wooow', 'Jedes Teammitglied muss eine ganze Portion eines regionalen Gerichtes aufessen. Regionale Gerichte sind solche, die auf der jeweiligen Wikipediaunterseite “Bundesland Küche” genannt werden: https://de.wikipedia.org/wiki/Deutsche_K%C3%BCche', 0),
(5, 'Frag nicht was für Saft', 'Mosterei besuchen (Ort an dem lokaler Saft hergestellt wird) und dort produzierten Saft trinken', 25),
(6, 'Müll im Nationalpark sammeln', 'All den Müll, den man auf einem 20 Minuten Spaziergang sieht, einsammeln und korrekt entsorgen: https://de.wikipedia.org/wiki/Nationalparks_in_Deutschland', 50),
(7, 'Der Käpt\'n', '“Ich bin der Käpt’n zu See - Ich fahr die großen Pötte”\r\n\r\nMit einem Schiff/Boot (oder anderem für das Befahren von Wasser gedachten Transportmittel) fahren', 0),
(8, 'Die neue innerdeutsche Grenze', 'Aldi Süd und Aldi Nord im selben Bundesland besuchen.', 25),
(9, 'Schwanneustein', 'Schloss Neuschwanstein besuchen: https://de.wikipedia.org/wiki/Schloss_Neuschwanstein', 150),
(10, 'PHotosynthese', 'Sonnt euch. Strand muss an einem Gewässer sein und als Strand ausgewiesen sein. Min. 15 Minuten und die Sonne muss sichtbar sein.', 0),
(11, 'Das Geodreieck', 'Mein Land, das hat drei Ecken - Drei Ecken hat mein Land...\r\n\r\nDreiländereck - Zwischen Deutschland und zwei anderen Ländern: https://de.wikipedia.org/wiki/Dreil%C3%A4ndereck#Europa', 75),
(12, 'Der WeltAAL', 'Stadt mit einem Tier im Namen - z.B. AALen, Wolfsburg, etc. (Tier muss nicht gemeint sein → Kassel) besuchen', 0),
(13, 'Die Verkehrsinsel', 'Die Verkehrsinsel (weil ich hier verkehre)\r\n\r\nAuf eine Insel in einem Gewässer gehen und “HELP” mit Steinen legen, min. 30cm hoch und 130cm breit → muss gut lesbar sein', 25),
(14, 'Der Kameramann', '“Sie haben mich ins Gesicht gefilmt”\r\n\r\nEinen Politiker filmen. Namen muss zugeordnet werden können. Man darf sich nicht mit dem Politiker verabreden.', 100),
(15, '“I am about to cross a road.”', 'Etwas, wo es ein Tom Scott Video zu gibt besuchen und das Intro so gut wie möglich nachstellen. Zwei Playlists dazu (nicht auf Vollständigkeit geprüft): https://www.youtube.com/watch?v=cz231Zi8Z7g&list=PL6nrp80L2bT3Ke2XvwThwzz3BdGgsjATV\r\nund https://www.youtube.com/watch?v=vxfJbW6KDp4&list=PLroMBHEKnApZ8-IMIETUCTLewHvhpuz_j', 25),
(16, 'Reise zum Mittelpunkt der Erde', 'Einen der Mittelpunkte Deutschlands besuchen. Such dir einen aus: https://de.wikipedia.org/wiki/Mittelpunkte_Deutschlands', 100),
(17, 'r/unpopularopinion', 'Unpopuläres Museum besuchen - Tripadvisor (”Stadtname” Museum) niedrigstes Ergebnis nach “Traveler Rating, dass auf hat und klar als Museum zu verstehen ist → min. 30 Minuten sind im Museum zu verbringen: https://www.tripadvisor.de/', 25),
(18, 'Kreisklasse', 'Lokales Sportevent komplett anschauen - Von Anfang bis zum Ende, Größte, Sportart, Professionalität, etc. sind nicht von Bedeutung, muss aber organisiert sein', 75),
(19, 'Die unendliche Geschichte', 'Zum Ende einer U-Bahn/Straßenbahn/S-Bahn Linie fahren', 25),
(20, 'Der Mönch', 'Einen Japanischen oder Buddhistischen Tempel besuchen→ sollte stereotypisch aussehen und als solcher gekennzeichnet sein.', 50),
(21, 'Das Schwarzbier', 'Besuche etwas, dass das größte seiner Art weltweit ist - es muss das ding mehrere mal weltweit geben. Beispiele: https://www.germany.travel/de/inspiring-germany/rekordverdaechtig-komisch-typisch-deutschlandsrekorde-und-superlative.html', 50),
(22, '“Früher war alles besser”', 'Ohne Internet den Weg in ein Bundesland und zur Landes- hauptstadt und wieder aus dem Bundesland heraus ohne direkten oder indirekten Internetzugang (Passante, Reiseinfo, Automaten, etc.) bereisen. Stadtstaaten ausgenommen.', 50),
(23, 'Das 17. Bundesland', 'Einen Flug nach Mallorca am Flughafen beim Abheben/Landen beobachten.', 50),
(24, 'Wasserratte im Wasserloch', 'Geht im größten beschwimmbaren See des Bundeslandes mit dem gesamten Körper baden: https://de.wikipedia.org/wiki/Liste_der_gr%C3%B6%C3%9Ften_Seen_in_Deutschland', 100),
(25, 'Die Lösung', 'Seht euch den Auftritt eines Künster*inns/Künstlergruppe komplett an.', 75),
(26, 'Der Kanzler', 'Besteige einen Jagd-Hochsitz', 50),
(27, 'Der Pilgerer', '1km des Jacobs-Wegs in einem Bundesland laufen: https://www.jakobsweg.de/deutschland/', 75),
(28, 'Der Süchtige', 'Ein Kartenspiel als Geschenk (max. 1€) finden und eine Runde spielen: https://www.kleinanzeigen.de/s-kartenspiele-zu-verschenken/k0', 25);

-- --------------------------------------------------------

--
-- Table structure for table `events-cards-bonus`
--

CREATE TABLE `events-cards-bonus` (
  `id` int(11) NOT NULL,
  `team-id` int(11) NOT NULL,
  `cards-bonus-id` int(11) NOT NULL,
  `done` tinyint(1) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events-cards-challenge`
--

CREATE TABLE `events-cards-challenge` (
  `id` int(11) NOT NULL,
  `team-id-1` int(11) NOT NULL,
  `team-id-2` int(11) NOT NULL,
  `cards-challenge-id` int(11) NOT NULL,
  `state-id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `done` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events-cards-main`
--

CREATE TABLE `events-cards-main` (
  `id` int(11) NOT NULL,
  `team-id` int(11) NOT NULL,
  `states-id` int(11) NOT NULL,
  `done` tinyint(1) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cards-main-id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `points` int(11) NOT NULL,
  `locked` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `points`, `locked`) VALUES
(0, 'Bayern', 500, 0),
(1, 'Niedersachsen', 500, 0),
(2, 'Baden-Württemberg', 500, 0),
(3, 'Nordrhein-Westfalen', 500, 0),
(4, 'Brandenburg', 500, 0),
(5, 'Mecklenburg-Vorpommern', 500, 0),
(6, 'Hessen', 500, 0),
(7, 'Sachsen-Anhalt', 500, 0),
(8, 'Rheinland-Pfalz', 500, 0),
(9, 'Sachsen', 500, 0),
(10, 'Schleswig-Holstein', 500, 0),
(11, 'Thüringen', 500, 0),
(12, 'Saarland', 500, 0),
(13, 'Berlin', 350, 0),
(14, 'Hamburg', 350, 0),
(15, 'Bremen', 350, 0);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `points` int(11) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cards-bonus`
--
ALTER TABLE `cards-bonus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cards-challenge`
--
ALTER TABLE `cards-challenge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cards-main`
--
ALTER TABLE `cards-main`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events-cards-bonus`
--
ALTER TABLE `events-cards-bonus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events-cards-challenge`
--
ALTER TABLE `events-cards-challenge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events-cards-main`
--
ALTER TABLE `events-cards-main`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events-cards-bonus`
--
ALTER TABLE `events-cards-bonus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `events-cards-challenge`
--
ALTER TABLE `events-cards-challenge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `events-cards-main`
--
ALTER TABLE `events-cards-main`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
