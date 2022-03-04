CREATE DATABASE `2025455-readme-12`
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

  USE `2025455-readme-12`;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  registration_date DATETIME,
  email VARCHAR(320) NOT NULL,
  login VARCHAR(255) NOT NULL,
  password CHAR(64) NOT NULL,
  avatar VARCHAR(255)
);

CREATE INDEX registration_date ON users(registration_date);
CREATE UNIQUE INDEX email ON users(email);
CREATE UNIQUE INDEX login ON users(login);

CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  creation_date DATETIME,
  title VARCHAR(64) NOT NULL,
  text TEXT,
  quote_author VARCHAR(64),
  img VARCHAR(255),
  video VARCHAR(255),
  link VARCHAR(255),
  view_count INT,
  user_id INT,
  content_types_id INT
);

CREATE INDEX creation_date ON posts(creation_date);
CREATE INDEX title ON posts(title);
CREATE INDEX view_count ON posts(view_count);

CREATE TABLE comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  creation_date DATETIME,
  content TEXT,
  user_id INT,
  post_id INT
);

CREATE INDEX creation_date ON comments(creation_date);

CREATE TABLE likes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  post_id INT
);

CREATE TABLE subscriptions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  author_user_id INT,
  subscribed_user_id INT
);

CREATE TABLE messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  creation_date DATETIME,
  content TEXT,
  sender_id INT,
  recipient_id INT
);

CREATE INDEX creation_date ON messages(creation_date);

CREATE TABLE hashtags (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(64)
);

CREATE UNIQUE INDEX title ON hashtags(title);

CREATE TABLE content_types (
  id INT AUTO_INCREMENT PRIMARY KEY,
  type_title CHAR(8),
  class_icon CHAR(8),
  alias VARCHAR(8)
);

CREATE INDEX type_title ON content_types(type_title);
CREATE INDEX class_icon ON content_types(class_icon);
CREATE INDEX alias ON content_types(alias);

/*связи*/

/*posts*/
ALTER TABLE posts ADD CONSTRAINT FK_users_posts FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE posts ADD CONSTRAINT FK_content_types_posts FOREIGN KEY (content_types_id) REFERENCES content_types(id);

CREATE TABLE posts_hashtags (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT,
  hashtag_id INT
);

ALTER TABLE posts_hashtags ADD CONSTRAINT FK_posts_posts_hashtags FOREIGN KEY (post_id) REFERENCES posts(id);

ALTER TABLE posts_hashtags ADD CONSTRAINT FK_hashtags_posts_hashtags FOREIGN KEY (hashtag_id) REFERENCES hashtags(id);

/*comments*/
ALTER TABLE comments ADD CONSTRAINT FK_users_comments FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE comments ADD CONSTRAINT FK_posts_comments FOREIGN KEY (post_id) REFERENCES posts(id);

/*likes*/
ALTER TABLE likes ADD CONSTRAINT FK_users_likes FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE likes ADD CONSTRAINT FK_posts_likes FOREIGN KEY (post_id) REFERENCES posts(id);

/*subscriptions*/
ALTER TABLE subscriptions ADD CONSTRAINT FK_users_subscriptions_author FOREIGN KEY (author_user_id) REFERENCES users(id);

ALTER TABLE subscriptions ADD CONSTRAINT FK_users_subscriptions_subscribed FOREIGN KEY (subscribed_user_id) REFERENCES users(id);

/*messages*/
ALTER TABLE messages ADD CONSTRAINT FK_users_messages_sender FOREIGN KEY (sender_id) REFERENCES users(id);

ALTER TABLE messages ADD CONSTRAINT FK_users_messages_recipient FOREIGN KEY (recipient_id) REFERENCES users(id);
