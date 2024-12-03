-- Création de la table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user'
);

-- Ajout des utilisateurs (avec hachage des mots de passe)
INSERT INTO users (username, password, role) VALUES
('Hacker42', '$2y$10$O3pO.dYSYOmMrKUHi2neN.kzA13dMlca6D9ieESxCjyBg6OZ6cnHO', 'admin'), -- Mot de passe : "admin_h42"
('Admin', '$2y$10$EyGEinI02zX3F8weArtEf.fgwhsGlCmlB4U42sXWSY7NgeCrZJFty', 'admin'), -- Mot de passe : "admin_root"
('KevinMitnick', '$2y$10$XFTzUdS46vOpoyI2OLFxKuyrUWaUjQ/Nh9JbQikFbB9GSKiv9UkaG', 'user'), -- Mot de passe : "mitnick123"
('AdrianLamo', '$2y$10$MfR8IW6kBID.kF8syKPmReJl.lB7WqsDbYTkmAnPuVeYPOT52cX4O', 'user'), -- Mot de passe : "lamo1234"
('GaryMcKinnon', '$2y$10$UChlDzUQQRm1qUb6me0TOOOPjs9kxOoHc3LSZBNzohwROxBF1cJcW', 'user'), -- Mot de passe : "gary2002"
('AlbertGonzalez', '$2y$10$Id6z0GlwQFzTTWoBLvup8e3jVVRsRdMHQEY6TuHYbweIsYrREWqGa', 'user'), -- Mot de passe : "soupnazi"
('JonathanJames', '$2y$10$CgxTLMthmk7ttrHWIfQLsefwJwTzxTxILbDJwLT4Hy4IcRMh.F9Cu', 'user'), -- Mot de passe : "c0mrade"
('GeorgeHotz', '$2y$10$VY2j8Z5A39nbVpQ6vQwzZOv6.ihyfi.A9ivR7Wq2xCjmc7SD6cJ4i', 'user'), -- Mot de passe : "geohotz"
('MatthewBevan', '$2y$10$stE1c8BhmDN6.KaZ2vQ9OOV4u.E/zpN8PRbG7Wt.KmjoLTv4M8e0i', 'user'), -- Mot de passe : "kuji123"
('LoydBlankenship', '$2y$10$uZzZFT50v6jK9Ipu.BsMHuF.HXFS9rnBZZOX/Jo0fbsKx3sBOG6Ea', 'user'); -- Mot de passe : "mentor01"


CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    content TEXT NOT NULL,
    file_path VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
