# php_postgres_docker
Simple rest api design with modern php development workflow

# Database table
posts:
  id: primary key, type: serial
  category_id: constraint: foreign_key (reference: categories, on: id), integer
  title: type: character varying, length: 255
  body: text
  author_id: type: integer, constraint: foreign_key (reference: authors, on: id)
  created_at: type: date, default: CURRENT_TIME
 
categories:
  id: primary key, type: serial
  name: type: character varying, length: 255
  created_at: type: date, default: CURRENT_TIME

authors:
  id: primary key, type: serial
  name: type: character varying, length: 255
  created_at: type: date, default: CURRENT_TIME
