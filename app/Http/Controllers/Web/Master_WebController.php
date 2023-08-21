<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Classes\EasyData;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\Product;
use App\Models\Post;

class Master_WebController extends Controller
{
    public function homePage(Request $request)
    {     
        $slider = [];
        $testimonials = [];
        $products = [];
        $slider = Slider::where('status',1)->orderBy('order_no','ASC')->get();
        $testimonials = Testimonial::where('status',1)->orderBy('id','DESC')->get();
        $posts = Post::where('status',1)->orderBy('id','DESC')->take(10)->get();
        $products = Product::where('status',1)->orderBy('updated_at','DESC')->take(10)->get();
        return view('web.home',compact('slider','testimonials','products','posts'));
    }

    public function aboutPage(Request $request)
    {     
        $page_title = 'About Us';
        return view('web.about',compact('page_title'));
    }

    public function contactPage(Request $request)
    {     
        $page_title = 'Contact Us';
        return view('web.contact',compact('page_title'));
    }

    public function blogPage(Request $request)
    {     
        $posts = Post::where('status',1)->orderBy('id','DESC')->paginate(9);
        $page_title = 'IOA Blog';
        return view('web.blog',compact('posts','page_title'));
    }

    public function shopPage(Request $request)
    {     
        $products = Product::where('status',1)->orderBy('ogd_no','ASC')->paginate(40);
        $page_title = 'Shop';
        return view('web.shop',compact('products','page_title'));
    }

    public function cartPage(Request $request)
    {     
        $page_title = 'Shopping Cart';
        return view('web.cart',compact('page_title'));
    }

}

