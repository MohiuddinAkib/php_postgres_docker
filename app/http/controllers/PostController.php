<?php

namespace App\http\controllers;

use App\models\Post;

class PostController extends Controller
{
    private $model;

    public function __construct(Post $post)
    {
        $this->model = $post;
    }

    public function index()
    {
        $result = $this->model->getPosts();
        $num = $this->model->rowCount();

        $this->send_json_collection($num, $result, "No posts found");
    }

    public function show(int $id)
    {
        $result = $this->model->getPost($id);
        $num = $this->model->rowCount();

        $this->send_json_resource($num, $result, "No post found");
    }

    public function store()
    {
        $data = json_decode(file_get_contents("php://input"));

        $this->model->category_id = $data->category_id;
        $this->model->title = $data->title;
        $this->model->body = $data->body;
        $this->model->author_id = $data->author_id;

        if ($this->model->createPost()) {
            $this->jsonify([
                'msg' => 'Post was created succesfully',
            ], 201);
        } else {
            $this->jsonify([
                'msg' => 'Post was not created',
            ], 400);
        }
    }
}