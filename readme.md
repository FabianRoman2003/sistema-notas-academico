# 📘 Sistema de Notas Académicas  
**Examen Final – Desarrollo de Sistemas II**

Este proyecto es una aplicación web que permite registrar estudiantes, materias y notas, además de consultar promedios y visualizar toda la información de manera organizada. Cumple con todos los requisitos del examen práctico individual.

---

## 🧩 Características del Sistema

✔ Registrar estudiantes  
✔ Registrar materias  
✔ Registrar notas  
✔ Validación de notas (0 a 100)  
✔ Select dinámico de estudiantes y materias  
✔ Ver todas las notas de un estudiante  
✔ Ver el promedio del estudiante  
✔ Ver todas las notas del sistema  
✔ Visual moderno, profesional y legible  
✔ Tablas en modo oscuro  
✔ Botones estilizados  
✔ Listo para entrega como examen final  

---

## 🏗️ Tecnologías Utilizadas

- **PHP 8**
- **PHPMYADMIN**
- **XAMPP**
- **HTML5**
- **CSS3 (tema oscuro profesional)**
- **Bootstrap 5**

---

## 🗂️ Estructura de Base de Datos

### Tabla: estudiantes
| Campo | Tipo |
|-------|------|
| id (PK) | INT AUTO_INCREMENT |
| nombre | VARCHAR(100) |
| ci | VARCHAR(20) |
| email | VARCHAR(100) |

### Tabla: materias
| Campo | Tipo |
|-------|------|
| id (PK) | INT AUTO_INCREMENT |
| nombre | VARCHAR(100) |

### Tabla: notas
| Campo | Tipo |
|-------|------|
| id (PK) | INT AUTO_INCREMENT |
| estudiante_id | INT |
| materia_id | INT |
| nota | DECIMAL(5,2) |

---

## 🔗 Relaciones

- Un **estudiante** tiene muchas *notas*  
- Una **materia** tiene muchas *notas*  
- La tabla **notas** conecta estudiante ↔ materia  

---

## 🖥️ Pantallas Principales

### 🏠 Home
- Lista de estudiantes  
- Botones para agregar estudiante, materia y nota  
- Botón para ver todas las notas  

### ➕ Registrar Estudiante
Formulario con:
- Nombre  
- CI  
- Email  

### ➕ Registrar Materia  
Formulario simple con nombre  

### 📝 Registrar Nota  
- Select para estudiante  
- Select para materia  
- Input de nota (0–100)  
- Validaciones completas  

### 📄 Ver Notas por Estudiante  
- Materia + Nota  
- Promedio final del estudiante  

### 📊 Ver Todas las Notas  
- Tabla completa con estudiantes, materias y notas  
- Tabla con promedios por estudiante  

---

## ⚙️ Instalación

1. Clonar el repositorio:
```bash
https://github.com/FabianRoman2003/sistema-notas-academico
