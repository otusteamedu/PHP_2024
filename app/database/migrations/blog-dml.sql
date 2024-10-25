-- Fill "blog_posts" table
INSERT INTO blog_posts
    (id, title, content, status)
VALUES (1, '#1 Post', 'Some content...', 'published'),
       (2, '#2 Post', 'Some content...', 'archived'),
       (3, '#2 Post', 'Some content...', 'draft')
;

-- Fill "blog_post_comments" table
INSERT INTO blog_post_comments
    (id, post_id, content)
VALUES (1, 1, 'Some content...'),
       (2, 1, 'Some content...'),
       (3, 1, 'Some content...'),
       (4, 2, 'Some content...'),
       (5, 2, 'Some content...'),
       (6, 2, 'Some content...')
;
