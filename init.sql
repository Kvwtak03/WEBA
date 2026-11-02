SET NAMES utf8mb4; -- bot poradil, jinak nefungovala česká písmkenka

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jmeno VARCHAR(15) NOT NULL,
    prijmeni VARCHAR(25) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE, 
    telefon VARCHAR(13),
    pracovna VARCHAR(10),
    popisek TEXT,
    heslo VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0, -- 1 = je správce, 0 = běžný uživatel
    last_login DATETIME NULL 
);



-- docker exec -it kmi_mysql_db mysql -u root -pheslo univerzita