CREATE TABLE "user" (
"username" VARCHAR(30) PRIMARY KEY NOT NULL,
"email" VARCHAR(40) NOT NULL,
"password" VARCHAR(30) NOT NULL
);

CREATE TABLE "blog" (
"blog_id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
"blog_username" VARCHAR(30) NOT NULL, 
"blog_content" TEXT NOT NULL,
"blog_made_date" DATE NOT NULL,
"shared_blog_number" INTEGER DEFAULT 0,
CONSTRAINT FK_blog_user FOREIGN KEY (blog_username)
REFERENCES user(username)
);

CREATE TABLE "comment" (
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

INSERT INTO user ("username", "email", "password") VALUES ('az3', 'asdas@gmail.jk', '$2y$10$Wy/J.RAI.Atmn16qbQvate/MNvEynIBOuKUECpR0ApV02Fby3JD/K');

INSERT INTO blog ("blog_username", "blog_content", "blog_made_date") VALUES ('az3', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum dolorum porro obcaecati non sed recusandae laborum tenetur reiciendis, minima assumenda est id unde ipsam consequatur? Cumque voluptas eius delectus voluptatum!
                        Possimus nihil tempora, magnam nulla numquam veritatis, illo, enim fugiat accusamus consequatur vitae dolor? Eaque laboriosam possimus optio est recusandae molestiae molestias, in tempore ratione quidem totam ea dicta voluptatum?Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eaque ipsum consequuntur tempore aliquam harum! Accusamus reprehenderit dolore nostrum fuga porro expedita temporibus! Cum, modi itaque! Cum similique possimus aliquid porro.
                        Nostrum nemo, officia magnam voluptatem quisquam pariatur consectetur culpa inventore, quasi, molestias aspernatur id corrupti exercitationem illo deleniti ratione placeat numquam tempora doloremque corporis. Ea voluptas dolore vero eius adipisci!
                        A, quasi qui excepturi maxime velit enim debitis id unde mollitia quam eveniet? Praesentium magni necessitatibus commodi, at corporis, facere tempora officia voluptatum debitis sunt vitae non illum! Aliquid, odio!
                        Recusandae dolorem necessitatibus ratione. Quibusdam facere assumenda aut, ut, alias culpa dolorum sunt harum unde natus aperiam magnam! Debitis non voluptatum ipsam inventore eum, cum voluptas pariatur ea voluptates. Porro?
                        Repellat incidunt ab nam quidem quam ipsum numquam placeat pariatur obcaecati ipsam? Temporibus fugiat ipsa minima, molestias dolorum neque? Ipsa neque dolores ad explicabo vitae! At esse consequuntur ex obcaecati.', '2024-12-05');

