CREATE DATABASE IF NOT EXISTS `perpus`;
USE `perpus`;

CREATE TABLE `detail_pinjam` (
  tgl_pinjam date NOT NULL,
  tgl_kembali date NOT NULL
);
