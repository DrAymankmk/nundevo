<?php

namespace App\Http\Controllers\AdminPanel\CMS;

use App\Models\CmsLanguage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class CmsLanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('cms.languages.index');
    }

    /**
     * Get languages data for DataTable.
     */
    public function data(Request $request): JsonResponse
    {
        $query = CmsLanguage::query();

        // Search
        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('native_name', 'like', "%{$search}%");
            });
        }

        $totalRecords = CmsLanguage::count();
        $filteredRecords = $query->count();

        // Ordering
        if ($request->has('order')) {
            $columnIndex = $request->order[0]['column'];
            $columnName = $request->columns[$columnIndex]['data'];
            $columnDirection = $request->order[0]['dir'];
            
            $sortableColumns = ['id', 'code', 'name', 'native_name', 'direction', 'is_default', 'is_active', 'order'];
            if (in_array($columnName, $sortableColumns)) {
                $query->orderBy($columnName, $columnDirection);
            }
        } else {
            $query->orderBy('order');
        }

        // Pagination
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $languages = $query->skip($start)->take($length)->get();

        $data = $languages->map(function ($language) {
            return [
                'id' => $language->id,
                'code' => $language->code,
                'name' => $language->name,
                'native_name' => $language->native_name ?? '-',
                'direction' => $language->direction,
                'flag' => $language->flag,
                'is_default' => $language->is_default,
                'is_active' => $language->is_active,
                'order' => $language->order,
            ];
        });

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:cms_languages,code',
            'name' => 'required|string|max:255',
            'native_name' => 'nullable|string|max:255',
            'direction' => 'required|in:ltr,rtl',
            'flag' => 'nullable|string|max:255',
            'is_default' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        // If setting as default, unset other defaults
        if ($request->boolean('is_default')) {
            CmsLanguage::where('is_default', true)->update(['is_default' => false]);
        }

        $language = CmsLanguage::create($validated);

        return response()->json([
            'success' => true,
            'message' => __('Language created successfully'),
            'data' => $language,
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function show($id): JsonResponse
    {
        $language = CmsLanguage::find($id);
    
        return response()->json([
            'success' => true,
            'data' => $language,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $language = CmsLanguage::find($id);
    
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:cms_languages,code,' . $language->id,
            'name' => 'required|string|max:255',
            'native_name' => 'nullable|string|max:255',
            'direction' => 'required|in:ltr,rtl',
            'flag' => 'nullable|string|max:255',
            'is_default' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        // If setting as default, unset other defaults
        if ($request->boolean('is_default') && !$language->is_default) {
            CmsLanguage::where('is_default', true)->update(['is_default' => false]);
        }

        $language->update($validated);

        return response()->json([
            'success' => true,
            'message' => __('Language updated successfully'),
            'data' => $language,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $language = CmsLanguage::find($id);
        if ($language->is_default) {
            return response()->json([
                'success' => false,
                'message' => __('Cannot delete the default language'),
            ], 422);
        }

        $language->delete();

        return response()->json([
            'success' => true,
            'message' => __('Language deleted successfully'),
        ]);
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus($id): JsonResponse
    {
        $language = CmsLanguage::find($id);
        $language->update(['is_active' => !$language->is_active]);

        return response()->json([
            'success' => true,
            'message' => __('Status updated successfully'),
            'is_active' => $language->is_active,
        ]);
    }
}
