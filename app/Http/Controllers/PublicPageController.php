<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PublicPageController extends Controller
{
    public function index() {
        $posts = Post::query()
            ->where('status', "Published")
            ->latest()
            ->get();

        return view('welcome', compact('posts'));
    }

    public function posts(Request $request) {
        //
    }

    public function post_details($slug) {
        $post = Post::query()
            ->where('slug', $slug)
            ->firstOrFail();

        $categories = Category::query()
            ->orderBy('name', "asc")
            ->get();

        return view('post_details', compact('post','categories'));
    }

    public function comment(Request $request, Post $post) {
        $validated_data = $request->validate([
            'comment' => ['required', 'string'],
        ]);

        DB::beginTransaction();

        try {
            Comment::create([
                'commenter_type' => 'App\Models\Client',
                'commenter_id' => Auth::guard('client')->user()->id,
                'post_id' => $post->id,
                'content' => $validated_data['comment'],
                'status' => "Approved"
            ]);

            DB::commit();

            return response()->json(['success' => 'Comment created successfully.']);
        }
        catch (\Exception $e) {
            DB::rollback();

            return response()->json(['error' => 'An error occurred while creating the post: ' . $e->getMessage()], 422);
        }
    }

    public function comment_reply() {
        //
    }

    public function about_us() {
        return view('about_us');
    }

    public function contact_us() {
        return view('contact_us');
    }

    public function faq() {
        return view('faq');
    }

    public function privacy_policy() {
        return view('privacy_policy');
    }
    
    public function terms_and_conditions() {
        return view('terms_and_conditions');
    }
}
