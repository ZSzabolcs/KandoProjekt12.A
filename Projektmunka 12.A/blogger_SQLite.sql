
CREATE TABLE IF NOT EXISTS "user" (
"username" VARCHAR(30) PRIMARY KEY NOT NULL,
"email" VARCHAR(40) NOT NULL,
"password" VARCHAR(30) NOT NULL
);



CREATE TABLE IF NOT EXISTS  "blog" (
"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
"username" VARCHAR(30) NOT NULL , 
"blog_title" VARCHAR(50) NOT NULL UNIQUE,
"blog_content" TEXT NOT NULL,
"blog_made_date" DATE NOT NULL,
"shared_blog_number" INTEGER DEFAULT 0,
CONSTRAINT FK_blog_user FOREIGN KEY (username)
REFERENCES user(username)
);



CREATE TABLE IF NOT EXISTS  "comment" (
"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
"username" VARCHAR(30) NOT NULL,
"blog_title" VARCHAR(50) NOT NULL,
"comment_content" TEXT NOT NULL, 
"comment_date" DATE NOT NULL, 
"like_number" INTEGER DEFAULT 0, 
"dislike_number" INTEGER DEFAULT 0,
CONSTRAINT FK_comment_user FOREIGN KEY (username)
REFERENCES user(username),
CONSTRAINT FK_comment_blog_title FOREIGN KEY (blog_title)
REFERENCES blog(blog_title)
);



/*Chat előretervezett felépítése*/
/*
CREATE TABLE IF NOT EXISTS `blogger`.`group_name` (
id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
username VARCHAR(30) NOT NULL,
message_text TEXT NOT NULL,
message_date TIMESTAMP NOT NULL,
CONSTRAINT FK_group_member FOREIGN KEY (username)
REFERENCES group_member(username)
)
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `blogger`.`group_member` (
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(30) NOT NULL UNIQUE,
CONSTRAINT FK_member_username FOREIGN KEY (username)
REFERENCES user(username)
)
ENGINE = InnoDB;
*/



