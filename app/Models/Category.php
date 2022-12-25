<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\Category;

class Category extends Model
{
    use HasFactory;
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id')->select('id', 'name');
    }
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id')->select('id', 'category_name');
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->where('status', 1);
    }

    public static function categoryDetails($url){
        $categoryDetails = Category::select('id', 'parent_id', 'category_name', 'url', 'description')->with(['subCategories'=>function($query){
            $query->select('id', 'parent_id', 'category_name', 'url', 'description');
        }])->where('url',$url)->first()->toArray();
        // dd($categoryDetails);
        $catIds = array();
        $catIds[] = $categoryDetails['id'];

        if ($categoryDetails['parent_id'] == 0) {
            //  only show Main category in breadcrumb
            $breadCrumbs = '<li class="is-marked">
            <a href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_name'].'</a>
        </li>';
        } else {
            //  show Main and sub category in breadcrumb
            $parentCategory = Category::select('category_name', 'url')->where('id', $categoryDetails['parent_id'])->first()->toArray();
            $breadCrumbs = '
            <li class="has-separator">
            <a href="'.url($parentCategory['url']).'">'.$parentCategory['category_name'].'</a>
        </li>
            <li class="is-marked">
            <a href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_name'].'</a>
        </li>';
        }
        

        foreach ($categoryDetails['sub_categories'] as $key => $subcat) {
            $catIds[] = $subcat['id'];
        }
        // dd($catIds);
        $resp = array('catIds'=>$catIds, 'categoryDetails'=>$categoryDetails, 'breadCrumbs'=>$breadCrumbs);
        return $resp;
    }

    public static function getCategoryName($category_id){
        // return $category_id; die;
        $getCatName = Category::select('category_name')->where('id',$category_id)->first();
        return $getCatName->category_name;
    }
    
}
