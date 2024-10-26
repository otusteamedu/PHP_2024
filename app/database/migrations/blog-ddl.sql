-- Cleanup
DROP TYPE IF EXISTS blog_post_status CASCADE;
DROP TABLE IF EXISTS blog_posts CASCADE;
DROP SEQUENCE IF EXISTS blog_posts_id;
DROP TABLE IF EXISTS blog_post_comments CASCADE;
DROP SEQUENCE IF EXISTS blog_post_comments_id;

-- Create "blog_posts" table
CREATE TYPE blog_post_status AS ENUM ('draft', 'published', 'archived');

CREATE SEQUENCE blog_posts_id;

CREATE TABLE blog_posts
(
    id      BIGINT       NOT NULL DEFAULT nextval('blog_posts_id'),
    status  blog_post_status,
    title   VARCHAR(255) NOT NULL,
    content VARCHAR(255) NOT NULL,

    PRIMARY KEY (id)
);

-- Create "blog_post_comments" table
CREATE SEQUENCE blog_post_comments_id;

CREATE TABLE blog_post_comments
(
    id      BIGINT       NOT NULL DEFAULT nextval('blog_post_comments_id'),
    post_id BIGINT       NOT NULL,
    content VARCHAR(255) NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (post_id) REFERENCES blog_posts (id)
);
