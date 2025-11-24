CREATE TABLE estudiantes (
id INT PRIMARY KEY AUTO INCREMENT,
nombre VARCHAR(100),
ci VARCHAR(20),
email VARCHAR(100)
CREATE TABLE materias (
id INT PRIMARY KEY AUTO INCREMENT,
nombre VARCHAR(100)
CREATE TABLE notas (
id INT PRIMARY KEY AUTO INCREMENT,
estudiante_id INT,
materia id INT
nota. DECIMAL(4,2),
FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id),
FOREIGN KEY (materia_id) REFERENCES materias(id)