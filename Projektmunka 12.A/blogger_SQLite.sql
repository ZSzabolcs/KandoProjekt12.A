
CREATE TABLE IF NOT EXISTS "user" (
"username" VARCHAR(30) PRIMARY KEY NOT NULL,
"email" VARCHAR(40) NOT NULL,
"password" VARCHAR(30) NOT NULL
);



CREATE TABLE IF NOT EXISTS  "blog" (
"blog_id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
"blog_username" VARCHAR(30) NOT NULL , 
"blog_title" VARCHAR(50) NOT NULL UNIQUE,
"blog_content" TEXT NOT NULL,
"blog_made_date" DATE NOT NULL,
"shared_blog_number" INTEGER DEFAULT 0,
CONSTRAINT FK_blog_user FOREIGN KEY (blog_username)
REFERENCES user(username)
);



CREATE TABLE IF NOT EXISTS  "comment" (
"comment_id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
"comment_username" VARCHAR(30) NOT NULL,
"target_title" VARCHAR(50) NOT NULL,
"comment_content" TEXT NOT NULL, 
"comment_date" DATE NOT NULL, 
"like_number" INTEGER DEFAULT 0, 
"dislike_number" INTEGER DEFAULT 0,
CONSTRAINT FK_comment_user FOREIGN KEY (comment_username)
REFERENCES user(username),
CONSTRAINT FK_comment_blog_title FOREIGN KEY (target_title)
REFERENCES blog(blog_title)
);




