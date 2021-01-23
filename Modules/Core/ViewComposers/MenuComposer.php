<?php

namespace Modules\Core\ViewComposers;

use Illuminate\Support\Facades\Lang;
use Illuminate\View\View;
use Spatie\Menu\Html;
use Spatie\Menu\Link;
use Spatie\Menu\Menu;
use Spatie\Menu\Laravel\View as SpatieView;

/**
 * Class MenuComposer
 * @package Modules\Core\ViewComposers
 */
class MenuComposer
{
    /**
     * Compose Settings Menu
     * @param View $view
     */
    public function compose(View $view)
    {
        $mainMenu = Menu::new();
        $navigationTrans = 'core.main_navigation';
        $mainMenu->addClass('list');
        $mainMenu->add(Html::raw(Lang::get($navigationTrans))->addParentClass('header'));

        //$mainMenu->add(Link::to('/', 'Home'))
        $mainMenu->add(SpatieView::create('menu-element', [
                        'icon' => 'apps',
                        'name' => 'Home',
                        'url' => route('home')
                    ]));
        $mainMenu->add(SpatieView::create('menu-element', [
                        'icon' => 'account_box',
                        'name' => 'Signups',
                        'url' => route('signup.index')
                    ]));
        $mainMenu->add(SpatieView::create('menu-element', [
                        'icon' => 'person',
                        'name' => 'Users',
                        'url' => route('users.index')
                    ]));
        $mainMenu->add(SpatieView::create('menu-element', [
                        'icon' => 'groups',
                        'name' => 'Clients',
                        'url' => route('clients.index')
                    ]));
        $mainMenu->add(SpatieView::create('menu-element', [
                        'icon' => 'engineering',
                        'name' => 'Contractorsignups',
                        'url' => route('contractorsignup.index')
                    ]));
        $mainMenu->add(SpatieView::create('menu-element', [
                        'icon' => 'construction',
                        'name' => 'Contractors',
                        'url' => route('contractors.index')
                    ]));
        $mainMenu->add(SpatieView::create('menu-element', [
                        'icon' => 'work_outline',
                        'name' => 'Jobtypes',
                        'url' => route('jobtypes.index')
                    ]));
        $mainMenu->add(SpatieView::create('menu-element', [
                        'icon' => 'work',
                        'name' => 'Jobs',
                        'url' => route('jobs.index')
                    ]));
        $mainMenu->add(SpatieView::create('menu-element', [
                        'icon' => 'calendar_today',
                        'name' => 'Calendar',
                        'url' => route('jobs.calendar')
                    ]));


        /*$settingsMenu->each(function (Link $link) {
            $link->addClass('list-group-item');
        });*/
        
//https://material.io/resources/icons/?style=baseline





        $view->with('mainMenu', $mainMenu);
    }
}
