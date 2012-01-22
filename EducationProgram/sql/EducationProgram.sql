-- MySQL version of the database schema for the Education Program extension.
-- Licence: GNU GPL v3+
-- Author: Jeroen De Dauw < jeroendedauw@gmail.com >

-- Organizations, ie universities
CREATE TABLE IF NOT EXISTS /*_*/ep_orgs (
  org_id                     INT unsigned        NOT NULL auto_increment PRIMARY KEY,

  org_name                   VARCHAR(255)        NOT NULL, -- Name of the organization
  org_city                   VARCHAR(255)        NOT NULL, -- Name of the city where the org is located
  org_country                VARCHAR(255)        NOT NULL, -- Name of the country where the org is located

  org_active                 TINYINT unsigned    NOT NULL, -- If the org has any active courses
  org_courses                SMALLINT unsigned   NOT NULL, -- Amount of courses
  org_mcs                    SMALLINT unsigned   NOT NULL, -- Amount of master courses
  org_students               INT unsigned        NOT NULL -- Amount of students
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/ep_org_name ON /*_*/ep_orgs (org_name);
CREATE INDEX /*i*/ep_org_mcs ON /*_*/ep_orgs (org_mcs);
CREATE INDEX /*i*/ep_org_courses ON /*_*/ep_orgs (org_courses);
CREATE INDEX /*i*/ep_org_students ON /*_*/ep_orgs (org_students);
CREATE INDEX /*i*/ep_org_active ON /*_*/ep_orgs (org_active);



-- Master courses. These describe a specific course, time-independent.
CREATE TABLE IF NOT EXISTS /*_*/ep_mcs (
  mc_id                      INT unsigned        NOT NULL auto_increment PRIMARY KEY,

  mc_org_id                  INT unsigned        NOT NULL, -- Foreign key on ep_orgs.org_id
  mc_name                    VARCHAR(255)        NOT NULL, -- Name of the course
  mc_description             TEXT                NOT NULL, -- Description of the course
  mc_lang                    VARCHAR(10)         NOT NULL, -- Language (code)
  mc_instructors             BLOB                NOT NULL, -- List of associated instructors

  mc_active                  TINYINT unsigned    NOT NULL, -- If the master course has any active courses
  mc_students                SMALLINT unsigned   NOT NULL -- Amount of students
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/ep_mc_org_id ON /*_*/ep_mcs (mc_org_id);
CREATE UNIQUE INDEX /*i*/ep_mc_name ON /*_*/ep_mcs (mc_name);
CREATE INDEX /*i*/ep_mc_lang ON /*_*/ep_mcs (mc_lang);
CREATE INDEX /*i*/ep_mc_students ON /*_*/ep_mcs (mc_students);
CREATE INDEX /*i*/ep_mc_active ON /*_*/ep_mcs (mc_active);



-- Courses. These are "instances" of a master course in a certain period.
CREATE TABLE IF NOT EXISTS /*_*/ep_courses (
  course_id                  INT unsigned        NOT NULL auto_increment PRIMARY KEY,

  course_mc_id               INT unsigned        NOT NULL, -- Foreign key on ep_mcs.mc_id
  course_name                VARCHAR(255)        NOT NULL, -- Name of the course
  course_org_id              INT unsigned        NOT NULL, -- Foreign key on ep_orgs.org_id. Helper field, not strictly needed.
  course_year                SMALLINT unsigned   NOT NULL, -- Year in which the course takes place
  course_start               varbinary(14)       NOT NULL, -- Start time of the course
  course_end                 varbinary(14)       NOT NULL, -- End time of the course
  course_description         TEXT                NOT NULL, -- Description of the course
  course_online_ambs         BLOB                NOT NULL, -- List of associated online ambassadors
  course_campus_ambs         BLOB                NOT NULL, -- List of associated campus ambassadors
  course_token               VARCHAR(255)        NOT NULL, -- Token needed to enroll
  
  course_students            SMALLINT unsigned   NOT NULL -- Amount of students
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/ep_course_year ON /*_*/ep_courses (course_year);
CREATE INDEX /*i*/ep_course_start ON /*_*/ep_courses (course_start);
CREATE INDEX /*i*/ep_course_end ON /*_*/ep_courses (course_end);
CREATE INDEX /*i*/ep_trem_period ON /*_*/ep_courses (course_org_id, course_start, course_end);
CREATE INDEX /*i*/ep_course_students ON /*_*/ep_courses (course_students);



-- Students. In essence this is an extension to the user table.
CREATE TABLE IF NOT EXISTS /*_*/ep_students (
  student_id                 INT unsigned        NOT NULL auto_increment PRIMARY KEY,

  student_user_id            INT unsigned        NOT NULL, -- Foreign key on user.user_id
  student_first_enroll       varbinary(14)       NOT NULL, -- Time of first enrollment

  student_last_active        varbinary(14)       NOT NULL, -- Time of last activity
  student_active_enroll      TINYINT unsigned    NOT NULL -- If the student is enrolled in any active courses
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/ep_students_user_id ON /*_*/ep_students (student_user_id);
CREATE INDEX /*i*/ep_students_first_enroll ON /*_*/ep_students (student_first_enroll);
CREATE INDEX /*i*/ep_students_last_active ON /*_*/ep_students (student_last_active);
CREATE INDEX /*i*/ep_students_active_enroll ON /*_*/ep_students (student_active_enroll);

-- Links the students with their courses.
CREATE TABLE IF NOT EXISTS /*_*/ep_students_per_course (
  spc_student_id             INT unsigned        NOT NULL, -- Foreign key on ep_students.student_id
  spc_course_id              INT unsigned        NOT NULL -- Foreign key on ep_courses.course_id
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/ep_students_per_course ON /*_*/ep_students_per_course (spc_student_id, spc_course_id);



-- Instructors. In essence this is an extension to the user table.
CREATE TABLE IF NOT EXISTS /*_*/ep_instructors (
  instructor_id              INT unsigned        NOT NULL auto_increment PRIMARY KEY,
  instructor_user_id         INT unsigned        NOT NULL -- Foreign key on user.user_id
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/ep_instructors_user_id ON /*_*/ep_instructors (instructor_user_id);



-- Campus ambassadors. In essence this is an extension to the user table.
CREATE TABLE IF NOT EXISTS /*_*/ep_cas (
  ca_id                      INT unsigned        NOT NULL auto_increment PRIMARY KEY,
  ca_user_id                 INT unsigned        NOT NULL -- Foreign key on user.user_id
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/ep_cas_user_id ON /*_*/ep_cas (ca_user_id);

-- Links the campus ambassadors with all their orgs.
CREATE TABLE IF NOT EXISTS /*_*/ep_cas_per_org (
  cpo_ca_id                  INT unsigned        NOT NULL, -- Foreign key on ep_cas.ca_id
  cpo_org_id                 INT unsigned        NOT NULL -- Foreign key on ep_orgs.org_id
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/ep_cas_per_org ON /*_*/ep_cas_per_org (cpo_ca_id, cpo_org_id);



-- Online ambassadors. In essence this is an extension to the user table.
CREATE TABLE IF NOT EXISTS /*_*/ep_oas (
  oa_id                      INT unsigned        NOT NULL auto_increment PRIMARY KEY,
  oa_user_id                 INT unsigned        NOT NULL -- Foreign key on user.user_id
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/ep_oas_user_id ON /*_*/ep_oas (oa_user_id);



-- Revision table, holding blobs of various types of objects, such as orgs or students.
-- This is somewhat based on the (core) revision table and is meant to serve
-- as a prototype for a more general system to store this kind of data in a versioned fashion.  
CREATE TABLE IF NOT EXISTS /*_*/ep_revisions (
  rev_id                     INT unsigned        NOT NULL auto_increment PRIMARY KEY,
  rev_type                   varbinary(32)       NOT NULL,
  rev_comment                TINYBLOB            NOT NULL,
  rev_user_id                INT unsigned        NOT NULL default 0,
  rev_user_text              varbinary(255)      NOT NULL,
  rev_time                   varbinary(14)       NOT NULL,
  rev_minor_edit             TINYINT unsigned    NOT NULL default 0,
  rev_deleted                TINYINT unsigned    NOT NULL default 0,
  rev_data                   BLOB                NOT NULL
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/ep_revision_type ON /*_*/ep_revisions (rev_type);
CREATE INDEX /*i*/ep_revision_user_id ON /*_*/ep_revisions (rev_user_id);
CREATE INDEX /*i*/ep_revision_user_text ON /*_*/ep_revisions (rev_user_text);
CREATE INDEX /*i*/ep_revision_time ON /*_*/ep_revisions (rev_time);
CREATE INDEX /*i*/ep_revision_minor_edit ON /*_*/ep_revisions (rev_minor_edit);
CREATE INDEX /*i*/ep_revision_deleted ON /*_*/ep_revisions (rev_deleted);
