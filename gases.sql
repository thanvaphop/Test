
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";

CREATE TABLE `gases` (
  `id` int(11) NOT NULL,
  `CO` int(11) NOT NULL,
  `AQI` int(11) NOT NULL,
  `NO2` int(11) NOT NULL,
  `O3` int(11) NOT NULL,
  `FineParticles` int(11) NOT NULL,
  `CourseParticles` int(11) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `gases`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `gases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;
