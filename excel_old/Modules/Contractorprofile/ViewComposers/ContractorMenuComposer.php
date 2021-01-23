<?php

namespace Modules\Contractorprofile\ViewComposers;

use Illuminate\Support\Facades\Lang;
use Illuminate\View\View;
use Spatie\Menu\Html;
use Spatie\Menu\Link;
use Spatie\Menu\Menu;
use Spatie\Menu\Laravel\View as SpatieView;

/**
 * Class ContractorMenuComposer
 * @package Modules\Contractorprofile\ViewComposers
 */
class ContractorMenuComposer
{
    /**
     * Compose Settings Menu
     * @param View $view
     */
    public function compose(View $view)
    {
        $mainMenu = Menu::new();
        $navigationTrans = 'core.contractor_navigation';
        $mainMenu->addClass('list');
        $mainMenu->add(Html::raw(Lang::get($navigationTrans))->addParentClass('header'));

        //$mainMenu->add(Link::to('/', 'Home'))
        $mainMenu->add(SpatieView::create('menu-element', [
                        'icon' => 'apps',
                        'name' => 'Home',
                        'url' => route('home')
                    ]));
        $mainMenu->add(SpatieView::create('menu-element', [
                        'icon' => 'work',
                        'name' => 'Job Requested',
                        'url' => route('job.status','requested')
                    ]));
        $mainMenu->add(SpatieView::create('menu-element', [
                        'icon' => 'work',
                        'name' => 'Job Confirmed',
                        'url' => route('job.status','confirmed')
                    ]));
        $mainMenu->add(SpatieView::create('menu-element', [
                        'icon' => 'work',
                        'name' => 'Job Completed',
                        'url' => route('job.status','completed')
                    ]));


        $view->with('contractorMainMenu', $mainMenu);
    }
}
