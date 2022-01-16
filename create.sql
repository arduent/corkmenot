SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `cards`
(
    `idx`      bigint(20) UNSIGNED                    NOT NULL,
    `cardid`   varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `oby`      int(10) UNSIGNED                       NOT NULL DEFAULT 0,
    `msg`      text COLLATE utf8mb4_unicode_ci        NOT NULL DEFAULT '',
    `sequence` int(10) UNSIGNED                       NOT NULL DEFAULT 0
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `failed_logins`
(
    `idx`      int(10) UNSIGNED                        NOT NULL,
    `email`    varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
    `ip`       varchar(64) COLLATE utf8mb4_unicode_ci  NOT NULL,
    `sequence` int(10) UNSIGNED                        NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `logins`
(
    `idx`    int(10) UNSIGNED                        NOT NULL,
    `uid`    int(10) UNSIGNED                        NOT NULL DEFAULT 0,
    `au`     varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `login`  int(10) UNSIGNED                        NOT NULL DEFAULT 0,
    `logout` int(10) UNSIGNED                        NOT NULL DEFAULT 0,
    `ip`     varchar(64) COLLATE utf8mb4_unicode_ci  NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `stories`
(
    `idx`      int(10) UNSIGNED                        NOT NULL,
    `uid`      int(10) UNSIGNED                        NOT NULL,
    `title`    varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `sequence` int(10) UNSIGNED                        NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `users`
(
    `idx`      int(10) UNSIGNED                        NOT NULL,
    `email`    varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
    `pwd`      varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `ip`       varchar(64) COLLATE utf8mb4_unicode_ci  NOT NULL,
    `sequence` int(10) UNSIGNED                        NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;


ALTER TABLE `cards`
    ADD PRIMARY KEY (`idx`);

ALTER TABLE `failed_logins`
    ADD PRIMARY KEY (`idx`);

ALTER TABLE `logins`
    ADD PRIMARY KEY (`idx`);

ALTER TABLE `stories`
    ADD PRIMARY KEY (`idx`);

ALTER TABLE `users`
    ADD PRIMARY KEY (`idx`);


ALTER TABLE `cards`
    MODIFY `idx` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `failed_logins`
    MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `logins`
    MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `stories`
    MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
    MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
