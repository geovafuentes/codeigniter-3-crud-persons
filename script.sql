CREATE TABLE persons (
  id int NOT NULL,
  first_name varchar(100) NOT NULL,
  last_name varchar(100) NOT NULL,
  email varchar(100) NOT NULL,
  created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP
)

CREATE TABLE users (
  id int NOT NULL,
  username varchar(100) NOT NULL,
  password varchar(255) NOT NULL
)

INSERT INTO users (id, username, password) VALUES
(1, 'admin', 'admin');

INSERT INTO persons (id, first_name, last_name, email, created_at) VALUES
(1, 'Ana', 'Gonzalez', 'anita220571@gmail.com', '2024-05-21 20:09:49'),
(2, 'Geovany', 'Pineda', 'geofuentes.gf@gmail.com', '2024-05-21 20:21:53'),
(3, 'ghhg', 'Federico', 'anita220571@gmail.com', '2024-05-21 20:23:50'),
(4, 'Carlos', 'Federico', 'fede1234@gmail.com', '2024-05-21 20:24:00'),
(6, 'Monica', 'Herrera', 'monica.valdivaldi@gmail.com', '2024-05-21 20:28:18'),
(7, 'Monica', 'Valdivieso Herrera', 'monica.valdivaldi@gmail.com', '2024-05-21 20:30:03');