<?php

namespace App\Providers;

use App\Contracts\TagsAdder;
use App\Contracts\TaskAdder;
use App\Contracts\MarkSetter;
use App\Contracts\TagPlucker;
use App\Contracts\TaskGetter;
use App\Contracts\UserGetter;
use App\Contracts\ResultAdder;
use App\Contracts\RoleRemover;
use App\Contracts\TaskDeleter;
use App\Contracts\TasksFilter;
use App\Contracts\TaskUpdater;
use App\Contracts\AnswerDeleter;
use App\Contracts\CodePublisher;
use App\Contracts\RolesAssigner;
use App\Contracts\Auth\UserLogin;
use App\Contracts\KafkaPublisher;
use App\Contracts\TaskListGetter;
use App\Contracts\Auth\UserLogout;
use App\Contracts\PasswordUpdater;
use App\Contracts\TaskAnswersList;
use App\Contracts\TaskOutputAdder;
use App\Contracts\UserTasksGetter;
use App\Services\TagsAdderService;
use App\Services\TaskAdderService;
use App\Services\MarkSetterService;
use App\Services\TagPluckerService;
use App\Services\TaskGetterService;
use App\Services\UserGetterService;
use App\Contracts\AnswerOutputAdder;
use App\Contracts\Auth\UserRegister;
use App\Services\ResultAdderService;
use App\Services\RoleRemoverService;
use App\Services\TaskDeleterService;
use App\Services\TasksFilterService;
use App\Services\TaskUpdaterService;
use App\Services\AnswerDeleterService;
use App\Services\CodePublisherService;
use App\Services\RolesAssignerService;
use App\Contracts\UserTaskAnswerGetter;
use App\Services\Auth\UserLoginService;
use App\Services\KafkaPublisherService;
use App\Services\TaskListGetterService;
use Illuminate\Support\ServiceProvider;
use App\Services\Auth\UserLogoutService;
use App\Services\PasswordUpdaterService;
use App\Services\TaskAnswersListService;
use App\Services\TaskOutputAdderService;
use App\Services\UserTasksGetterService;
use App\Contracts\InternalTokenGenerator;
use App\Services\AnswerOutputAdderService;
use App\Services\Auth\UserRegisterService;
use App\Services\UserTaskAnswerGetterService;
use App\Services\InternalTokenGeneratorService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(UserRegister::class, UserRegisterService::class);
        $this->app->bind(UserLogin::class, UserLoginService::class);
        $this->app->bind(UserLogout::class, UserLogoutService::class);
        $this->app->bind(TaskAdder::class, TaskAdderService::class);
        $this->app->bind(UserGetter::class, UserGetterService::class);
        $this->app->bind(TaskListGetter::class, TaskListGetterService::class);
        $this->app->bind(TaskGetter::class, TaskGetterService::class);
        $this->app->bind(TaskUpdater::class, TaskUpdaterService::class);
        $this->app->bind(TaskDeleter::class, TaskDeleterService::class);
        $this->app->bind(TaskOutputAdder::class, TaskOutputAdderService::class);
        $this->app->bind(UserTasksGetter::class, UserTasksGetterService::class);
        $this->app->bind(TagsAdder::class, TagsAdderService::class);
        $this->app->bind(TagPlucker::class, TagPluckerService::class);
        $this->app->bind(TasksFilter::class, TasksFilterService::class);  
        $this->app->bind(ResultAdder::class, ResultAdderService::class);  
        $this->app->bind(TaskAnswersList::class, TaskAnswersListService::class);
        $this->app->bind(UserTaskAnswerGetter::class, UserTaskAnswerGetterService::class);
        $this->app->bind(MarkSetter::class, MarkSetterService::class);
        $this->app->bind(AnswerOutputAdder::class, AnswerOutputAdderService::class);
        $this->app->bind(AnswerDeleter::class, AnswerDeleterService::class);
        $this->app->bind(RolesAssigner::class, RolesAssignerService::class);
        $this->app->bind(RoleRemover::class, RoleRemoverService::class);    
        $this->app->bind(PasswordUpdater::class, PasswordUpdaterService::class);
        $this->app->bind(CodePublisher::class, CodePublisherService::class);   
        $this->app->bind(InternalTokenGenerator::class, InternalTokenGeneratorService::class);   
        $this->app->bind(KafkaPublisher::class, KafkaPublisherService::class);
    }

}
