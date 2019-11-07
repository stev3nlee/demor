$(function() {
	
	$('.full-height').height($(window).height());
	
	$('.fancybox').fancybox();
	
	$(document).keyup(function(e) {
		if (e.keyCode == 27) {
			$.fancybox.close();
		}
	});
	
	$('.btn-cancel').click(function(event) {	
        $.fancybox.close();
    });
	
	$('.btn-hide').click(function(event) {	
        $.fancybox.close();
        $('.hide-correct').hide();
        $('.show-incorrect').show();
        $('.p-show').show();
        $('.p-hide').hide();
    });

	$('.btn-show').click(function(event) {	
        $.fancybox.close();
        $('.hide-correct').show();
        $('.show-incorrect').hide();
        $('.p-show').hide();
        $('.p-hide').show();
    });		
	
	$('.click-box').click(function(event) {	
        $('.open-box').addClass('animate-open');
    });
	
	
	$('.click-box2').click(function(event) {	
        $('.open-box2').addClass('animate-open');
    });
	
	$('.close-box').click(function(event) {	
        $('.open-box').removeClass('animate-open');
        $('.open-box2').removeClass('animate-open');
    });
	
	$("div#myId").dropzone({ url: "/file/post" });
	
	$('.time1').timepicker({ 'step': 15 });
	$('.time2').timepicker({
		'step': function(i) {
			return (i%2) ? 15 : 45;
		}
	});
	
	$('.start-date').datetimepicker({	
		timepicker:false,
		format:'d/m/Y',
		formatDate:'d.m.Y',
		minDate:'-1970/01/01',//yesterday is minimum date(for today use 0 or -1970/01/01)
		scrollInput:false,
		onShow:function( ct ){
		this.setOptions({
		maxDate:jQuery('.expired-date').val()?jQuery('.expired-date').val():false
		})
		},
		onSelectDate:function( ct, $i ){
			d = ct.getDay();
			$('.checkbox-calender input').prop('checked', false);
			$('.checkbox-calender input[name="days[' + d + ']"]').prop('checked', true);
		}
	});
	
	$('.expired-date').datetimepicker({	
		timepicker:false,
		format:'d/m/Y',
		formatDate:'d.m.Y',
		scrollInput:false,
		onShow:function( ct ){
		this.setOptions({
		minDate:jQuery('.start-date').val()?jQuery('.start-date').val():false
		})
		},
		onSelectDate:function( ct, $i ){
			d = ct.getDay();
			$('.checkbox-calender input').prop('checked', false);
			$('.checkbox-calender input[name="days[' + d + ']"]').prop('checked', true);
		}
	});
	
	$(".txtboxToFilter").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});
	
	$('.btn-size').click(function(event) {	
        $('.show-size').show();
        $('.size1').hide();
    });
	
	$('.close-size').click(function(event) {	
        $('.show-size').hide();
		$('.size1').show();
    });
	
	$('.btn.order1').click(function(event) {	
        $('.show1').show();
        $('.show2').show();
        $('.btn.order1').hide();
        $('.hide1').hide();
        $('.waiting').hide();
    });
	
	$('.btn.order2').click(function(event) {	
        $('.show3').show();
        $('.show2').hide();
		$.fancybox.close();
    });
	
	 $(".tabs-menu a").click(function(event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".tab-content").not(tab).css("display", "none");
        $(tab).fadeIn();
    });
	
	var colpick = $('.demo').each( function() {
		$(this).minicolors({
		control: $(this).attr('data-control') || 'hue',
		inline: $(this).attr('data-inline') === 'true',
		letterCase: 'lowercase',
		opacity: false,
		change: function(hex, opacity) {
		if(!hex) return;
		if(opacity) hex += ', ' + opacity;
		try {
		console.log(hex);
		} catch(e) {}
		$(this).select();
		},
		theme: 'bootstrap'
		});
	});
	
	$('#table_id').DataTable({
		buttons: [{
			extend: 'pdf',
			text: 'Save current page',
			exportOptions: {
				modifier: {
					page: 'current'
				}
			}
		}]
	});
	//datatable2 = $('#table_id2').DataTable();
	
	var Accordion = function(el, multiple) {
		this.el = el || {};
		this.multiple = multiple || false;

		var links = this.el.find('.link');

		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
	}

	Accordion.prototype.dropdown = function(e) {
		var $el = e.data.el;
			$this = $(this),
			$next = $this.next();

		$next.slideToggle();
		$this.parent().toggleClass('open');

		if (!e.data.multiple) {
			$el.find('.submenu').not($next).slideUp().parent().removeClass('open');
		};
	}	

	var accordion = new Accordion($('#accordion'), false); 
	
	$('ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('active-current');
		$('.tab-news').removeClass('active-current');

		$(this).addClass('active-current');
		$("#"+tab_id).addClass('active-current');
	});
		
	tinymce.init({   
        selector: "textarea#mceEdit", 
        theme: "modern", 
        width: 680, 
        height: 300, 
        subfolder:"", 
        plugins: [ 
        "advlist autolink link image lists charmap print preview hr anchor pagebreak", 
        "searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking", 
        "table contextmenu directionality emoticons paste textcolor filemanager" 
        ], 
        image_advtab: true, 
        toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect forecolor backcolor | link unlink anchor | image media | print preview code" 
    }); 
	
	// custom 
	tinymce.init({   
        selector: "textarea#mceCustom", 
        theme: "modern", 
        width: 400, 
        height: 150, 
        subfolder:"", 
        plugins: [ 
        "image", 
        "", 
        "" 
        ], 
        image_advtab: true, 
        toolbar: "image media" 
    }); 

	//no feature
	tinymce.init({   
        selector: "textarea#mceFixed",
        theme: "modern", 
        width: 400, 
        height: 150, 
        subfolder:"", 
        image_advtab: true
    }); 
	
	//no feature 2
	tinymce.init({   
        selector: "textarea#mceFixed2",
        theme: "modern", 
        width: 400, 
        height: 150, 
        subfolder:"", 
        image_advtab: true
    }); 
	
});
$(document).ready(function() {
	//this is for popup
	$( "#popupLink" ).trigger( "click" );
});
function custom_select(e) {
	el = $(e);
	if (el.find('option:selected') != 0) {
		text = el.find('option:selected').text();
	} else {
		text = el.siblings('.replacement').attr('data-text');
	}
	el.siblings('.replacement').html(text);
}
