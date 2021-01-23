<?php

namespace Modules\Users\Repositories;

use Modules\Core\Repositories\PlatformRepository;
//use Modules\Platform\Settings\Entities\Language;
use App\User;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepository
 * @package Modules\Platform\User\Repositories
 */
class UserRepository extends PlatformRepository
{
    public function model()
    {
        return User::class;
    }
}
