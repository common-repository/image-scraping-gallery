<?php
/*
  Plugin Name: Vijay Web's Images Scraping & Gallery Plugin
  Plugin URI: http://www.vijaywebsolutions.com
  Description: Plugin made for serching images from google and user can use those image in gallery
  Version: 1.0.1
  Author: Vijay Web Solutions 
 */
add_action('media_buttons_context', 'vws_isg_buttons');
add_action('admin_footer', 'vws_isg_popup_content');
function vws_enqueue($hook) {
    if (('edit.php' != $hook) && ('post-new.php' != $hook) && ('post.php' != $hook))
        return;
    wp_enqueue_script('vwsgallary', plugin_dir_url(__FILE__) . '/js/jquery.vwsgallary.js', array('jquery'));
	wp_enqueue_script('vwsgallary', plugin_dir_url(__FILE__) . '/js/jquery.vwsgallary.js', array('jquery'));
	wp_enqueue_script('vwsgallary', plugin_dir_url(__FILE__) . '/js/jquery.vwsgallary.js', array('jquery'));
    wp_enqueue_style('vwsgallary', plugins_url('css/vwsgallary.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'vws_enqueue');
function vws_isg_buttons($context) {
    $context = '<a href="#vgis_popup" id="vgis-btn" class="button add_media" title="Google Image"><span class="wp-media-buttons-icon"></span> Search Images on Google</a><input type="hidden" id="vgis_featured_url" name="vgis_featured_url" value="" />';
    return $context;
}
function vws_isg_popup_content() {?>
       <div style='display:none'>
        <div id="vgis_popup" style="width: 640px; height: 600px; padding: 10px; overflow: hidden"><span style="float:left; margin-right: 10px;">Fliter Your Search</span>
            <select name="vgisimgsz" id="vgisimgsz" style="float:left">
                <option value="">All size</option>
                <option value="icon">Icon</option>
                <option value="small">Small</option>
                <option value="medium">medium</option>
                <option value="large">large</option>
                <option value="xlarge" style="display:none;">xlarge</option>
                <option value="xxlarge" style="display:none;">xxlarge</option>
                <option value="huge" style="display:none;">huge</option>
            </select>
            <select name="vgisimgtype" id="vgisimgtype" style="float:left">
                <option value="">All type</option>
                <option value="face">face</option>
                <option value="photo">photo</option>
                <option value="clipart">clipart</option>
                <option value="lineart">lineart</option>
            </select>
            <select name="vgisfiletype" id="vgisfiletype" style="float:left">
                <option value="">All file type</option>
                <option value="jpg">jpg</option>
                <option value="png">png</option>
                <option value="gif">gif</option>
                <option value="bmp">bmp</option>
            </select> 
            <select name="vgisimgc" id="vgisimgc" style="float:left;display: none;">
                <option value="">Colorization</option>
                <option value="gray">gray</option>
                <option value="color">color</option>
            </select> 
            <select name="vgisimgcolor" id="vgisimgcolor" style="float:left">
                <option value="">All color</option>
                <option value="black">black</option>
                <option value="blue">blue</option>
                <option value="brown">brown</option>
                <option value="gray">gray</option>
                <option value="green">green</option>
                <option value="orange">orange</option>
                <option value="pink">pink</option>
                <option value="purple">purple</option>
                <option value="red">red</option>
                <option value="teal">teal</option>
                <option value="white">white</option>
                <option value="yellow">yellow</option>
            </select> 
            <select name="vgissafe" id="vgissafe" style="float:left;display: none;">
                <option value="">Safe search</option>
                <option value="active">active</option>
                <option value="moderate">moderate</option>
                <option value="off">off</option>
            </select> <input type="hidden" value="<?php echo plugin_dir_url( __FILE__ );?>get_gallery.php" id="urls"> 
            <input type="hidden" value="<?php echo get_home_path();?>" id="site_urls"><input type="hidden" value="<?php echo  get_the_ID();?>" id="post_id">
            <div style="width:98%; display: inline-block; margin-top: 5px; height:28px; line-height: 28px;"><span style="float:left; margin-right: 10px;"><input name="vgiscc" id="vgiscc" type="checkbox" style="display:none;"/> Search Your Image</span> <input type="text" id="vgisinput" name="vgisinput" value="" size="30"/> <input type="button" id="vgissearch" class="button" value="Search"/> <span id="vgisspinner" style="display:none" class="vgis-loading"> </span></div>
            <div id="vgis-container" class="vgis-container" ><br/><br/><?php echo '<img src="' . plugins_url( 'images/Warning.png' , __FILE__ ) . '" style="float: left;width: 25px;margin-right: 4px;"> ';?> All images from Google (http://www.google.com/images)and they have reserved rights.</div>
            <div id="vgis-page" class="vgis-page"></div>
            <div id="vgis-use-image" class="vgis-use-image">
                <div class="vgis-item" id="vgis-view" style="margin-right: 20px;"></div>
                </div>
            </div>
    </div>
    <script>
        function insertAtCaret(areaId, text) {
            var txtarea = document.getElementById(areaId);
            var scrollPos = txtarea.scrollTop;
            var strPos = 0;
            var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ? "ff" : (document.selection ? "ie" : false));
            if (br == "ie") {
                txtarea.focus();
                var range = document.selection.createRange();
                range.moveStart('character', -txtarea.value.length);
                strPos = range.text.length;
            }else if (br == "ff")
                strPos = txtarea.selectionStart;
				var front = (txtarea.value).substring(0, strPos);
				var back = (txtarea.value).substring(strPos, txtarea.value.length);
            txtarea.value = front + text + back;
            strPos = strPos + text.length;
            if (br == "ie") {
                txtarea.focus();
                var range = document.selection.createRange();
                range.moveStart('character', -txtarea.value.length);
                range.moveStart('character', strPos);
                range.moveEnd('character', 0);
                range.select();
            }else if (br == "ff") {
                txtarea.selectionStart = strPos;
                txtarea.selectionEnd = strPos;
                txtarea.focus();
            }
			txtarea.scrollTop = scrollPos;
        }
        jQuery("#vgissearch").click(function() {
            vShowImages(0);
        });
        jQuery("#vgis-btn").colorbox({inline: true, width: "670px"});
        jQuery("#vgis-page a").live("click", function() {
            vShowImages(jQuery(this).attr("rel") - 1);
        });
        jQuery("#vgisinsert").live("click", function() {
            if(jQuery('#vgis-url').val() != '') {
                vinsert = '<img src="'+jQuery('#vgis-url').val()+'" width="'+jQuery('#vgis-width').val()+'" height="'+jQuery('#vgis-height').val()+'" title="'+jQuery('#vgis-title').val()+'" alt="'+jQuery('#vgis-title').val()+'"/>';
                if (!tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
                    insertAtCaret('content', vinsert);
                } else {
                    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, vinsert);
                }
                jQuery.colorbox.close();
            } else {
                alert('Have an error! Please try again!');
            }
        });
        jQuery("#vgisfeatured").live("click", function() {
            vffurl = jQuery('#vgis-url').val();
            jQuery('#vgis_featured_url').val(vffurl);
            jQuery('#postimagediv div.inside img').remove();
            jQuery('#postimagediv div.inside').prepend('<img src="'+vffurl+'" width="270"/>');
            jQuery.colorbox.close();
        });
        jQuery("#remove-post-thumbnail").live("click", function() {
            jQuery('#vgis_featured_url').val('');
        });
        jQuery(".vgis-item-use").live("click", function() {
            jQuery("#vgis-use-image").show();
            jQuery('#vgis-title').val(jQuery(this).attr('vgistitle'));
            jQuery('#vgis-width').val(jQuery(this).attr('vgiswidth'));
            jQuery('#vgis-height').val(jQuery(this).attr('vgisheight'));
            jQuery('#vgis-url').val(jQuery(this).attr('vgisurl'));
            jQuery('#vgis-view').html('<img src="' + jQuery(this).attr('vgistburl') + '"/>');
        });
        function vShowImages(page) {
            if(jQuery("#vgisinput").val() == '') {
                alert('Please enter keyword to search!');
            } else {
                jQuery('#vgisspinner').show();
                jQuery('#vgis-container').html("");
                vstart = page * 8;
                vcc = '';
                if (jQuery('#vgiscc').is(':checked')) {
                    vcc = 'cc_attribute';
                }
				vurl = "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&rsz=8&restrict=" + vcc + "&start=" + vstart + "&as_filetype=" + jQuery("#vgisfiletype").val() + "&imgtype=" + jQuery("#vgisimgtype").val() + "&imgsz=" + jQuery("#vgisimgsz").val() + "&imgc=" + jQuery("#vgisimgc").val() + "&safe=" + jQuery("#vgissafe").val() + "&imgcolor=" + jQuery("#vgisimgcolor").val() + "&q=" + jQuery("#vgisinput").val();
                jQuery.ajax({
                    url: vurl,
                    dataType: "jsonp",
                    success: function(data) {
                        if(data.responseDetails === null) {
                            jQuery('#vgisspinner').hide();
                            for (var i = 0; i < data.responseData.results.length; i++) {
                                jQuery('#vgis-container').append('<div class="vgis-item"><div class="vgis-item-link"><a href="' + data.responseData.results[i].url + '" target="_blank" title="View this image in new windows">View</a><input type="checkbox" name="inserted[]" class="vgis-item-use1" value="' + data.responseData.results[i].url + '"  vgistitle="' + data.responseData.results[i].titleNoFormatting + '" vgiswidth="' + data.responseData.results[i].width + '" vgisheight="' + data.responseData.results[i].height + '" href="#"  style="float: left;margin-top: -48px;"></div><div class="vgis-item-overlay"></div><img src="' + data.responseData.results[i].tbUrl + '"><span>' + data.responseData.results[i].width + ' x ' + data.responseData.results[i].height + '</span></div> ');
                            };
                            jQuery('#vgis-container').append('Please select columns for Gallary <select name="columns_number" id="columns_number" style="margin:45px;"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option></select><input type="button" value="Add to gallery" onclick="addtogal()"><span id="vgisspinner1" style="display:none" class="vgis-loading"> </span>');
                            var vpages = "Pages: ";
                            for (var j = 1; j < data.responseData.cursor.pages.length + 1; j++) {
                                vpages += '<a href="#" rel="' + j + '" title="Page ' + j + '">' + j + '</a> ';
                            };
							jQuery('#vgis-container').append('<span id="gallery_shortcoe"></span>');
                            jQuery('#vgis-page').html(vpages);
                        } else {
                            jQuery('#vgisspinner').hide();
                            jQuery('#vgis-container').html('No result! Please try again!');
                            jQuery('#vgis-page').html('');
                        }
                    }
                });
            }
        }
		function addtogal()
		{
			jQuery('#vgisspinner1').show();
			var checkedValue = null; 
			var inputElements = document.getElementsByClassName('vgis-item-use1');
			var columns_numbers = document.getElementById('columns_number');
			var columns_number=columns_numbers.value;
			var urls1 = document.getElementById('urls');
			var urls=urls1.value;
			var sit_urls1 = document.getElementById('site_urls');
			var sit_urls=sit_urls1.value;
			var post_id1 = document.getElementById('post_id');
			var post_id=post_id1.value;
			var selected = new Array();
			for(var i=0; inputElements[i]; ++i){
      				if(inputElements[i].checked){
           			selected.push(inputElements[i].value);
      			}
			}
			  var jsonString = JSON.stringify(selected);
			jQuery.ajax({ 
			url:urls, 
			type: "post",
			data:{"data":jsonString,"sit_urls":sit_urls,"post_id":post_id,"columns_number":columns_number},
			success:function(data){ 			
			jQuery('#vgisspinner1').hide();
			 if(data != '') {
                vinsert = data;
                if (!tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
                    insertAtCaret('content', vinsert);
                } else {
                    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, vinsert);
                }
                jQuery.colorbox.close();
            } else {
                alert('Have an error! Please try again!');
            }
				} 
			});
		}
    </script>
    <?php }?>