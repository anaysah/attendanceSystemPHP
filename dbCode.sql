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


CREATE TABLE Attendance (
  AttendanceID INT NOT NULL AUTO_INCREMENT,
  ClassID INT NOT NULL,
  Date DATE NOT NULL,
  Time TIME NOT NULL,
  PRIMARY KEY (AttendanceID),
  FOREIGN KEY (ClassID) REFERENCES Class(ClassID)
);

CREATE TABLE Absentees (
  AbsenteeID INT NOT NULL AUTO_INCREMENT,
  AttendanceID INT NOT NULL,
  StudentID INT NOT NULL,
  PRIMARY KEY (AbsenteeID),
  FOREIGN KEY (AttendanceID) REFERENCES Attendance(AttendanceID),
  FOREIGN KEY (StudentID) REFERENCES Student(StudentID)
);


CREATE TABLE OnLeave (
  LeaveID INT NOT NULL AUTO_INCREMENT,
  AttendanceID INT NOT NULL,
  StudentID INT NOT NULL,
  Reason VARCHAR(255),
  PRIMARY KEY (LeaveID),
  FOREIGN KEY (AttendanceID) REFERENCES Attendance(AttendanceID),
  FOREIGN KEY (StudentID) REFERENCES Student(StudentID)
);

ALTER TABLE `class_teacher_member`
DROP FOREIGN KEY `class_teacher_member_ibfk_1`;

ALTER TABLE `class_teacher_member`
ADD CONSTRAINT `class_teacher_member_ibfk_1` FOREIGN KEY (`class_id`)
REFERENCES `class` (`class_id`) ON DELETE CASCADE;
