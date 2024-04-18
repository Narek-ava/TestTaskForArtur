
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(64) NOT NULL,
    `token`varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `orders` (
                         `ID` int(11) NOT NULL,
                         `detail` varchar(50) NOT NULL,
                         `user_id` varchar(200) NOT NULL,
                         `status` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `users` (`ID`, `username`, `email`, `password`,`token`) VALUES
(6, '12', '12@gmail.com', '202cb962ac59075b964b07152d234b70', 'awdawdwad23423e3dwadawd'),
(7, 'Narek', 'ess_allam@yahoo.com', '81dc9bdb52d04dc20036dbd8313ed055','awdawdwad23423e3dwadawd'),
(8, 'Arman', 'arman@gmail.com', 'e10adc3949ba59abbe56e057f20f883e','awdawdwad23423e3dwadawd');


ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);
ALTER TABLE `orders`
    ADD PRIMARY KEY (`ID`);

ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

ALTER TABLE `orders`
    MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;