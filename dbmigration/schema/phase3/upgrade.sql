ALTER TABLE article CHANGE pubdate datepublished TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE article ADD author VARCHAR( 70 ) NOT NULL AFTER content;