CREATE TABLE `login_attempts` (
  `user_id` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `clientip` varchar(32) NOT NULL
);
CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `email` varchar(64) NOT NULL,
  `displayname` varchar(64) NOT NULL,
  `imageurl` varchar(256) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(8) NOT NULL,
  `email_verification` varchar(32) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `blocked` tinyint(1) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE `pictures` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `path` varchar(128) NOT NULL
);
CREATE TABLE `session_token` (
  `session` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `browser` varchar(64) NOT NULL,
  `ip` varchar(64) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
CREATE TABLE `upload_token` (
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL
);
ALTER TABLE `login_attempts`
  ADD KEY `username` (`user_id`);
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `session_token`
  ADD UNIQUE KEY `session` (`session`);
ALTER TABLE `upload_token`
  ADD PRIMARY KEY (`token`);
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
ALTER TABLE `pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
