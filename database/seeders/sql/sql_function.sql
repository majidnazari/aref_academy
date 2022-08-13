
       DROP FUNCTION IF EXISTS getCoursePresents;
        CREATE  FUNCTION getCoursePresents(studentId INT, courseId INT) RETURNS int
            NO SQL
        BEGIN
            DECLARE tmp INT;
          DECLARE ou INT DEFAULT 0;
             SELECT count(*) tead into tmp FROM absence_presences p1 left join course_sessions p2 on (p1.course_session_id=p2.id) where p1.status='present' AND student_id = studentId AND p2.course_id=courseId GROUP by p2.course_id;
        IF tmp>0 THEN 
          SET ou = tmp;
        END IF;
        return ou;
        END
       