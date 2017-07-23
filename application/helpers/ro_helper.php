<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function getTeamBlock($item, $class = "team-col"){
    $url = getFullUrl($item);
    ?>
    <div class="<?=$class?>">
        <div class="team-member">
            <?php if($item['image'] != '') { ?>
            <a href="<?=$url?>" class="image">
                <img src="<?=CreateThumb(350,350,$item['image'],'350x350')?>" alt="<?=$item['name']?>">
            </a>
            <?php } ?>
            <div class="team-member-info">
                <a href="<?=$url?>"><h3 class="text-center"><?=$item['name']?></h3></a>
                <p class="text-center"><?=strip_tags($item['short_content'])?></p>
                <!--div class="social-media-icon text-center">
                    <ul>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div-->
            </div>
        </div>
    </div>
    <?php
}

function getReviewBlock($item, $class = 'col-md-4 col-sm-6 col-xs-12'){
    $html = '';
    ob_start();
    ?>
    <li class="<?=$class?>">
        <div class="testimonial-box">
            <div class="testimonial-info">
                <div class="author-pic">
                    <?php if($item['image'] != '') { ?>
                            <img src="<?=cropImage($item['image'],350,350);?>" alt="<?=$item['name']?>" />
                    <?php } else { ?>
                        <img src="/img/noavatar.png" alt="<?=$item['name']?>">
                    <?php } ?>
                </div>
                <h3><?=$item['name']?> <span class="country"><?=strip_tags($item['short_content'])?></span></h3>
            </div>
            <div class="testimonial-content">
                <?=$item['content']?>
            </div>
        </div>
    </li>
    <?php
    $html = ob_get_contents();
    ob_clean();
    return $html;
}