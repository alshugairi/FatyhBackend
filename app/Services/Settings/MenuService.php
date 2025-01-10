<?php

namespace App\Services\Settings;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Post;
use App\Repositories\Settings\MenuRepository;
use App\Services\BaseService;
use Illuminate\{Database\Eloquent\Model,
    Http\JsonResponse,
    Pipeline\Pipeline,
    Support\Arr,
    Support\Facades\Storage,
    Support\Str};
use Yajra\DataTables\DataTables;

class MenuService extends BaseService
{
    public function __construct(MenuRepository $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data): Model
    {
        $menu = $this->repository->create($data);
        $menuStructure = json_decode($data['menu_items_structure'], true);
        $this->saveMenuItems($menuStructure, $menu->id);

        return $menu;
    }

    public function update(array $data, int $id): Model
    {
        $menu = $this->repository->update($data, $id);
        $menuStructure = json_decode($data['menu_items_structure'], true);
        MenuItem::where('menu_id', $id)->delete();
        $this->saveMenuItems($menuStructure, $menu->id);

        return $menu;
    }

    private function saveMenuItems(array $items, int $menuId, ?int $parentId = null, int $order = 0)
    {
        foreach ($items as $item) {
            $relatedId = !empty($item['related_id']) ? $item['related_id'] : null;

            $name = !empty($relatedId) ? $this->getRelatedItemTranslations($relatedId, $item['type']) : null;

            $menuItem = MenuItem::create([
                'menu_id' => $menuId,
                'parent_id' => $parentId,
                'name' => $name,
                'type' => $item['type'],
                'related_id' => $relatedId,
                'url' => $item['url'] ?? '#',
                'translation_key' => $item['translation_key'] ?? NULL,
                //'css_class' => $item['css_class'] ?? NULL,
                'order' => $order
            ]);

            if (!empty($item['children'])) {
                $this->saveMenuItems($item['children'], $menuId, $menuItem->id, 0);
            }

            $order++;
        }
    }

    public function getRelatedItemTranslations(?int $relatedId, string $type): ?array
    {
        if ($type === 'category') {
            $category = Category::find($relatedId);
            return $category ? $category->getTranslations('name') : null;
        } elseif ($type === 'page') {
            $page = Post::find($relatedId);
            return $page ? $page->getTranslations('name') : null;
        }
        return null;
    }

    public function formatMenuItems($items, &$counter = 1)
    {
        return $items->map(function ($item) use (&$counter) {
            $formattedItem = [
                'id' => $counter++,
                'name' => $item->name,
                'type' => $item->type,
                'url' => $item->url,
                'parent_id' => $item->parent_id,
                'related_id' => $item->related_id,
                'translation_key' => $item->translation_key,
                'css_class' => $item->css_class,
                'children' => $item->children ? $this->formatMenuItems($item->children, $counter) : [],
            ];
            return $formattedItem;
        });
    }

    public function list(array $filters = [], array $relations = [], array $withCount = []): JsonResponse
    {
        $query = $this->repository->getModel()->with($relations);

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('name', function ($item){ return $item->name; })
            ->toJson();
    }
}
