<?php

namespace App\Http\Models;
use DB;

class Page
{
	public function getAllPages()
	{
		return DB::select('select * from pages');
	}
	public function getPagesById($id)
	{
		return DB::select('select * from pages where pagesid = ?', [$id]);
	}
	public function submitPages($pageId, $pageText, $pageImage, $pageVideo, $showImage, $showVideo)
	{
		if($pageImage != null){
			DB::update('update pages set pagesimage = ? where pagesid = ?', [$pageImage, $pageId]);
		}

		if($pageVideo != null){
			DB::update('update pages set pagesvideo = ? where pagesid = ?', [$pageVideo, $pageId]);
		}

		DB::update('update pages set pagestext = ?, showimage = ?, showvideo = ? where pagesid = ?', [$pageText, $showImage, $showVideo, $pageId]);
	}

	public function getContact()
	{
		return DB::select('select * from pages_contact limit 0, 1');
	}
	/*20170616 Rian : popup*/
	public function getPopup()
	{
		return DB::select('select * from popup limit 0, 1');
	}

	public function updatePopup($method,$link,$image,$message,$start_popup,$end_popup)
	{
		//dd(date("Y-m-d",strtotime($end_popup)),$end_popup);
		DB::update('update popup set popup_type = ?, link_path = ?, image_path = ?, message = ?, start_popup = ?, end_popup = ?', [$method,$link,$image,$message,$start_popup,$end_popup]);
	}

	public function getCurrency()
	{
		return DB::select('select * from currencies
		order by is_active desc, id asc');
	}
	public function getActiveCurrency()
	{
		return DB::select('select * from currencies where is_active = 1 order by id asc');
	}
	public function updateCurrency($items)
	{
		DB::update("update currencies set is_active = 0");
		foreach ($items as $key => $value) {
			$id[]=$key;
		}
		$sql = "update currencies set is_active = 1 where id in ( ";
		$x=0;
		foreach($id as $y){
			if($x > 0){ $sql.=","; }
			$sql.="?";
			$x++;
		}
		$sql.=" )";
		DB::update($sql, $id);
	}
	/*End Rian*/
	public function submitContact($hoursOfOperation, $phoneNumber, $mobileNumbser, $email, $maps, $address)
	{
		DB::update('update pages_contact set operation = ?, phonenumber = ?, mobilenumber = ?, email = ?, maps = ?, address = ?', [$hoursOfOperation, $phoneNumber, $mobileNumbser, $email, $maps, $address]);
	}
	public function getAllMessages()
	{
		return DB::select('select * from pages_message order by messageid desc');
	}
	public function addMessages($name, $email, $subject, $messages)
	{
		DB::insert('insert into pages_message(name, email, subject, message) values(?, ?, ?, ?)', [$name, $email, $subject, $messages]);
	}
	public function deleteMessageById($id)
	{
		DB::delete('delete from pages_message where messageid = ?', [$id]);
	}

	public function getCareer()
	{
		return DB::select('select * from pages_career limit 0, 1');
	}
	public function getAllDetailCareer()
	{
		return DB::select('select * from pages_career_detail');
	}
	public function getDetailPublishCareer()
	{
		return DB::select('select * from pages_career_detail where ispublish = 1');
	}
	public function getDetailCareer($id)
	{
		return DB::select('select * from pages_career_detail where careerid = ?', [$id]);
	}
	public function getDetailCareerByIdName($id, $name)
	{
		return DB::select('select * from pages_career_detail where careerid != ? and careertitle = ?', [$id, $name]);
	}
	public function deleteCareerById($id)
	{
		return DB::delete('delete from pages_career_detail where careerid = ?', [$id]);
	}
	public function postCareer($email, $paragraph)
	{
		DB::update('update pages_career set email = ?, careercontent = ?', [$email, $paragraph]);
	}
	public function submitCareer($careerId, $careerTitle, $careerContent, $isPublish)
	{
		if($careerId == null)
		{
			DB::insert('insert into pages_career_detail(careertitle, careercontent, ispublish, careerdate) values(?, ?, ?, now())', [$careerTitle, $careerContent, $isPublish]);
		}
		else
		{
			DB::update('update pages_career_detail set careertitle = ?, careercontent = ?, ispublish = ? where careerid = ?', [$careerTitle, $careerContent, $isPublish, $careerId]);
		}
	}

	public function getAllSlider()
	{
		return DB::select('select * from pages_slider');
	}
	public function getAllActiveSlider()
	{
		return DB::select('select * from pages_slider where ispublish = 1');
	}
	public function addSlider($path, $extension, $isPublish)
	{
		DB::insert('insert into pages_slider(sliderpath, imagetype, uploaddate, ispublish) values(?, ?, NOW(), ?)', [$path, $extension, $isPublish]);
	}
	public function editSlider($id, $isPublish)
	{
		DB::update('update pages_slider set ispublish = ? where sliderid = ?', [$isPublish, $id]);
	}
	public function deleteSliderById($id)
	{
		DB::delete('delete from pages_slider where sliderid = ?', [$id]);
	}

	public function getFooter()
	{
		return DB::select('select * from pages_footer limit 0, 1');
	}
	public function submitFooter($type, $paymentMethod, $copyright, $facebook, $instagram, $pinterest)
	{
		if($type == 0)
			DB::update('update pages_footer set payment = ?, copyright = ?', [$paymentMethod, $copyright]);
		else if($type == 1)
			DB::update('update pages_footer set socialfacebook = ?, socialinstagram = ?, socialpinterest = ?', [$facebook, $instagram, $pinterest]);
	}

	public function getAllBlogCategory()
	{
		return DB::select('select * from blog_category');
	}
	public function getBlogCategoryById($id)
	{
		return DB::select('select * from blog_category where categoryid = ?', [$id]);
	}
	public function getBlogCategoryByIdName($id, $name)
	{
		return DB::select('select * from blog_category where categoryid != ? and categoryname = ?', [$id, $name]);
	}
	public function addBlogCategory($name)
	{
		return DB::insert('insert into blog_category(categoryname) values (?)', [$name]);
	}
	public function editBlogCategory($id, $name)
	{
		return DB::update('update blog_category set categoryname = ? where categoryid = ?', [$name, $id]);
	}
	public function deleteBlogCategoryById($id)
	{
		return DB::delete('delete from blog_category where categoryid = ?', [$id]);
	}
	public function getAllBlogList()
	{
		return DB::select('select blogid, name, categoryname from blog_list a join blog_category b on a.categoryid = b.categoryid order by blogid desc');
	}
	public function getAllDetailBlogList()
	{
		return DB::select('select a.blogid, name, method, description, urlpath, filepath
							from blog_list a join blog_list_image b on a.blogid = b.listid
							and filepath = (select filepath from blog_list_image where listid = a.blogid limit 1)');
	}
	public function getCategoryDetailBlogList($id)
	{
		return DB::select('select a.blogid, name, method, description, urlpath, filepath
							from blog_list a join blog_list_image b on a.blogid = b.listid
							and filepath = (select filepath from blog_list_image where listid = a.blogid limit 1)
							where a.categoryid = ?', [$id]);
	}
	public function getDetailBlogById($id)
	{
		$blog = DB::select('select blogid, categoryid, name, method, description, null as images from blog_list where blogid = ?', [$id])[0];
		$blog->images = DB::select('select * from blog_list_image where listid = ?', [$id]);

		return $blog;
	}
	public function getDetailBlogListById($id)
	{
		return DB::select('select * from blog_list_image where listid = ?', [$id]);
	}
	public function addBlogList($blogName, $categoryId, $methods, $url, $subtitle, $image)
	{
		DB::insert('insert into blog_list(name, categoryid, method, description, createddate) values(?, ?, ?, ?, now())',
					[$blogName, $categoryId, $methods, $subtitle]);
		$id = DB::select('select * from blog_list order by blogid desc limit 0, 1')[0]->blogid;
		for($i = 0; $i < count($image); $i++){
			$tempUrl = "";
			if(is_array($url))
				$tempUrl = $url[$i];
			else
				$tempUrl = $url;
			DB::insert('insert into blog_list_image values(?, ?, ?)', [$id, $image[$i], $tempUrl]);
		}
	}
	public function editBlogList($blogId, $blogName, $categoryId, $methods, $url, $subtitle, $image)
	{
		DB::insert('update blog_list set name = ?, categoryid = ?, method = ?, description = ? where blogid = ?',
					[$blogName, $categoryId, $methods, $subtitle, $blogId]);
		if(count($image) != 0){
			DB::delete('delete from blog_list_image where listid = ?', [$blogId]);
			for($i = 0; $i < count($image); $i++){
				$tempUrl = "";
				if(is_array($url))
					$tempUrl = $url[$i];
				else
					$tempUrl = $url;
				DB::insert('insert into blog_list_image values(?, ?, ?)', [$blogId, $image[$i], $tempUrl]);
			}
		}
		else{
			DB::update('update blog_list_image set urlpath = ? where listid = ?', [$url, $blogId]);
		}
	}

	public function deleteListById($blogId)
	{
		DB::delete('delete from blog_list where blogid = ?', [$blogId]);
		DB::delete('delete from blog_list_image where listid =  ?', [$blogId]);
	}

	public function getPageHeader()
	{
		return DB::select('select * from pages_header');
	}
	public function submitHeader($type, $title, $keyword, $description, $googleWebMaster, $googleAnalytic, $logo, $favicon)
	{
		if($type == 0)
		{
			if($logo != null)
				DB::update('update pages_header set logo = ?', [$logo]);
			if($favicon != null)
				DB::update('update pages_header set favicon = ?', [$favicon]);

			DB::update('update pages_header set title = ?, metakeyword = ?, metadescription = ?', [$title, $keyword, $description]);
		}
		if($type == 1)
			DB::update('update pages_header set googlewebmaster = ?, googleanalytic = ?', [$googleWebMaster, $googleAnalytic]);
	}

	public function getAllNewsLetter()
	{
		return DB::select('select * from subscribe order by date desc');
	}
	public function getNewsLetterEmail($email)
	{
		return DB::select('select email from subscribe where email = ?', [$email]);
	}
	public function insertNewsLetterEmail($email)
	{
		DB::insert('insert into subscribe values(?, ? , ?)', [$email, 1, date("Y-m-d")]);
	}
	public function deleteNewsletterByEmail($email)
	{
		DB::delete('delete from subscribe where email = ?', [$email]);
	}
	public function submitExchange($fullName, $emailAddress, $invoiceNumber, $productName, $detailProduct, $reason)
	{
		DB::insert('insert into product_exchange(fullname, email, ordernumber, productname, detailproduct, reason, exchangedate) values(?, ?, ?, ?, ?, ?, now())',
					[$fullName, $emailAddress, $invoiceNumber, $productName, $detailProduct, $reason]);
	}
}
