<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    //
    public function index($id)
    {
        $post = Post::getPost()->where('id', $id)->first();
        return view('blog-post', ['post' => $post]);
    }
    public function getPosts()
    {
        //  echo "inside get posts";
        $posts = Post::getPost()->get();
        // print_r($posts->toArray());
        // exit();
        return view('admin.posts', compact('posts'));
        exit();
    }
    public function getPost($id = '')
    {
        $post = array();
        if (isset($id) && $id != '') {
           
            $post = Post::findOrFail($id);
            $this->authorize('view',$post);
        }
        return view('admin.savepost', compact('post'));
        exit();
    }
    public function savePost(Request $request)
    {
        $post = $request->input();
     //   print_r($post);
      //  exit();
        $request->validate([
            'postTitle' => 'required',
            'postDescription' => 'required'
        ]);
        $id= $request->input('id');
        //if id is there then we will save
        if(isset($id) && $id != ''){
            //echo "inside";
            print_r($request->input());
            exit();
          $editpost = Post::findOrFail($id);
          $editpost->name=$request->input('postTitle');
          $editpost->user_id= Auth::user()->id;
          $editpost->description=$request->input('postDescription');
          $url=$request->file('postImage');
          if(isset($url) && $url != ''){
            $files = $request->file('postImage');
            $folder = 'images/user'.Auth::user()->id.'/';
            $filename=time().$files->getClientOriginalName();
            $path = $request->file('postImage')->storeAs(
                $folder, $filename
            );
           
            $editpost->url=  $path;
        }
        $this->authorize('update',$editpost);
          $result=$editpost->save();
          if($result == 1){
            $message= array('message' => 'You have successfully updated Post!');
            return json_encode($message);
        }
         // Session::flash('postupdate', 'You have successfully updated Post!');
        //  return redirect('/getposts');
        }else{
          //add post
          $post = new Post();
          $post->name=$request->input('postTitle');
          $post->user_id= Auth::user()->id;
          $post->description=$request->input('postDescription');
          $url=$request->file('postImage');
          if(isset($url) && $url != ''){
            $files = $request->file('postImage');
            $folder = 'images/'.Auth::user()->id.'/';
            $filename=time().$files->getClientOriginalName();
            $path = $request->file('postImage')->storeAs(
                $folder, $filename
            );
           
            $post->url=  $path;
        }
          $result=$post->save();
            if($result == 1){
                $message= array('message' => 'You have successfully Created Post!');
                return json_encode($message);
            }
          //Session::flash('postinsert', 'You have successfully Created Post!');
         // return redirect('/getposts');
        }
    }
    public function deletePost($id=''){
        $post= Post::findOrFail($id);
        $this->authorize('delete',$post);
        $post->deleted_flag=1;
        $result=$post->save();
        if($result == 1){
            $message= array('message' => 'You have successfully deleted Post!');
            return json_encode($message);
        }
    }
}
