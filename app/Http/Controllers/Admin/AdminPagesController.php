<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Page;
use App\Http\Models\Order;
use App\Http\Models\Product;
use App\Http\Models\Converter;
/*Rian*/
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNewsletter;
/*end Rian */
class AdminPagesController extends Controller
{
	public function validateEmail($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}
    public function index(Request $request)
    {
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Website', 'path'=>''],
			(object)['name' =>'Pages', 'path'=>'admin/pages']
		];

		$page = new Page;
        return view('admin/website/pages/index', ['admin'=>$admin, 'pages' => $page->getAllPages(), 'breadCrumb'=>$breadCrumb]);
    }
    public function editPages(Request $request, $id)
    {
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Website', 'path'=>''],
			(object)['name' =>'Pages', 'path'=>'admin/pages'],
			(object)['name' =>'Edit Pages', 'path'=>'admin/pages/editpages/'.$id]
		];

		$page = new Page;
        return view('admin/website/pages/edit', ['admin'=>$admin, 'page' => $page->getPagesById($id), 'breadCrumb'=>$breadCrumb]);
    }
    public function viewPages(Request $request, $id)
    {
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Website', 'path'=>''],
			(object)['name' =>'Pages', 'path'=>'admin/pages'],
			(object)['name' =>'View Pages', 'path'=>'admin/pages/viewpages/'.$id]
		];

		$page = new Page;
        return view('admin/website/pages/view', ['admin'=>$admin, 'page' => $page->getPagesById($id), 'breadCrumb'=>$breadCrumb]);
    }
   public function submitPages(Request $request)
    {
		$page = new Page;
		$pageId = $request->input('pageId');
		$pageText = $request->input('pageContent');
		$pageImage = null;
		$pageVideo = null;
		$showImage = 0;
		$showVideo = 0;

		if($request->file('uploadImage') != null)
		{
			if ($request->file('uploadImage')->isValid()) {
				$destinationFile = "sliderimage";
				$extension = $request->file('uploadImage')->getClientOriginalExtension();
				$filename = 'banner_about.'.$extension;
				$request->file('uploadImage')->move($destinationFile, $filename);
				$pageImage = $destinationFile."/".$filename;
			}
		}

		if(!empty($request->input('video'))){

			$pageVideo = substr($request->input('video'), 38, -77);
		}

		if(!empty($request->input('show_image'))){
			$showImage = 1;
		}

		if(!empty($request->input('show_video'))){
			$showVideo = 1;
		}

		$page->submitPages($pageId, $pageText, $pageImage, $pageVideo, $showImage, $showVideo);

        return redirect('meisjejongetje/pages')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully edited this page.']);
    }
		/*Rian 20170616 popup*/
		public function showPopup(Request $request)
		{
			$admin = $request->session()->get('admin');
			if($admin == null) return redirect('meisjejongetje/');

			$breadCrumb = [
				(object)['name' =>'Website', 'path'=>''],
				(object)['name' =>'Popup', 'path'=>'/meisjejongetje/pages/popup']
			];

			$page = new Page;
			return view('admin/website/popup/index')->with([
				'admin'=>$admin,
				'popup'=>$page->getPopup()[0],
				'breadCrumb'=>$breadCrumb
			]);
		}

		public function submitPopup(Request $request)
		{
			$start_date = date("Y-m-d",strtotime(str_replace("/","-",$request->input('start_popup'))));
			$end_date = date("Y-m-d",strtotime(str_replace("/","-",$request->input('end_popup'))));
			$request=array_add($request,"start_date",$start_date);
			$request=array_add($request,"end_date",$end_date);
			$this->validate($request,[
				'select_method'	=>'required'
				,'message'			=>'required'
				,'start_date' => 'required|date'
				,'end_date' => 'required|date'
				,'url_path' => 'required'
			]);


			if(strtotime($request->input('end_date')) < strtotime($request->input('start_date'))){
				return redirect('meisjejongetje/pages/popup')->with('message', (object)['type'=>'alert-danger', 'content'=>'The end date must be a date after start date.']);
			}

			$page = new Page;
			$popup=$page->getPopup()[0];
			$imageTemp=$popup->image_path;
			if(!empty($request->file('image'))){
	      $this->validate($request, [
	        'image' => 'required|mimes:jpg,jpeg,gif,png'
	      ]);
	      $image = $request->file('image');
	      /*loop each image and store to array*/
	      $filename = strtotime("now").".".$image->getClientOriginalExtension();
	      $image->move('popupimage',$filename);
	      $imageTemp="popupimage/".$filename;
	    }
			$is_active=0;
			if($request->input('is_active') !=null){
				$is_active = 1;
			}
			$popup=$page->updatePopup($request->input('select_method'),$request->input('url_path'),$imageTemp,$request->input('message'),$start_date,$end_date,$is_active);

			return redirect('meisjejongetje/pages/popup')->with('message', (object)['type'=>'alert-success', 'content'=>'You have succesfully edited the information']);
		}

		public function showCurrency(Request $request)
		{
			$admin = $request->session()->get('admin');
			if($admin == null) return redirect('meisjejongetje/');

			$breadCrumb = [
				(object)['name' =>'Website', 'path'=>''],
				(object)['name' =>'Popup', 'path'=>'/meisjejongetje/pages/currency']
			];

			$page = new Page;
			return view('admin/website/currency/index')->with([
				'admin'=>$admin,
				'currencies'=>$page->getCurrency(),
				'breadCrumb'=>$breadCrumb
			]);
		}

		public function submitCurrency(Request $request)
		{
			$this->validate($request,[
				'is_active'	=>'required'
			]);
			$page = new Page;
			$popup=$page->updateCurrency($request->input('is_active'));

			return redirect('meisjejongetje/pages/currency')->with('message', (object)['type'=>'alert-success', 'content'=>'You have succesfully edited the information']);
		}
		/*End Rian*/
    public function contact(Request $request)
    {
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Website', 'path'=>''],
			(object)['name' =>'Contact', 'path'=>'admin/pages/contact']
		];

		$page = new Page;
		$arr = [
			'admin'=>$admin,
			'contact' => $page->getContact()[0],
			'messages' => $page->getAllMessages(),
			'breadCrumb'=>$breadCrumb
		];
        return view('admin/website/contact/index', $arr);
    }
    public function submitContact(Request $request)
    {
		$page = new Page;

		$hoursOfOperation = $request->input('hoursOfOperation');
		$phoneNumber = $request->input('phoneNumber');
		$mobileNumbser = $request->input('mobileNumbser');
		$email = $request->input('email');
		$maps = $request->input('maps');
		$address = $request->input('address');

		if($phoneNumber == '')
		{
			return redirect('meisjejongetje/pages/contact')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the telephone number field.']);
		}
		else if($email == '')
		{
			return redirect('meisjejongetje/pages/contact')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the email address field.']);
		}
		else if(!$this->validateEmail($email))
		{
			return redirect('meisjejongetje/pages/contact')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please enter a valid email address.']);
		}
		else if($address == '')
		{
			return redirect('meisjejongetje/pages/contact')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the address field.']);
		}
		else if($maps == '')
		{
			return redirect('meisjejongetje/pages/contact')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the maps field.']);
		}

		if(strpos($maps, 'iframe') == true)
		{
			$maps = substr($maps, 13, -85);
		}
		$page->submitContact($hoursOfOperation, $phoneNumber, $mobileNumbser, $email, $maps, $address);

        return redirect('meisjejongetje/pages/contact')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully edited the information.']);
    }
    public function deleteMessage(Request $request)
    {
		$page = new Page;
		$id = $request->input('deleteId');
		$page->deleteMessageById($id);

        return redirect('meisjejongetje/pages/contact')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully deleted messages.']);
    }

    public function career(Request $request)
    {
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$page = new Page;
		$converter = new Converter;

		$breadCrumb = [
			(object)['name' =>'Website', 'path'=>''],
			(object)['name' =>'Career', 'path'=>'admin/pages/career']
		];

		$jobs = $page->getAllDetailCareer();
		foreach($jobs as $job){
			$job->careerdate = $converter->dateFormat($job->careerdate);
		}
		$arr = [
			'admin'=>$admin,
			'career' => $page->getCareer()[0],
			'jobs' => $jobs,
			'breadCrumb' => $breadCrumb
		];
        return view('admin/website/career/index', $arr);
    }
	public function postCareer(Request $request)
	{
		$page = new Page;
		$email = $request->input('email');
		$paragraph = $request->input('paragraph');

		if($email == '')
		{
			return redirect('meisjejongetje/pages/career')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the email address field.']);
		}
		else if(!$this->validateEmail($email))
		{
			return redirect('meisjejongetje/pages/career')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please enter a valid email address.']);
		}
		else if($paragraph == '')
		{
			return redirect('meisjejongetje/pages/career')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the paragraph.']);
		}

		$page->postCareer($email, $paragraph);
		return redirect('meisjejongetje/pages/career')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully edited this page.']);
	}
    public function addCareer(Request $request)
    {
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Website', 'path'=>''],
			(object)['name' =>'Career', 'path'=>'admin/pages/career'],
			(object)['name' =>'Add Career', 'path'=>'admin/pages/career/addcareer'],
		];

		$arr = [
			'admin'=>$admin,
			'title' => 'Add',
			'detailJob' => (object)['careerid'=>null, 'careertitle'=>null, 'careercontent'=>null, 'ispublish'=>null],
			'breadCrumb' => $breadCrumb
		];
        return view('admin/website/career/add', $arr);
    }
    public function editCareer(Request $request, $id)
    {
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Website', 'path'=>''],
			(object)['name' =>'Career', 'path'=>'admin/pages/career'],
			(object)['name' =>'View Career', 'path'=>'admin/pages/career/editcareer/'.$id],
		];

		$page = new Page;
        return view('admin/website/career/add', ['admin'=>$admin, 'title' => 'Edit', 'detailJob' => $page->getDetailCareer($id)[0], 'breadCrumb'=>$breadCrumb]);
    }
    public function viewCareer(Request $request, $id)
    {
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Website', 'path'=>''],
			(object)['name' =>'Career', 'path'=>'admin/pages/career'],
			(object)['name' =>'View Career', 'path'=>'admin/pages/career/viewcareer/'.$id],
		];

		$page = new Page;
        return view('admin/website/career/view', ['admin'=>$admin, 'detailJob' => $page->getDetailCareer($id)[0], 'breadCrumb'=>$breadCrumb]);
    }
    public function deleteCareer(Request $request)
    {
		$page = new Page;
		$id = $request->input('deleteId');
		$page->deleteCareerById($id);

        return redirect('meisjejongetje/pages/career')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully deleted this career.']);
    }
	public function submitCareer(Request $request)
	{
		$page = new Page;
		$careerId = $request->input('careerId');
		$careerTitle = $request->input('careerTitle');
		$careerContent = $request->input('careerContent');
		$isPublish = ($request->input('isPublish') != null ? $request->input('isPublish'):0);

		if($careerTitle == '')
		{
			if($careerId == null || $careerId == '')
				return redirect('meisjejongetje/pages/career/addcareer')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the title field.']);
			else
				return redirect('meisjejongetje/pages/career/editcareer/'.$careerId)->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the title field.']);
		}
		else if($page->getDetailCareerByIdName($careerId, $careerTitle))
		{
			if($careerId == null || $careerId == '')
				return redirect('meisjejongetje/pages/career/addcareer')->with('message', (object)['type'=>'alert-warning', 'content'=>'The title has already been taken.']);
			else
				return redirect('meisjejongetje/pages/career/editcareer/'.$careerId)->with('message', (object)['type'=>'alert-warning', 'content'=>'The title has already been taken.']);
		}
		else if($careerContent == '')
		{
			if($careerId == null || $careerId == '')
				return redirect('meisjejongetje/pages/career/addcareer')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the paragraph field.']);
			else
				return redirect('meisjejongetje/pages/career/editcareer/'.$careerId)->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the paragraph field.']);
		}

		$page->submitCareer($careerId, $careerTitle, $careerContent, $isPublish);
        return redirect('meisjejongetje/pages/career')->with('message', (object)['type'=>'alert-success', 'content'=>'You have succesfully save this career']);
	}

	public function slider(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Website', 'path'=>''],
			(object)['name' =>'Slider', 'path'=>'admin/pages/slider']
		];

		$page = new Page;
		$converter = new Converter;

		$sliders = $page->getAllSlider();
		foreach($sliders as $slider)
		{
			$slider->uploaddate = $converter->dateFormat($slider->uploaddate);
		}
		return view('admin/website/slider/index',  ['admin'=>$admin, 'sliders'=>$sliders, 'breadCrumb'=>$breadCrumb, 'path'=>'', 'pathImage'=>'']);
	}
	public function addSlider(Request $request)
	{
		$page = new Page;
		if($request->file('uploadSlider') == null)
		{
			return redirect('meisjejongetje/pages/slider')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please insert the slider image.']);
		}

		if ($request->file('uploadSlider')->isValid()) {
			$isPublish = ($request->input('isPublish') == null ? 0:1);

			$destinationFile = "sliderimage";
			$extension = $request->file('uploadSlider')->getClientOriginalExtension();
			$filename = rand(11111,99999).'.'.$extension;
			$request->file('uploadSlider')->move($destinationFile, $filename);
			//2019-01-07 penambahan sort by
			$page->addSlider($destinationFile."/".$filename, $extension, $isPublish);

			return redirect('meisjejongetje/pages/slider')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully added new slider image.']);
		}
	}
	public function editSlider(Request $request)
	{
		$page = new Page;
		$id = $request->input('editSliderId');
		$isPublish = ($request->input('editPublish') == null ? 0:1);
		//2019-01-07 penambahan sort by
		$sortBy = $request->input('editSortBy');
		$this->validate($request,[
			'editSortBy' => 'required|numeric'
		]);
		if(empty($page->checkUniqueSortBy($id,$sortBy))){
			$page->editSlider($id, $isPublish, $sortBy);
		}else{
			return redirect('meisjejongetje/pages/slider')->with('message', (object)['type'=>'alert-danger', 'content'=>'Sort by already taken.']);
		}

		return redirect('meisjejongetje/pages/slider')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully edited this slider image.']);
	}
	public function deleteSlider(Request $request)
	{
		$page = new Page;
		$id = $request->input('deleteId');
		$page->deleteSliderById($id);

		return redirect('meisjejongetje/pages/slider')->with('message', (object)['type'=>'alert-success', 'content'=>'You have sucessfully edited this slider image.']);
	}

	public function footer(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Website', 'path'=>''],
			(object)['name' =>'Footer', 'path'=>'admin/pages/footer']
		];

		$page = new Page;
        return view('admin/website/footer/index', ['admin'=>$admin, 'detailFooter' => $page->getFooter()[0], 'breadCrumb'=>$breadCrumb]);
	}
	public function submitFooter(Request $request)
	{
		$page = new Page;
		$type = $request->input('type');
		$paymentMethod = $request->input('paymentMethod');
		$copyright = $request->input('copyright');
		$facebook = $request->input('facebook');
		$instagram = $request->input('instagram');
		$pinterest = $request->input('pinterest');

		$page->submitFooter($type, $paymentMethod, $copyright, $facebook, $instagram, $pinterest);
		if($type == 0)
			return redirect('meisjejongetje/pages/footer')->with('message', (object)['type'=>'alert-success', 'content'=>'You have succesfully edited the information.']);
		else
			return redirect('meisjejongetje/settings/socialmedia')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully edited the information.']);
	}

	public function blogCategory(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Website', 'path'=>''],
			(object)['name' =>'Blog', 'path'=>''],
			(object)['name' =>'Category', 'path'=>'admin/pages/blog/category']
		];

		$page = new Page;
        return view('admin/website/blog/category/index', ['admin'=>$admin, 'blogs'=>$page->getAllBlogCategory(), 'breadCrumb'=>$breadCrumb]);
	}
	public function addBlogCategory(Request $request)
	{
		$page = new Page;
		$name = $request->input('name');

		if($name == '')
		{
			return redirect('meisjejongetje/pages/blog/category')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the category name field.']);
		}
		else if($page->getBlogCategoryByIdName('', $name))
		{
			return redirect('meisjejongetje/pages/blog/category')->with('message', (object)['type'=>'alert-warning', 'content'=>'The category name has already been taken.']);
		}

		$page->addBlogCategory($name);
        return redirect('meisjejongetje/pages/blog/category')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully added this blog.']);
	}
	public function editBlogCategory(Request $request)
	{
		$page = new Page;
		$id = $request->input('editCategoryId');
		$name = $request->input('editName');

		if($name == '')
		{
			return redirect('meisjejongetje/pages/blog/category')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the category name field.']);
		}
		else if($page->getBlogCategoryByIdName($id, $name))
		{
			return redirect('meisjejongetje/pages/blog/category')->with('message', (object)['type'=>'alert-warning', 'content'=>'The category name has already been taken.']);
		}

		$page->editBlogCategory($id, $name);
        return redirect('meisjejongetje/pages/blog/category')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully edited this blog.']);
	}
	public function deleteBlogCategory(Request $request)
	{
		$page = new Page;
		$id = $request->input('deleteId');
		if(count($page->getCategoryDetailBlogList($id)) != 0)
		{
			return redirect('meisjejongetje/pages/blog/category')->with('message', (object)['type'=>'alert-warning', 'content'=>'Warning: You cannot delete this category. The existing lists are using this category.']);
		}

		$page->deleteBlogCategoryById($id);
        return redirect('meisjejongetje/pages/blog/category')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully deleted this category.']);
	}
	public function blogList(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Website', 'path'=>''],
			(object)['name' =>'Blog', 'path'=>''],
			(object)['name' =>'List', 'path'=>'admin/pages/blog/list']
		];

		$page = new Page;
        return view('admin/website/blog/list/index', ['admin'=>$admin, 'lists'=>$page->getAllBlogList(), 'breadCrumb'=>$breadCrumb]);
	}
	public function addBlogList(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Website', 'path'=>''],
			(object)['name' =>'Blog', 'path'=>''],
			(object)['name' =>'List', 'path'=>'admin/pages/blog/list'],
			(object)['name' =>'Add List', 'path'=>'admin/pages/blog/addlist']
		];

		$page = new Page;
        return view('admin/website/blog/list/add', ['admin'=>$admin, "demors"=>$page->getAllBlogCategory(), 'breadCrumb'=>$breadCrumb]);
	}
	public function editBlogList(Request $request, $id)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Website', 'path'=>''],
			(object)['name' =>'Blog', 'path'=>''],
			(object)['name' =>'List', 'path'=>'admin/pages/blog/list'],
			(object)['name' =>'Edit List', 'path'=>'admin/pages/blog/editlist/'.$id]
		];

		$page = new Page;
        return view('admin/website/blog/list/edit', ['admin'=>$admin, "list"=>$page->getDetailBlogById($id), "demors"=>$page->getAllBlogCategory(), 'breadCrumb'=>$breadCrumb]);
	}
	public function submitBlogList(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$page = new Page;
		$destinationFile = "blogimage";
        $blogName = $request->input('blogName');
        $categoryId = $request->input('categoryId');
        $methods = $request->input('methods');

		if($blogName == '')
		{
			return redirect('meisjejongetje/pages/blog/addlist')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the list name field.']);
		}
		else if($methods == '')
		{
			return redirect('meisjejongetje/pages/blog/addlist')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the method field.']);
		}

		if($methods == 'select-image')
		{
			$imageStatic = $request->file('imageStatic');
			$urlImageStatic = $request->input('urlImageStatic');
			$subtitleImageStatic = $request->input('subtitleImageStatic');
			$imageStaticPath = [];

			if($imageStatic == null)
			{
				return redirect('meisjejongetje/pages/blog/addlist')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the image field.']);
			}
			else if($urlImageStatic == '')
			{
				return redirect('meisjejongetje/pages/blog/addlist')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the url field.']);
			}
			else if($subtitleImageStatic == '')
			{
				return redirect('meisjejongetje/pages/blog/addlist')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the subtitle field.']);
			}
			if ($imageStatic->isValid()) {
				$extension = $imageStatic->getClientOriginalExtension();
				$filename = rand(11111,99999).'.'.$extension;
				$imageStatic->move($destinationFile, $filename);
				array_push($imageStaticPath, $destinationFile."/".$filename);
			}
			$page->addBlogList($blogName, $categoryId, $methods, $urlImageStatic, $subtitleImageStatic, $imageStaticPath);
		}
		else if ($methods == 'select-slider')
		{
			$sliders = $request->file('slider');
			$urlSliders = $request->input('urlSlider');
			$subtitleSlider = $request->input('subtitleSlider');
			$imagePath = [];
			$urls = [];
			if($sliders == null)
			{
				return redirect('meisjejongetje/pages/blog/addlist')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the image field.']);
			}
			foreach($urlSliders as $index => $val)
			{
				if($index > 0 and $val == '')
				{
					return redirect('meisjejongetje/pages/blog/addlist')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the url field.']);
				}
			}

			if($subtitleSlider == '')
			{
				return redirect('meisjejongetje/pages/blog/addlist')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the subtitle field.']);
			}

			foreach($urlSliders as $index => $urlSlider)
			{
				if($index != 0)
					array_push($urls, $urlSlider);
			}
			foreach($sliders as $slider){
				if ($slider->isValid()) {
					$extension = $slider->getClientOriginalExtension();
					$filename = rand(11111,99999).'.'.$extension;
					$slider->move($destinationFile, "slider".$filename);
					array_push($imagePath, $destinationFile."/slider".$filename);
				}
			}
			$page->addBlogList($blogName, $categoryId, $methods, $urls, $subtitleSlider, $imagePath);
		}
		else if($methods == 'select-video')
		{
			$video = $request->file('video');
			$subtitleVideo = $request->input('subtitleVideo');
			$youtubePath = "";
			$videoPath = [];
			if($video == null and $request->input('youtube') == null)
			{
				return redirect('meisjejongetje/pages/blog/addlist')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the video field.']);
			}
			else if($subtitleVideo == '')
			{
				return redirect('meisjejongetje/pages/blog/addlist')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the subtitle field.']);
			}

			if(!empty($request->input('youtube'))){
				$youtubePath = substr($request->input('youtube'), 38, -77);
			}else{
				 if($video->isValid()) {
					$extension = $video->getClientOriginalExtension();
					$filename = rand(11111,99999).'.'.$extension;
					$video->move($destinationFile, "video".$filename);
					array_push($videoPath, $destinationFile."/video".$filename);
				}
			}
			$page->addBlogList($blogName, $categoryId, $methods, '', $subtitleVideo, $videoPath,$youtubePath);
		}
		return redirect('meisjejongetje/pages/blog/list')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully added this new blog.']);
	}
	public function submitEditBlogList(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$page = new Page;
		$destinationFile = "blogimage";
        $blogId = $request->input('blogId');
        $blogName = $request->input('blogName');
        $categoryId = $request->input('categoryId');
        $methods = $request->input('methods');
				$youtubePath = "";

		if($blogName == '')
		{
			return redirect('meisjejongetje/pages/blog/editlist/'.$blogId)->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the list name field.']);
		}
		else if($methods == '')
		{
			return redirect('meisjejongetje/pages/blog/editlist/'.$blogId)->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the method field.']);
		}

		if($methods == 'select-image')
		{
			$imageStatic = $request->file('imageStatic');
			$urlImageStatic = $request->input('urlImageStatic');
			$subtitleImageStatic = $request->input('subtitleImageStatic');
			$imageStaticPath = [];


			if($imageStatic != null){
				if ($imageStatic->isValid()) {
					$extension = $imageStatic->getClientOriginalExtension();
					$filename = rand(11111,99999).'.'.$extension;
					$imageStatic->move($destinationFile, $filename);
					array_push($imageStaticPath, $destinationFile."/".$filename);
				}
			}
			$page->editBlogList($blogId, $blogName, $categoryId, $methods, $urlImageStatic, $subtitleImageStatic, $imageStaticPath);
		}
		else if ($methods == 'select-slider')
		{

			$sliders = (!empty($request->file('slider')) ? $request->file('slider') : [] );
			$editslider = $request->input('editslider');
			$urlSliders = $request->input('urlSlider');
			$subtitleSlider = $request->input('subtitleSlider');
			$imagePath = [];
			$urls = [];
			foreach($urlSliders as $index => $urlSlider)
			{
				if($index != 0){
					if($urlSlider == "")
						return redirect('meisjejongetje/pages/blog/editlist/'.$blogId)->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the url list.']);

					array_push($urls, $urlSlider);
				}
			}
			foreach($editslider as $eslider)
			{
				array_push($imagePath, $eslider);
			}
			foreach($sliders as $slider){
				if ($slider->isValid()) {
					$extension = $slider->getClientOriginalExtension();
					$filename = rand(11111,99999).'.'.$extension;
					$slider->move($destinationFile, "slider".$filename);
					array_push($imagePath, $destinationFile."/slider".$filename);
				}
			}
			$page->editBlogList($blogId, $blogName, $categoryId, $methods, $urls, $subtitleSlider, $imagePath);
		}
		else if($methods == 'select-video')
		{
			$video = $request->file('video');
			$subtitleVideo = $request->input('subtitleVideo');
			$videoPath = [];
			if($video != null){
					$extension = $video->getClientOriginalExtension();
					$filename = rand(11111,99999).'.'.$extension;
					$video->move($destinationFile, "video".$filename);
					array_push($videoPath, $destinationFile."/video".$filename);
			}

			if(!empty($request->input('youtube'))){
				//$page->deleteVideoById($blogId);
				//2018-11-23
				//update dari -77 ke -123 $youtubePath = substr($request->input('youtube'), 38, -77);
				$youtubePath = substr($request->input('youtube'), 38, -123);
			}
			$page->editBlogList($blogId, $blogName, $categoryId, $methods, '', $subtitleVideo, $videoPath, $youtubePath);
		}
		return redirect('meisjejongetje/pages/blog/list')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully edited this blog.']);
	}
	public function deleteBlogList(Request $request)
	{
		$page = new Page;
		$id = $request->input('deleteId');
		$page->deleteListById($id);

        return redirect('meisjejongetje/pages/blog/list')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully deleted this blog.']);
	}

	public function newsletter(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Website', 'path'=>''],
			(object)['name' =>'Newsletter', 'path'=>'admin/pages/newsletter']
		];

		$page = new Page;
		//return view('admin/website/newsletter/index', ['admin'=>$admin, 'newsletters'=>$page->getAllNewsLetter(), 'breadCrumb'=>$breadCrumb]);
		//rian
		$p = new Product;
		return view('admin/website/newsletter/index', [
				'admin'=>$admin, 'newsletters'=>$page->getAllNewsLetter(), 'breadCrumb'=>$breadCrumb, 'products'=>$p->getAllProductOrderByName()
			]);
		//end rian

	}

	//rian
	public function sendnewsletter(Request $request)
	{
		$this->validate($request,[
			'campaign_name'=> 'required'
			,'template'    => 'required'
		]);


		$pageImage=""; $products=array(); $to=array();
		if($request->file('upload_image') != null)
		{
			if ($request->file('upload_image')->isValid()) {
				$destinationFile = "productimage";
				$extension = $request->file('upload_image')->getClientOriginalExtension();
				$filename = rand(11111,99999).'.'.$extension;
				$request->file('upload_image')->move($destinationFile, $filename);
				$pageImage = $destinationFile."/".$filename;
			}
		}

		$pr = new Product;
		if(empty($request->input('show-product')))
		{
			foreach($request->input('product') as $product_id)
			{
				$products[]=$pr->getProductById2($product_id);
			}
		}
		//to all newsletter
		
		if($request->input('to') == 1){
			$p = new Page;
			$subscribers=$p->getAllNewsLetter();
			foreach($subscribers as $subscribe){
				Mail::to($subscribe->email)->send(new EmailNewsletter($request->input('campaign_name'),$request->input('template'),$products,$pageImage));
				//Mail::to('rian.dilenium@gmail.com')->send(new EmailNewsletter($request->input('campaign_name'),$request->input('template'),$products,$pageImage));
			}
		}
		
		//to preview testing
		if($request->input('to') == 2){
			$o = new Order;
			$emails=$o->getMemberEmail();
			Mail::to('cs@demorboutique.com')->send(new EmailNewsletter($request->input('campaign_name'),$request->input('template'),$products,$pageImage));
		}

		if($request->input('to') == 3){
			$o = new Order;
			$emails=$o->getMemberEmail();
			Mail::to('anthony_tonz@ymail.com')->send(new EmailNewsletter($request->input('campaign_name'),$request->input('template'),$products,$pageImage));
		}

		return redirect()->back()->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully sent the newsletter.']);
	}
	//endrian

	public function deleteNewsletter(Request $request)
	{
		$page = new Page;
		$id = $request->input('deleteId');
		$page->deleteNewsletterByEmail($id);

        return redirect('meisjejongetje/pages/newsletter')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully deleted a subscriber.']);


	}
}
