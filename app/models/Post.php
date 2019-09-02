<?php

namespace App\models;

class Post extends Model
{
    // Properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    public function __construct()
    {
        parent::__construct();
    }

    // Get posts
    public function getPosts()
    {
        $query = $this->query("SELECT
                    c.name as category_name,
                    a.name as author_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author_id,
                    p.created_at
                FROM
                    (({$this->table} p
                LEFT JOIN
                    categories c
                ON
                    p.category_id = c.id)
                LEFT JOIN
                    authors a
                ON
                    p.author_id = a.id)
                ORDER BY
                    p.created_at
                DESC");

        return $query->fetchAll();
    }

    public function getPost(int $id)
    {
        $query = $this->query("SELECT
                    c.name as category_name,
                    a.name as author_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author_id,
                    p.created_at
                FROM
                    (({$this->table} p
                LEFT JOIN
                    categories c
                ON
                    p.category_id = c.id)
                LEFT JOIN
                    authors a
                ON
                    p.author_id = a.id)
                WHERE
                    p.id = :post_id
                LIMIT
                    1
                OFFSET
                    0",
            ["post_id" => $id]);

        return $query->fetchAll();
    }

    public function createPost()
    {
        return $this->query(
            "INSERT INTO
                {$this->table}
                (
                    category_id,
                    title,
                    body,
                    author_id
                )
            VALUES
                (
                    :category_id,
                    :title,
                    :body,
                    :author_id
                )",
            [
                "category_id" => $this->category_id,
                "title" => $this->title,
                "body" => $this->body,
                "author_id" => $this->author_id,
            ]);
    }
}