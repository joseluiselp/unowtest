CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` ENUM('Doctor', 'Patient') NOT NULL DEFAULT 'Patient',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `appointments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `patient_id` bigint(20) unsigned NOT NULL,
  `start_date` bigint(20) NOT NULL,
  `end_date` bigint(20) NOT NULL,
  `status` ENUM('Created', 'Accepted', 'Declined') NOT NULL DEFAULT 'Created',
  PRIMARY KEY (`id`),
  CONSTRAINT FK_doctor_id FOREIGN KEY (doctor_id) REFERENCES users(id),
  CONSTRAINT FK_user_id FOREIGN KEY (patient_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (username, password, email, type) values
('josemendoza', '$2a$12$na4UMlso2C0UokZlODVZheXjnhKrfSi.6CwJUzCSiEGLRwdQqD4TO', 'joseluiselp@gmail.com', 'Doctor'),
('soheavila', '$2a$12$na4UMlso2C0UokZlODVZheXjnhKrfSi.6CwJUzCSiEGLRwdQqD4TO', 'sohecdy@gmail.com', 'Doctor'),
('isabelmolina', '$2a$12$na4UMlso2C0UokZlODVZheXjnhKrfSi.6CwJUzCSiEGLRwdQqD4TO', 'isabelmolina@gmail.com', 'Patient'),
('cris10', '$2a$12$na4UMlso2C0UokZlODVZheXjnhKrfSi.6CwJUzCSiEGLRwdQqD4TO', 'cristina@gmail.com', 'Patient')