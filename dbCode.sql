CREATE TABLE class (
  class_id INT NOT NULL AUTO_INCREMENT,
  class_name VARCHAR(255) NOT NULL,
  class_code VARCHAR(6) NOT NULL,
  section VARCHAR(255),
  start_date DATE NOT NULL,
  PRIMARY KEY (class_id)
);

CREATE TABLE student (
  student_id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  status ENUM('active','inactive') DEFAULT 'inactive',
  token VARCHAR(255) NOT NULL,
  PRIMARY KEY (student_id),
  UNIQUE (email)
);

CREATE TABLE class_student_member (
  member_id INT NOT NULL AUTO_INCREMENT,
  class_id INT NOT NULL,
  student_id INT NOT NULL,
  PRIMARY KEY (member_id),
  FOREIGN KEY (class_id) REFERENCES class(class_id),
  FOREIGN KEY (student_id) REFERENCES student(student_id) ON DELETE CASCADE
);

CREATE TABLE teacher (
  teacher_id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  status ENUM('active','inactive') DEFAULT 'inactive',
  token VARCHAR(255) NOT NULL,
  PRIMARY KEY (teacher_id),
  UNIQUE (email)
);

CREATE TABLE class_teacher_member (
  member_id INT NOT NULL AUTO_INCREMENT,
  class_id INT NOT NULL,
  teacher_id INT NOT NULL,
  PRIMARY KEY (member_id),
  FOREIGN KEY (class_id) REFERENCES class(class_id),
  FOREIGN KEY (teacher_id) REFERENCES teacher(teacher_id) ON DELETE CASCADE
);


CREATE TABLE attendance (
  attendance_id INT NOT NULL AUTO_INCREMENT,
  class_id INT NOT NULL,
  date DATE NOT NULL,
  time TIME NOT NULL,
  teacher_id INT NOT NULL,
  PRIMARY KEY (attendance_id),
  FOREIGN KEY (class_id) REFERENCES class(class_id)
);

CREATE TABLE absentees (
  absentee_id INT NOT NULL AUTO_INCREMENT,
  attendance_id INT NOT NULL,
  student_id INT NOT NULL,
  PRIMARY KEY (absentee_id),
  FOREIGN KEY (attendance_id) REFERENCES attendance(attendance_id),
  FOREIGN KEY (student_id) REFERENCES student(student_id)
);

CREATE TABLE on_leave (
  leave_id INT NOT NULL AUTO_INCREMENT,
  attendance_id INT NOT NULL,
  student_id INT NOT NULL,
  reason VARCHAR(255),
  PRIMARY KEY (leave_id),
  FOREIGN KEY (attendance_id) REFERENCES attendance(attendance_id),
  FOREIGN KEY (student_id) REFERENCES student(student_id)
);

-- 
ALTER TABLE `class_teacher_member`
DROP FOREIGN KEY `class_teacher_member_ibfk_1`;

ALTER TABLE `class_teacher_member`
ADD CONSTRAINT `class_teacher_member_ibfk_1` FOREIGN KEY (`class_id`)
REFERENCES `class` (`class_id`) ON DELETE CASCADE;
-- 


-- 
ALTER TABLE absentee
ADD CONSTRAINT fk_absentee_attendance
FOREIGN KEY (attendance_id)
REFERENCES attendance(attendance_id)
ON DELETE CASCADE;
-- 

-- 
ALTER TABLE Absentees ADD COLUMN reason VARCHAR(255);
-- 