<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Template::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template_name' => 'required|unique:templates',
            'template_url' => 'required',
            'template_image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $template = new Template();
        $template->template_name = $request->template_name;
        $template->template_url = $request->template_url;
        if ($request->hasFile('template_image')) {
            $path = public_path('storage/images/template/');
            $file = $request->file('template_image');
            $fileName = date('') . $request->template_name . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $template->template_image = $fileName;
        }
        $template->save();
        return response()->json($template);
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Template $template)
    {
        if ($template) {
            return response()->json([
                'template' => $template,
            ]);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Template $template)
    {
        $validator = Validator::make($request->all(), [
            'template_name' => 'required',
            'template_url' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $template->template_name = $request->template_name;
        $template->template_url = $request->template_url;
        if ($request->hasFile('template_image')) {
            $oldPath = public_path('storage/images/template/' . $template->template_image);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
            $path = public_path('storage/images/template/');
            $file = $request->file('template_image');
            $fileName = date('') . $request->template_name . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $template->template_image = $fileName;
        }
        $template->save();
        return response()->json($template);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        $template->delete();
        $oldPath = public_path('storage/images/template/' . $template->template_image);
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }
        return response()->json($template);
    }
}
