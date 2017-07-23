<?=getHead($meta)?>
<?=getHeader()?>
<?php
loadHelper(TEMPLATE);
?>

<div class="pageheadline">
    <div class="container">
        <div class="row">
            <div class="span6">
                <h1><?= $page['name'] ?></h1>
                <?=getBreadcrumbs()?>
            </div>
            <div class="span6">
                <ul class="ch-grid1">
                    <li>
                        <div class="ch-item ch-img-1">
                        </div>
                    </li>
                    <li>
                        <div class="ch-item ch-img-2">
                        </div>
                    </li>
                    <li>
                        <div class="ch-item ch-img-3">
                        </div>
                    </li>
                </ul>
            </div>
        </div></div>
</div>

<div class="container">
    <div class="row">
        <div class=" borderbottom span12">

            <div class="row">
                <div class="span8"><!--left-->
                    <div class="">
                        <div class="columnheadlineabout">
                            <h4><span><?= $page['name'] ?></span></h4>
                        </div>

                        <h5><?= $page['description'] ?></h5>
                        <p>
                            <?= $page['content'] ?>
                        </p>

                        <!-- comment-form -->
                        <div class="row">
                            <form method="post" action="" id="contact-us-form">
                                <div>
                                    <div id="main">
                                        <div class="span8">
                                            <div class="comment1">
                                                <p><input type="text" placeholder="Your name" name="name" id="name" class="commentfield" />
                                                </p>
                                            </div>
                                            <div class="comment2">
                                                <p> <input type="text" placeholder="Your e-mail address" name="email" id="email" class="commentfield" />
                                                </p>
                                            </div>
                                            <div class="comment3">
                                                <p> <input type="text" placeholder="Subject" name="subject" id="subject" class="commentfield" />
                                                </p>
                                            </div>
                                        </div>
                                        <div class="span8 textarea">
                                            <p><textarea name="message" placeholder="Your message" id="comments" rows="12" cols="5" class="textarea"></textarea>
                                            </p>
                                            <div class="buttoncontact">
                                                <p><input type="submit"   value="Submit"/>
                                                </p>
                                            </div>
                                        </div>
                                        <ul class="span8" id="response"></ul>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- comment-form-end -->
                    </div><!--leftabout end-->
                </div><!--span8 left end-->

                <aside class="span4"><!--right-->
                    <?=getRightSidebar()?>
                </aside><!--/span4 rightend-->
            </div><!--/row end-->
        </div><!--/borderbottom end-->
    </div><!--/row end-->


    <div class="row">
        <div class="span12">

            <div class="wrapper100percent map">
                <div class="mapoverlay" onClick="style.pointerEvents='none'"></div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1942.7764979161789!2d30.731064803653894!3d46.478393747655346!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40c631907a589dbf%3A0x64fc7bb0d06e34e2!2z0LLRg9C70LjRhtGPINCf0YDQtdC-0LHRgNCw0LbQtdC90YHRjNC60LAsIDM1LCAzLCDQntC00LXRgdCwLCDQntC00LXRgdGM0LrQsCDQvtCx0LvQsNGB0YLRjA!5e0!3m2!1sru!2sua!4v1500448964279" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>                </iframe>
            </div>

        </div><!--/span12 end-->
    </div><!--/row end-->


</div>

<?=getFooter()?>
<!--<script type="text/javascript">
    $(document).ready(function() {
        $("#contact-us-form").submit(function() {
            $.ajax({
                type: "POST",
                url: '/ajax/send_mail_to_template/',
                data: $(this).serialize()
            }).done(function() {
                $(this).find("input").val("");
                alert("well done!");
                if ( $("#contact-us-form").valid() ){
                    noty();
                }
                $("#contact-us-form").trigger("reset");
            });
            return false;
        });
    });
</script>-->

