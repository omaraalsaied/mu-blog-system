<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Repositories\CommentRepositoryInterface;
use App\Repositories\CommentRepositroy;
use App\Repositories\PostImageRepository;
use App\Repositories\PostImageRepositoryInterface;
use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use App\Services\CommentService;
use App\Services\PostImageService;
use App\Services\PostService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(PostService::class, function ($app) {
            return new PostService($app->make(PostRepositoryInterface::class));
        });

        $this->app->bind(PostImageRepositoryInterface::class, PostImageRepository::class);
        $this->app->bind(PostImageService::class, function ($app) {
            return new PostImageService($app->make(PostImageRepositoryInterface::class));
        });

        $this->app->bind(CommentRepositoryInterface::class, CommentRepositroy::class);
        $this->app->bind(CommentService::class, function ($app){
            return new CommentService($app->make(CommentRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate::define('update-post', function (User $user, Post $post) {
        //     return $user->id === $post->user_id;
        // });
    }
}
