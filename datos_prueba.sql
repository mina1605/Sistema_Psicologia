-- ============================================================
--  DATOS DE PRUEBA — Sistema CEPS
--  Ejecutar en phpMyAdmin → pestaña SQL
--  Base de datos: psicologia
-- ============================================================

-- ── 1. USUARIO ADMINISTRADOR (login: admin@ceps.mx / ceps2024) ──
INSERT IGNORE INTO usuarios
  (Nombre, Sexo, Edad, Carrera, Turno, Cuatrimestre, Grupo,
   Num_Tel, Correo, Contraseña, Rol)
VALUES
  ('Psic. Fanny Chimal', 'Femenino', 32, NULL, NULL, NULL, NULL,
   '4771000001', 'admin@ceps.mx',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
   'admin');

-- ── 2. ALUMNOS DE PRUEBA ──
INSERT INTO usuarios
  (Nombre, Sexo, Edad, Carrera, Turno, Cuatrimestre, Grupo,
   Num_Tel, Correo, Contraseña, Rol, Fecha_Registro)
VALUES
  ('Ana Sofía Morales García',  'Femenino',  20, 'ISC',  'Matutino',  3, '3A', '4771001001', 'ana.morales@utn.edu.mx',   '123456', 'usuario', '2026-01-15'),
  ('Carlos Iván Ruiz Pérez',    'Masculino', 22, 'LAE',  'Vespertino',5, '5B', '4771001002', 'carlos.ruiz@utn.edu.mx',   '123456', 'usuario', '2026-01-18'),
  ('Laura Valentina Vega Torres','Femenino', 19, 'ENF',  'Matutino',  2, '2C', '4771001003', 'laura.vega@utn.edu.mx',    '123456', 'usuario', '2026-01-20'),
  ('José Manuel Hernández Luna', 'Masculino',21, 'GAS',  'Vespertino',1, '1D', '4771001004', 'jose.hernandez@utn.edu.mx','123456', 'usuario', '2026-02-03'),
  ('Patricia Elena Soto Reyes',  'Femenino', 23, 'ISC',  'Matutino',  6, '6A', '4771001005', 'patricia.soto@utn.edu.mx', '123456', 'usuario', '2026-01-10'),
  ('Miguel Ángel Torres Díaz',   'Masculino',20, 'LAE',  'Matutino',  2, '2B', '4771001006', 'miguel.torres@utn.edu.mx', '123456', 'usuario', '2026-02-10'),
  ('Daniela Fernández Ramos',    'Femenino', 18, 'DES',  'Vespertino',1, '1A', '4771001007', 'daniela.fernandez@utn.edu.mx','123456','usuario','2026-02-12'),
  ('Roberto González Martínez',  'Masculino',24, 'ISC',  'Vespertino',7, '7B', '4771001008', 'roberto.gonzalez@utn.edu.mx','123456','usuario','2025-09-05'),
  ('Alejandra Ramírez Castro',   'Femenino', 21, 'ENF',  'Matutino',  4, '4A', '4771001009', 'alejandra.ramirez@utn.edu.mx','123456','usuario','2025-09-08'),
  ('Luis Eduardo Mendoza Silva',  'Masculino',19, 'GAS', 'Matutino',  2, '2D', '4771001010', 'luis.mendoza@utn.edu.mx',  '123456', 'usuario', '2026-03-01'),
  ('Gabriela Flores Jiménez',    'Femenino', 22, 'LAE',  'Vespertino',5, '5A', '4771001011', 'gabriela.flores@utn.edu.mx','123456','usuario','2026-03-05'),
  ('Eduardo Vargas López',       'Masculino',20, 'ISC',  'Matutino',  3, '3C', '4771001012', 'eduardo.vargas@utn.edu.mx','123456', 'usuario', '2026-03-08');

-- ── 3. EXPEDIENTES (uno por alumno) ──
INSERT INTO expedientes (idUsuario, Estado_Civil, Ocupacion, Num_Integrantes_Familia, Fecha_Creacion)
SELECT u.idUsuario_a,
  CASE WHEN u.Edad < 20 THEN 'Soltero' ELSE 'Soltero' END,
  'Estudiante',
  FLOOR(3 + RAND() * 4),
  u.Fecha_Registro
FROM usuarios u WHERE u.Rol = 'usuario'
ON DUPLICATE KEY UPDATE Ocupacion = VALUES(Ocupacion);

-- ── 4. PERÍODO ESCOLAR ──
INSERT INTO periodo_escolar (periodo, FechaInicio, FechaFin, año)
VALUES
  ('Enero - Abril',       '2026-01-13', '2026-04-30', 2026),
  ('Mayo - Agosto',       '2026-05-04', '2026-08-21', 2026),
  ('Septiembre - Diciembre','2025-09-08','2025-12-19',2025);

-- ── 5. HORARIOS DEL CALENDARIO (Cuatrimestre Ene-Abr 2026) ──
-- Lunes a Viernes, 8am a 6pm, horarios disponibles
INSERT INTO calendario (idCuatri, fecha, hora, disponible) VALUES
  (1, '2026-03-17', '08:00:00', 1),
  (1, '2026-03-17', '09:00:00', 0),
  (1, '2026-03-17', '10:00:00', 0),
  (1, '2026-03-17', '11:00:00', 1),
  (1, '2026-03-17', '12:00:00', 1),
  (1, '2026-03-17', '14:00:00', 1),
  (1, '2026-03-17', '15:00:00', 0),
  (1, '2026-03-17', '16:00:00', 1),
  (1, '2026-03-18', '08:00:00', 1),
  (1, '2026-03-18', '09:00:00', 1),
  (1, '2026-03-18', '10:00:00', 0),
  (1, '2026-03-18', '11:00:00', 1),
  (1, '2026-03-18', '14:00:00', 1),
  (1, '2026-03-18', '15:00:00', 1),
  (1, '2026-03-19', '08:00:00', 0),
  (1, '2026-03-19', '09:00:00', 0),
  (1, '2026-03-19', '10:00:00', 1),
  (1, '2026-03-19', '11:00:00', 1),
  (1, '2026-03-19', '13:00:00', 1),
  (1, '2026-03-19', '14:00:00', 1),
  (1, '2026-03-19', '15:00:00', 0),
  (1, '2026-03-19', '16:00:00', 1),
  (1, '2026-03-19', '17:00:00', 1),
  (1, '2026-03-20', '08:00:00', 1),
  (1, '2026-03-20', '09:00:00', 1),
  (1, '2026-03-20', '10:00:00', 1),
  (1, '2026-03-20', '11:00:00', 0),
  (1, '2026-03-20', '14:00:00', 1),
  (1, '2026-03-20', '15:00:00', 1),
  (1, '2026-03-21', '09:00:00', 1),
  (1, '2026-03-21', '10:00:00', 1),
  (1, '2026-03-21', '11:00:00', 1),
  (1, '2026-03-21', '14:00:00', 0),
  (1, '2026-03-21', '15:00:00', 1);

-- ── 6. CITAS ──
-- Obtener los IDs de los alumnos insertados para referenciarlos
-- (Usamos subqueries porque los IDs son auto-increment)
INSERT INTO citas (idUsuario, idHorario, Fecha, Hora, Estado)
SELECT u.idUsuario_a, c.idHorario, c.fecha, c.hora, est
FROM (
  SELECT 'ana.morales@utn.edu.mx'     AS correo, '2026-03-17' AS f, '09:00:00' AS h, 'Completada' AS est
  UNION SELECT 'carlos.ruiz@utn.edu.mx',     '2026-03-17', '10:00:00', 'Completada'
  UNION SELECT 'laura.vega@utn.edu.mx',      '2026-03-17', '15:00:00', 'Completada'
  UNION SELECT 'ana.morales@utn.edu.mx',     '2026-03-18', '10:00:00', 'Completada'
  UNION SELECT 'patricia.soto@utn.edu.mx',   '2026-03-18', '11:00:00', 'Completada'
  UNION SELECT 'jose.hernandez@utn.edu.mx',  '2026-03-19', '08:00:00', 'Completada'
  UNION SELECT 'alejandra.ramirez@utn.edu.mx','2026-03-19','09:00:00', 'Completada'
  UNION SELECT 'ana.morales@utn.edu.mx',     '2026-03-20', '11:00:00', 'Programada'
  UNION SELECT 'carlos.ruiz@utn.edu.mx',     '2026-03-20', '14:00:00', 'Programada'
  UNION SELECT 'laura.vega@utn.edu.mx',      '2026-03-21', '14:00:00', 'Confirmada'
  UNION SELECT 'gabriela.flores@utn.edu.mx', '2026-03-21', '09:00:00', 'Programada'
) AS t
JOIN usuarios u ON u.Correo = t.correo
JOIN calendario c ON c.fecha = t.f AND c.hora = t.h;

-- ── 7. SESIONES (historial de atenciones) ──
INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 1, '2026-01-20', 'Asistió',
  'Ansiedad generalizada (F41.1)',
  'Primera sesión. Se aplica GAD-7, puntaje: 14. Se inicia TCC. Tarea: registro de pensamientos.'
FROM usuarios u WHERE u.Correo = 'ana.morales@utn.edu.mx';

INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 2, '2026-01-27', 'Asistió',
  'Ansiedad generalizada (F41.1)',
  'Revisión de registros. Mejora leve. Se trabaja reestructuración cognitiva.'
FROM usuarios u WHERE u.Correo = 'ana.morales@utn.edu.mx';

INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 3, '2026-02-03', 'Asistió',
  'Ansiedad generalizada (F41.1)',
  'GAD-7 puntaje: 10 (mejoría). Introduce técnica de respiración diafragmática.'
FROM usuarios u WHERE u.Correo = 'ana.morales@utn.edu.mx';

INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 4, '2026-02-17', 'Faltó',
  'Ansiedad generalizada (F41.1)', 'Inasistencia sin aviso previo.'
FROM usuarios u WHERE u.Correo = 'ana.morales@utn.edu.mx';

INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 5, '2026-02-24', 'Asistió',
  'Ansiedad generalizada (F41.1)',
  'Regresa a sesión. Explica motivo de falta. Se refuerza compromiso al proceso.'
FROM usuarios u WHERE u.Correo = 'ana.morales@utn.edu.mx';

INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 6, '2026-03-03', 'Asistió',
  'Ansiedad generalizada (F41.1)',
  'GAD-7: 7. Avance significativo. Se introduce exposición gradual.'
FROM usuarios u WHERE u.Correo = 'ana.morales@utn.edu.mx';

-- Sesiones de Carlos
INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 1, '2026-01-22', 'Asistió',
  'Episodio depresivo leve (F32.0)',
  'Primera sesión. PHQ-9: 11. Dificultades de concentración y baja motivación escolar.'
FROM usuarios u WHERE u.Correo = 'carlos.ruiz@utn.edu.mx';

INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 2, '2026-02-05', 'Asistió',
  'Episodio depresivo leve (F32.0)',
  'Revisión activación conductual. Implementa rutina de ejercicio. PHQ-9: 9.'
FROM usuarios u WHERE u.Correo = 'carlos.ruiz@utn.edu.mx';

INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 3, '2026-02-19', 'Reprogramada',
  'Episodio depresivo leve (F32.0)', 'Reprogramada a petición del alumno por examen.'
FROM usuarios u WHERE u.Correo = 'carlos.ruiz@utn.edu.mx';

INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 4, '2026-03-05', 'Asistió',
  'Episodio depresivo leve (F32.0)',
  'PHQ-9: 6. Mejora notable. Trabaja habilidades sociales y comunicación.'
FROM usuarios u WHERE u.Correo = 'carlos.ruiz@utn.edu.mx';

-- Sesiones de Laura
INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 1, '2026-01-28', 'Asistió',
  'Estrés académico (Z73.3)',
  'Primera sesión. Carga académica elevada. Dificultades para organizar tiempo.'
FROM usuarios u WHERE u.Correo = 'laura.vega@utn.edu.mx';

INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 2, '2026-02-11', 'Asistió',
  'Estrés académico (Z73.3)',
  'Se trabaja agenda y técnicas de estudio. Introduce mindfulness.'
FROM usuarios u WHERE u.Correo = 'laura.vega@utn.edu.mx';

INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 3, '2026-02-25', 'Asistió',
  'Estrés académico (Z73.3)',
  'Reporta mejor organización. Se introduce manejo de emociones bajo presión.'
FROM usuarios u WHERE u.Correo = 'laura.vega@utn.edu.mx';

INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 4, '2026-03-11', 'Asistió',
  'Estrés académico (Z73.3)',
  'Buena evolución. Aprendió a pedir apoyo a compañeros. Continúa proceso.'
FROM usuarios u WHERE u.Correo = 'laura.vega@utn.edu.mx';

-- Sesiones de Patricia
INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 1, '2026-01-14', 'Asistió',
  'Trastorno adaptativo (F43.2)',
  'Primera sesión. Dificultad de adaptación a nuevo cuatrimestre y ambiente universitario.'
FROM usuarios u WHERE u.Correo = 'patricia.soto@utn.edu.mx';

INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 2, '2026-01-28', 'Asistió',
  'Trastorno adaptativo (F43.2)',
  'Explora redes de apoyo. Identifica recursos personales.'
FROM usuarios u WHERE u.Correo = 'patricia.soto@utn.edu.mx';

INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 3, '2026-02-11', 'Asistió',
  'Trastorno adaptativo (F43.2)',
  'Mejoría en relaciones sociales. Participa más en clase.'
FROM usuarios u WHERE u.Correo = 'patricia.soto@utn.edu.mx';

INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 4, '2026-02-25', 'Faltó',
  'Trastorno adaptativo (F43.2)', 'No se presentó, sin aviso.'
FROM usuarios u WHERE u.Correo = 'patricia.soto@utn.edu.mx';

INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 5, '2026-03-10', 'Asistió',
  'Trastorno adaptativo (F43.2)',
  'Retoma proceso. Estable. Se proyecta cierre en 2 sesiones más.'
FROM usuarios u WHERE u.Correo = 'patricia.soto@utn.edu.mx';

-- Sesión de José (nuevo)
INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 1, '2026-02-06', 'Asistió',
  'Orientación y apoyo (Z71.1)',
  'Primera sesión. Dificultades en relaciones familiares y bajo rendimiento escolar.'
FROM usuarios u WHERE u.Correo = 'jose.hernandez@utn.edu.mx';

-- Sesiones de Alejandra
INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 1, '2025-09-10', 'Asistió',
  'Trastorno de ansiedad (F41.9)',
  'Primera sesión cuatrimestre sep-dic. Ansiedad ante exposiciones orales.'
FROM usuarios u WHERE u.Correo = 'alejandra.ramirez@utn.edu.mx';

INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 2, '2025-09-24', 'Asistió',
  'Trastorno de ansiedad (F41.9)',
  'Técnicas de relajación. Exposición gradual a hablar en público.'
FROM usuarios u WHERE u.Correo = 'alejandra.ramirez@utn.edu.mx';

INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 3, '2026-01-22', 'Asistió',
  'Trastorno de ansiedad (F41.9)',
  'Inicio nuevo cuatrimestre. Continúa proceso. Reporta mejora en exposiciones.'
FROM usuarios u WHERE u.Correo = 'alejandra.ramirez@utn.edu.mx';

INSERT INTO sesiones (idUsuario, idCita, Numero_Sesion, Fecha, Estado, Diagnostico, Notas)
SELECT u.idUsuario_a, NULL, 4, '2026-02-19', 'Asistió',
  'Trastorno de ansiedad (F41.9)',
  'Logros académicos. Se refuerzan estrategias adquiridas.'
FROM usuarios u WHERE u.Correo = 'alejandra.ramirez@utn.edu.mx';

-- ── 8. CANALIZACIONES ──
INSERT INTO canalizados (idUsuario, Institucion_Destino, Motivo, Fecha)
SELECT u.idUsuario_a,
  'Centro de Integración Juvenil (CIJ)',
  'Consumo experimental de sustancias detectado durante evaluación psicológica. Se requiere valoración especializada.',
  '2026-02-20'
FROM usuarios u WHERE u.Correo = 'miguel.torres@utn.edu.mx';

INSERT INTO canalizados (idUsuario, Institucion_Destino, Motivo, Fecha)
SELECT u.idUsuario_a,
  'Instituto de la Mujer',
  'Situación de violencia en relación de pareja identificada. Requiere acompañamiento legal y psicosocial.',
  '2026-03-05'
FROM usuarios u WHERE u.Correo = 'daniela.fernandez@utn.edu.mx';

-- ── 9. DEPARTAMENTOS ──
INSERT INTO departamento (Cargo, Tipo, Ubicacion, Descripcion) VALUES
  ('Psicóloga CEPS',       'Educativo',     'Edificio D, Planta Baja', 'Atención psicológica a estudiantes'),
  ('Coordinador ISC',      'Educativo',     'Edificio A, Piso 1',     'Coordinación carrera ISC'),
  ('Coordinador LAE',      'Educativo',     'Edificio B, Planta Baja','Coordinación carrera LAE'),
  ('Directora Académica',  'Administrativo','Rectoría',               'Dirección académica institucional'),
  ('Tutor Grupo',          'Educativo',     'Aula asignada',          'Seguimiento tutorial de grupo');

-- ── 10. MAESTROS / TUTORES ──
INSERT INTO maestros (Nombre, Sexo, Edad, idCargo, Grupo_Tutor, Correo, Telefono) VALUES
  ('Ing. Roberto García Mendoza',  'Masculino', 38, 2, '3A', 'r.garcia@utn.edu.mx',  '4771002001'),
  ('Lic. Sandra Ríos Gutiérrez',   'Femenino',  45, 4, NULL, 's.rios@utn.edu.mx',    '4771002002'),
  ('Ing. Pedro López Vázquez',     'Masculino', 35, 3, '5B', 'p.lopez@utn.edu.mx',   '4771002003'),
  ('Lic. María Elena Cruz Flores', 'Femenino',  42, 5, '2C', 'm.cruz@utn.edu.mx',    '4771002004');

-- ── 11. VINCULACIONES (maestro-alumno) ──
INSERT INTO vinculacion (idUsuario_m, idUsuario_a, motivo, fecha)
SELECT m.idUsuario_m, u.idUsuario_a,
  'Alumno reportado por bajo rendimiento académico y ausentismo',
  '2026-02-01'
FROM maestros m, usuarios u
WHERE m.Correo = 'r.garcia@utn.edu.mx'
  AND u.Correo  = 'ana.morales@utn.edu.mx';

INSERT INTO vinculacion (idUsuario_m, idUsuario_a, motivo, fecha)
SELECT m.idUsuario_m, u.idUsuario_a,
  'Canalización por tutor — detecta signos de estrés elevado',
  '2026-02-10'
FROM maestros m, usuarios u
WHERE m.Correo = 'p.lopez@utn.edu.mx'
  AND u.Correo  = 'carlos.ruiz@utn.edu.mx';

INSERT INTO vinculacion (idUsuario_m, idUsuario_a, motivo, fecha)
SELECT m.idUsuario_m, u.idUsuario_a,
  'Alumno referido por maestro tutor — dificultades de adaptación',
  '2026-01-22'
FROM maestros m, usuarios u
WHERE m.Correo = 'm.cruz@utn.edu.mx'
  AND u.Correo  = 'laura.vega@utn.edu.mx';

-- ── VERIFICAR RESULTADOS ──
SELECT 'usuarios' AS tabla, COUNT(*) AS registros FROM usuarios
UNION SELECT 'expedientes', COUNT(*) FROM expedientes
UNION SELECT 'sesiones',    COUNT(*) FROM sesiones
UNION SELECT 'citas',       COUNT(*) FROM citas
UNION SELECT 'calendario',  COUNT(*) FROM calendario
UNION SELECT 'canalizados', COUNT(*) FROM canalizados
UNION SELECT 'maestros',    COUNT(*) FROM maestros
UNION SELECT 'departamento',COUNT(*) FROM departamento
UNION SELECT 'vinculacion', COUNT(*) FROM vinculacion
UNION SELECT 'periodo_escolar',COUNT(*) FROM periodo_escolar;
