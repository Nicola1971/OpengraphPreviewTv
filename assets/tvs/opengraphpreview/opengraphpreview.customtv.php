<?php
/*
 OpanGraphPreviewTV — custom TV for SEo4Evo
 Version 16.01.18 by Nicola Lambathakis, http://www.tattoocms.it
*/

if (IN_MANAGER_MODE != 'true') {
 die('<h1>Error:</h1><p>Please use the MODx content manager instead of accessing this file directly.</p>');
}
// get global language
global $modx,$_lang;
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$value = empty($row['value']) ? $row['default_text'] : $row['value'];
$rid = $row['id'];
$site_name = $modx->config['site_name'];
$site_url = $modx->config['site_url'];

//remove http
$siteurl = parse_url($site_url);  
$domain_url = $siteurl['host'];


// Manual configuration of Seo4Evo params
$MetaDescriptionTv = isset($MetaDescriptionTv) ? $MetaDescriptionTv : 'MetaDescription';
//$preTitle = "$site_name | ";
$postTitle = " | $site_name";
//set tv image name
$imageTV = isset($imageTV) ? $imageTV : 'Thumbnail';

//get image tv
$image = $modx->getTemplateVarOutput($imageTV,$id);
$Fb_image = $image[$imageTV];
$imageurl = "../$Fb_image";
$Fullimageurl = "$site_url$Fb_image";
//Get the title
$pagetitle = $modx->documentObject['pagetitle'];
$CTitle = $modx->getTemplateVarOutput('CustomTitle',$id);
$Custom = $CTitle['CustomTitle'];
//check custoom title tv
if(!$Custom == ""){
$MetaTitle = "$preTitle$Custom$postTitle";
} else {
      $MetaTitle = "$preTitle$pagetitle$postTitle";
   }
$max_length = '70';
if (strlen($MetaTitle) > $max_length) {
$Title = substr($MetaTitle, 0, $max_length);
}
else {$Title = $MetaTitle;}

// Get Meta Description ***
$dyndesc = $modx->runSnippet(
        "DynamicDescription",
        array(
            "descriptionTV" => $MetaDescriptionTv,
			"maxWordCount=" => "25"
        )
);
//Get the url
$url = $modx->makeUrl($id, '', '', 'full');
//output Preview Tv
$output .="
<link href=\"../assets/tvs/opengraphpreview/css/fbpreview.css\" rel=\"stylesheet\">
<div>
<input type='text' style=\"display:none;\"  id=\"tv$rid\" name=\"tv$rid\" value=\"tv$rid\" />
<div class=\"facebook-inner\">
<div class=\"facebook-image\"> <div class=\"bg-image\" style=\"background-image:url('$imageurl');\"></div></div>
<div class=\"facebook-inner-text\">
  <span class=\"facebook-title\">$Title</span>
  <span class=\"facebook-desc\">$dyndesc.</span>
  <span class=\"facebook-url\">$domain_url</span> 
  </div>
</div>
<div class=\"share-buttons\">
<ul class=\"list-unstyled list-inline\">
<li><a class=\"btn btn-social btn-facebook\" title=\"Share with Facebook\" target=\"_blank\" rel=\"nofollow\" href=\"https://www.facebook.com/sharer/sharer.php?u=$url\"><i class=\"fa fa-facebook fa-2x\"></i></a></li>

<li><a class=\"btn btn-social btn-twitter\" title=\"Share with Twitter\" target=\"_blank\" rel=\"nofollow\" href=\"https://twitter.com/intent/tweet?text=$Custom&amp;url=$url\"><i class=\"fa fa-twitter fa-2x\"></i></a></li>

<li><a class=\"btn btn-social btn-google-plus\" title=\"Share with Google plus\" target=\"_blank\" rel=\"nofollow\" href=\"https://plus.google.com/share?url=$url\"><i class=\"fa fa-google-plus fa-2x\"></i></a></li>

<li><a class=\"btn btn-social btn-linkedin\" title=\"Share with Linkedin\" target=\"_blank\" rel=\"nofollow\" href=\"http://www.linkedin.com/shareArticle?url=$url&title=$Custom\"><i class=\"fa fa-linkedin fa-2x\"></i></a></li>

<li><a class=\"hvr-float-shadow btn btn-social btn-pinterest\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Share with Pinterest\" target=\"_blank\" rel=\"nofollow\" href=\"https://pinterest.com/pin/create/bookmarklet/?media=$Fullimageurl&url=$url&is_video=[is_video]&description=$Custom\"><i class=\"fa fa-pinterest fa-2x\"></i></a></li>
</ul>
</div>
</div>";  

echo $output;
?>
