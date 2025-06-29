<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostContent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $posts = Post::query()
            ->latest()
            ->get();

        return view('admin_panel.posts.index', compact('posts'));
    }

    private function data(Post $post) {
        $categories = Category::query()
            ->orderBy('name', "asc")
            ->get();

        $status = Post::$status;

        return [
            'post' => $post,
            'categories' => $categories,
            'status' => $status
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin_panel.posts.create', $this->data(new Post) + [
            'selected_category_ids' => []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validated_data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'category_ids' => ['required', 'array', 'min:1'],
            'category_ids.*' => ['exists:categories,id'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'input_status' => ['required', 'in:' . implode(',', Post::$status)],
            'contents.*.title' => ['nullable', 'string', 'max:255'],
            'contents.*.content_type' => ['required', 'in:text,graph'],
            'contents.*.data' => ['required'],
            'contents.*.data.labels.*' => ['required_if:contents.*.content_type,graph', 'string'],
            'contents.*.data.series.*.name' => ['required_if:contents.*.content_type,graph', 'string'],
            'contents.*.data.series.*.color' => ['nullable', 'in:red,blue,green,orange'],
            'contents.*.data.series.*.values.*' => ['nullable', 'numeric'],
        ]);

        DB::beginTransaction();

        try {
            $featured_image_name = null;
            if ($request->hasFile('featured_image')) {
                $featured_image = $request->file('featured_image');
                $extension = $featured_image->getClientOriginalExtension();
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $destination_path = 'images/posts/';
                    $featured_image_name = date('YmdHis') . '_' . uniqid() . '.' . $extension;
                    $featured_image->move(public_path($destination_path), $featured_image_name);
                    $featured_image_name = $destination_path . $featured_image_name;
                }
            }

            $post = Post::create([
                'author_type' => 'App\Models\User',
                'author_id' => auth()->id(),
                'title' => $validated_data['title'],
                'slug' => Str::slug($validated_data['title']),
                'excerpt' => $validated_data['excerpt'],
                'status' => $validated_data['input_status'],
                'featured_image' => $featured_image_name,
            ]);

            if ($validated_data['input_status'] == "Published") {
                $post->update([
                    'published_at' => now()
                ]);
            }

            $post->categories()->attach($validated_data['category_ids']);

            foreach ($validated_data['contents'] as $content) {
                PostContent::create([
                    'post_id' => $post->id,
                    'title' => $content['title'],
                    'content_type' => $content['content_type'],
                    'data' => json_encode($content['data']),
                ]);
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => 'Post created successfully.']);
            }
        }
        catch (\Exception $e) {
            DB::rollback();

            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred while creating the post: ' . $e->getMessage()], 422);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post) {
        $categories = Category::query()
            ->orderBy('name', "asc")
            ->get();

        return view('post_details', compact('post','categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post) {
        $selected_category_ids = $post->categories->pluck('id')->toArray();

        return view('admin_panel.posts.edit', $this->data($post) + [
            'selected_category_ids' => $selected_category_ids
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post) {
        $validated_data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'category_ids' => ['required', 'array', 'min:1'],
            'category_ids.*' => ['exists:categories,id'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'input_status' => ['required', 'in:' . implode(',', Post::$status)],
            'contents.*.title' => ['nullable', 'string', 'max:255'],
            'contents.*.content_type' => ['required', 'in:text,graph'],
            'contents.*.data' => ['required'],
            'contents.*.id' => ['sometimes', 'exists:post_contents,id'],
            'contents.*.data.labels.*' => ['required_if:contents.*.content_type,graph', 'string'],
            'contents.*.data.series.*.name' => ['required_if:contents.*.content_type,graph', 'string'],
            'contents.*.data.series.*.color' => ['nullable', 'in:red,blue,green,orange'],
            'contents.*.data.series.*.values.*' => ['nullable', 'numeric'],
        ]);

        DB::beginTransaction();

        try {
            $featured_image_name = $post->featured_image_name;

            if ($request->hasFile('featured_image')) {
                if ($featured_image_name && file_exists(public_path($featured_image_name))) {
                    unlink(public_path($featured_image_name));
                }

                $featured_image = $request->file('featured_image');

                $extension = $featured_image->getClientOriginalExtension();
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $destination_path = 'images/companies/';
                    $featured_image_name = date('YmdHis') . '_' . uniqid() . '.' . $extension;
                    $featured_image->move(public_path($destination_path), $featured_image_name);
                    $featured_image_name = $destination_path . $featured_image_name;
                }
            }

            $post->update([
                'title' => $validated_data['title'],
                'slug' => Str::slug($validated_data['title']),
                'excerpt' => $validated_data['excerpt'],
                'status' => $validated_data['input_status'],
                'featured_image' => $featured_image_name,
            ]);

            if ($validated_data['input_status'] == "Published") {
                $post->update([
                    'published_at' => now()
                ]);
            }

            $post->categories()->sync($validated_data['category_ids']);

            $existingContentIds = $post->contents->pluck('id')->toArray();
            $submittedContentIds = array_filter(array_column($validated_data['contents'], 'id'));

            $contentsToDelete = array_diff($existingContentIds, $submittedContentIds);
            if ($contentsToDelete) {
                $post->contents()->whereIn('id', $contentsToDelete)->delete();
            }

            foreach ($validated_data['contents'] as $key => $content) {
                $data = json_encode($content['data']);

                if (isset($content['id'])) {
                    $post->contents()->where('id', $content['id'])->update([
                        'title' => $content['title'],
                        'content_type' => $content['content_type'],
                        'data' => $data,
                    ]);
                }
                else {
                    $post->contents()->create([
                        'title' => $content['title'],
                        'content_type' => $content['content_type'],
                        'data' => $data,
                    ]);
                }
            }
            
            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => 'Post updated successfully.']);
            }
        }
        catch (\Exception $e) {
            DB::rollback();

            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred while updateing the post: ' . $e->getMessage()], 422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post) {
        DB::beginTransaction();

        try {
            $post->contents()->delete();

            $post->delete();

            DB::commit();

            return redirect()->to('admin-panel/posts')
                ->with('success', 'Deleted Successfully.');
        } 
        catch (\Exception $e) {
            DB::rollback();

            return back()
                ->with('error', 'An error occurred while deleting the record. ' . $e->getMessage());
        }
    }
}
