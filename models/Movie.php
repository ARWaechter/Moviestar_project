<?php

    class Movie
    {

        public $id;
        public $title;
        public $description;
        public $image;
        public $trailer;
        public $category;
        public $length;
        public $user_id;

        public function imageGenereteName()
        {
            return bin2hex(random_bytes(60) . ".jpg");
        }

    }

    interface MovieDAOInterface
    {

        public function buildMovie($data);
        public function findAll();
        public function getLastestMovies();
        public function getMoviesByCategory($category);
        public function getMoviesByUserId($id);
        public function findbyId($id);
        public function findByTitle($title);
        public function create(Movie $movie);
        public function update(Movie $movie);
        public function destroy($id);

    }
?>