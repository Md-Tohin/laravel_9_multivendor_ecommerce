<div class="form-group">
    <label for="parent_id">Select Cateagory Level</label>
    <select name="parent_id" id="parent_id" class="form-control" style="color: #495057" required>
        <option value="0" @if(isset($category['parent_id']) && $category['parent_id']==0) selected="" @endif> Main Category</option>
        @if (!empty($getCategories))
            @foreach ($getCategories as $parentcategory)
                <option value="{{ $parentcategory['id'] }}"  @if(isset($category['parent_id']) && $category['parent_id']==$parentcategory['id']) selected="" @endif>{{ $parentcategory['category_name'] }}</option>
                @if (!empty($parentcategory['sub_categories']))
                    @foreach ($parentcategory['sub_categories'] as $subcategory)
                        <option value="{{ $subcategory['id'] }}"  @if(isset($category['parent_id']) && $category['parent_id']==$subcategory['id']) selected="" @endif>&nbsp;&nbsp;&nbsp;&raquo;&nbsp;{{ $subcategory['category_name'] }}</option>
                    @endforeach
                @endif
            @endforeach
        @endif
    </select>
</div>
