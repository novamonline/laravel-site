<?php

namespace App\ViewModels;

use App\User;
use App\Models\Page;
use Spatie\ViewModels\ViewModel;
use App\Http\Resources\PageResource;
use App\Http\Controllers\PageController;

class PageView extends ViewModel
{
    public $indexUrl = null;

    public function __construct(User $user, Page $page = null)
    {
        $this->user = $user;
        $this->page = $page;

        $this->indexUrl = $this->page->url ?? action([PageController::class, 'index']);
    }

    public function page(): Page
    {
        return $this->page ?? new Page();
    }

    public function Pages()
    {
        $pg_id = request('pgid') ?? -1;
        $Pages = Page::topMost($pg_id);
        $Pages->Page = $this->page();
        return PageResource::collection($Pages);
    }

    public function selectOption($object, $name, $value, $text)
    {
        $option = "<option value=\"$value\"";
        if(($object->$name ?? $object[$name] ?? "") == $value){
            $option .= ' selected="selected"';
        }
        return "$option>$text</option>";
        //return ($this->page->$name ?? "") == $value? ' selected="selected"': '';
    }

    public function Templates()
    {
        $template_path = base_path('templates');
        $template_dirs = glob($template_path."/*");

        $templates = [];
        foreach($template_dirs as $template){
            $name = pathinfo($template,  PATHINFO_FILENAME);
            $path = str_replace(base_path(), "", $template);
            $templates[] = compact('name', 'path');
        }
        return collect($templates);
    }

    public function Layouts()
    {
        $template_path = base_path('templates');
        $template_dirs = glob($template_path."/*");

        $templates = [];
        foreach($template_dirs as $template){
            $name = pathinfo($template,  PATHINFO_FILENAME);
            $path = str_replace(base_path(), "", $template);
            $templates[] = compact('name', 'path');
        }
        return collect($templates);
    }

    public function PageTypes()
    {
        return collect([
            ['name' => PageController::class, 'info' => 'Basic Page']
        ]);
    }
}
